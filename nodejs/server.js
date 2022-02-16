const express = require("express");
const app = express();
const server = require('http').Server(app);
const io = require('socket.io')(server);
const morgan = require('morgan');
const cookieParser = require('cookie-parser');
const redis = require('redis');
const util = require("util");
const easyrtc = require("easyrtc");
const fs = require("fs");
const dotenv = require('dotenv');
const group_leader = [];
const server_user = {}; 


const webServer = server.listen(8890, function(){
    console.log('Connected to : 8890');
});

const socketServer = io.listen(webServer, {'log level':1});
easyrtc.setOption("logLevel", "debug");

app.use(morgan('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser(process.env.COOKIE_SECRET));

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
//const rtc = easyrtc.listen(httpApp, socketServer, null, function(err, rtcRef) {
const rtc = easyrtc.listen(app, socketServer, null, function(err, rtcRef) {
    rtcRef.events.on("roomCreate", function(appObj, creatorConnectionObj, roomName, roomOptions, callback) {
        appObj.events.defaultListeners.roomCreate(appObj, creatorConnectionObj, roomName, roomOptions, callback);
    });  
});

const socketStore = {};
io.sockets.on('connection', function (socket) {

    socket.emit('userConnect', socket.id);

    const redisClient = redis.createClient();
    redisClient.subscribe('create_user');
    redisClient.on("message", function(channel, message) {
        const data = JSON.parse(message); // {email:'',socket_id:''}
        server_user.push(data);
        socketStore[data.email] = data.socket_id;
        console.log('socketStore', socketStore);
    });
    socket.on('disconnect', function() {
        redisClient.quit();
    });

    socket.on("userCreate",function(user){
        server_user[user.email]=user;
        io.emit('info_serverUser', server_user);
    });

    socket.on("roomCreate", function(room_id) {
        io.sockets.connected[socket.id].join(room_id);
        group_leader[room_id] = socket.id;
    });

    socket.on("roomInvite", function(user, room_id) {
        if(!isNullChk(io.sockets.connected[user.id])){
            io.sockets.connected[user.id].emit("roomInvite", user, room_id);
        }else{
            socket.emit("userNotLoggedIn", user);
        }
    });

    socket.on("roomTogether", function(user, room_id, status) {
        if (status == 1) {
            io.sockets.connected[user.id].join(room_id);
        }
        //화상,음성채팅시작
        io.sockets.in(room_id).emit('roomStart', user);  
    });

    // 7
    socket.on("roomMsg", function(room_id, msg) {
        io.sockets.in(room_id).emit("roomMsg", msg);
    })

    socket.on("roomEvent", function(room_id, message_type, event_room) {
        if (group_leader[room_id] == socket.id) {
            if (message_type == "bounds"){
                socket.broadcast.to(room_id).emit("roomEvent", getUserRoom(room_id), message_type, event_room);
            } else if(message_type == "streetview") {
                    socket.broadcast.to(room_id).emit("roomEvent", getUserRoom(room_id), message_type, event_room);
            } else {
                console.log('message_type', message_type);
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
    const user = [];
    for (const key in io.sockets.adapter.rooms[room_id]) {
        if (io.sockets.adapter.rooms[room_id][key] == true) {
            user.push(key);//
        }
    }
    return user;
}

module.exports = isNullChk;