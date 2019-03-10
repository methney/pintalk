var express = require("express");
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
//var redis = require('redis');
var util = require("util");
var easyrtc = require("easyrtc");
var fs = require("fs");
var group_leader = [];
var server_user = {}; 


var webServer = server.listen(8890, function(){
    console.log('Connected to : 8890');
});

var socketServer = io.listen(webServer, {'log level':1});
easyrtc.setOption("logLevel", "debug");


// Overriding the default easyrtcAuth listener, only so we can directly access its callback
easyrtc.events.on("easyrtcAuth", function(socket, easyrtcid, msg, socketCallback, callback) {
    easyrtc.events.defaultListeners.easyrtcAuth(socket, easyrtcid, msg, socketCallback, function(err, connectionObj){
        if (err || !msg.msgData || !msg.msgData.credential || !connectionObj) {
            callback(err, connectionObj);
            return;
        }
        connectionObj.setField("credential", msg.msgData.credential, {"isShared":false});
        //console.log("["+easyrtcid+"] Credential saved!", connectionObj.getFieldValueSync("credential"));
        callback(err, connectionObj);
    });
});

// To test, lets print the credential to the console for every room join!
easyrtc.events.on("roomJoin", function(connectionObj, roomName, roomParameter, callback) {
    easyrtc.events.defaultListeners.roomJoin(connectionObj, roomName, roomParameter, callback);
});

// Start EasyRTC server
//var rtc = easyrtc.listen(httpApp, socketServer, null, function(err, rtcRef) {
var rtc = easyrtc.listen(app, socketServer, null, function(err, rtcRef) {
    rtcRef.events.on("roomCreate", function(appObj, creatorConnectionObj, roomName, roomOptions, callback) {
        appObj.events.defaultListeners.roomCreate(appObj, creatorConnectionObj, roomName, roomOptions, callback);
    });  
});

var socketStore = {};
io.sockets.on('connection', function (socket) {

    // 1 -> 새로운 socket id를 생성하지 않도록 처리!!
    socket.emit('userConnect', socket.id);

    /*
    // redis 언젠간 쓰겠지..
    var redisClient = redis.createClient();
    redisClient.subscribe('create_user');
    redisClient.on("message", function(channel, message) {
        var data = JSON.parse(message); // {email:'',socket_id:''}
        server_user.push(data);
        socketStore[data.email] = data.socket_id;
        console.log('socketStore', socketStore);
    });
    socket.on('disconnect', function() {
        redisClient.quit();
    });
    */

    // 2
    socket.on("userCreate",function(user){
        server_user[user.email]=user;
        //3 수시로..
        io.emit('info_serverUser', server_user);
    });

    // 4
    socket.on("roomCreate", function(room_id) {
        io.sockets.connected[socket.id].join(room_id);
        group_leader[room_id] = socket.id;
    });

    // 5
    socket.on("roomInvite", function(user, room_id) {
        if(!isNullChk(io.sockets.connected[user.id])){
            io.sockets.connected[user.id].emit("roomInvite", user, room_id);
        }else{
            socket.emit("userNotLoggedIn", user);
        }
    });

    // 6
    socket.on("roomTogether", function(user, room_id, status) {
        if (status == 1) {
            io.sockets.connected[user.id].join(room_id);
        }
        //화상,음성채팅시작
        //socket.in(room_id).emit("room_cmd", user);    // 자신제외 (그밖에, broadcast)
        io.sockets.in(room_id).emit('roomStart', user);  // 방안의 모든유저
    });

    // 7
    socket.on("roomMsg", function(room_id, msg) {
        io.sockets.in(room_id).emit("roomMsg", msg);
    })

    socket.on("roomEvent", function(room_id, message_type, event_room) {
        /*
        if (message_type == "travel") {
            socket.broadcast.to(room_id).emit("roomEvent", getUserRoom(room_id), message_type, event_room);
        } else 
        */
        if (group_leader[room_id] == socket.id) {
            if (message_type == "bounds"){
                socket.broadcast.to(room_id).emit("roomEvent", getUserRoom(room_id), message_type, event_room);
            } else if(message_type == "streetview") {
                    socket.broadcast.to(room_id).emit("roomEvent", getUserRoom(room_id), message_type, event_room);
            } else {
                //console.log('message_type', message_type);
            }
        }
    });

    //제어권
    socket.on("streetCtrl",function(room_id, dataMsg){
        group_leader[room_id] = dataMsg.id;
    });

});

function isNullChk($val){
    if($val=='' || $val=='null' || $val=='undefined' || $val==undefined || $val==null){
        return true;
    }else{
        return false;
    }
}

function getUserRoom(room_id) {
    var user = [];
    for (var key in io.sockets.adapter.rooms[room_id]) {
        //console.log('-',key,'/',io.sockets.adapter.rooms[room_id][key],'/',typeof(key.sockets));
        if (io.sockets.adapter.rooms[room_id][key] == true) {
            user.push(key);//
        }
    }
    return user;
}