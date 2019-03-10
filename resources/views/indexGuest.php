<?php
    include 'head.php';

    // url로 직접 초대 
    $pin = isset($pin_id)?$pin_id:'';
    $lat = isset($lat)?$lat:'';
    $lng = isset($lng)?$lng:'';

    // 등록 후 
    $key = isset($key)?$key:'';

?>

<style>

div.tab {
    /*overflow: hidden;*/
    border-bottom: 1px solid #ddd;
    /*background-color: #f1f1f1;*/
    height:53px;
    margin-bottom:20px;
    margin-top:10px;
}

div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    font-family:'Dosis'; 
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #f1f1f1;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ddd;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 0px;
    /*border: 1px solid #ccc;*/
    border-top: none;
}

.scroll-element.scroll-x {
    display: none !important;
}

.item-detail-close img {
    cursor:pointer;
}


</style>

<html lang="en-US"> 
<head>
    <!--<meta charset="UTF-8"/>-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body onunload="" class="map-fullscreen page-homepage navigation-off-canvas" id="page-top">

<?php include 'top_nologo.php'; ?>

<div class="wrap-search-idx">
    <div class="search-exp">
        <div class="left">
            <span class="txt">JUST TALK WHAT YOU SEE ABOUT!</span>
            <span class="exp">EXCERCISE LANGUAGES YOU'VE LEARNED!</span>
        </div>
        <div class="right">
            <span class="beta">BETA</span>
        </div>
    </div>
    <div class="clr"></div>
    <div class="search-content">
        <div class="search-input">
            <a href="/"><img src="<?=url()?>/assets/img/talkingPin.png"></a>
            <input type="text" placeholder="where to go?" id="simLocation" autocomplete="on" name="location">
            <span class="search-geo"><i class="fa fa-map-marker geolocation" data-toggle="tooltip" data-placement="bottom"></i></span>
            <span class="search-close"><img src="<?=url()?>/assets/img/icon-close-16.png"></span>
            <div class='clr'></div>
        </div>
    </div>
</div>    
<div class="wrap-search-map map-simple">
    <div id="map-simple" class="search-map"></div>
    <div class="pin-exp">      
        <div class="inner">
            <div class="pin-info-div scrollbar-macosx" id="fourPinInfo">
                <div class="chattingFloor" style="padding-bottom:30px;">
                    <button type="button" id="btnPinInfoClose" class="btn btn-default btn-medium">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrap-search-list">
    <div class="search-list" id="search-items"></div>
    <div class="clr"></div>
    <div class="item-detail" id="item-detail">
        <div class="item-detail-close">
            <img src="<?=url()?>/assets/img/close.png">
        </div>
        <div class="item-title"></div>
        <div class="item-host">
            <div class="item-host-avatar"><img src="<?=url()?>/assets/img/member-5.jpg"></div>
            <div class="item-host-text">
                <div class="item-host-name"></div> 
                <div class="item-host-exp"></div>
                <div class="item-host-address"></div>
                <div class="item-direct"></div>
            </div>
            <div class="item-host-pintalk">
                <button type="button" id="btnPintalk" class="btn btn-default btn-large">PINTALK</button>
                <input type="hidden" id="pin_sno">
            </div>
        </div>
        <div class="clr"></div>
        <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'description')">DESCRIPTION</button>
        <button class="tablinks" onclick="openCity(event, 'foursquare')">FOURSQUARE</button>
        <!--<button class="tablinks" onclick="openCity(event, 'youtube')">YOUTUBE</button>-->
        </div>
        <div class="clr"></div>
        <!--Description-->
        <div id="description" class="tabcontent">
            <div class="item-content"></div>
        </div>
        <!--End of Description-->

        <!--Foursquare pins-->
        <div id="foursquare" class="tabcontent four-pin-list">
            <div class="scrollbar-macosx">
                <ul id="fourList"></ul>
            </div>
        </div>
        <!--End of foursquare pins-->

        <!--youtube-->
        <div id="youtube" class="tabcontent">

        </div>
        <!--End of youtube-->
        
    </div>

    <div class="item-modify">
        <button type="button" id="btnModify" class="btn btn-default btn-large">Modify</button>
    </div>

</div>


<div id="pano" style="display:none"></div>

<form name="entryFrm" id="entryFrm" action="entry" method="post">
    <input type="hidden" name="lat" id="lat">
    <input type="hidden" name="lng" id="lng">    
</form>



<!-- end Page Canvas-->


<script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/infobox.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/richmarker-compiled.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/markerclusterer.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/custom.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/maps.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/leaflet.js"></script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->



<script>
var $ = jQuery.noConflict();
//var map = {};
$(function(){    

    /*
    // popup
    $.popUpInDays.init({
        'content' : '<img src="' + base_url + '/assets/img/ad_pintalk.jpg">',
        'btn':"<span style='text-align:center'>I'm not a Korean. I'm not interested in!</span><br><br><button type='button' class='btn btn-default btn-large btnGapRight'>Not open it today!</button><button type='button' class='btn btn-default btn-large'>Close</button>"
    },function(){
        $('.pop-up-days .alert-btn :button:eq(0)').on('click',function(){
            $.popUpInDays.setCookie("username", _user, _days);
            $.popUpInDays.close();
            return false;
        });
        $('.pop-up-days .alert-btn :button:eq(1)').on('click',function(){
            $.popUpInDays.close();
            return false;
        });
    });
    */

    // tour(guide)
    var tour = new tourForInvitation();
    tour.init([
        {
            target  : '.navigation-items',
            position: 'left',
            content : 'Please, login first!',
            autoFocusLastButton:false,
            buttons : [
                {
                    text: 'Hide Steps',
                    click: function(anno, evt){
                        tour.tourDisabled(anno);
                    }
                },
                AnnoButton.DoneButton
            ]
        },
        {
            target  : '.navigation-items .submit-item',
            position: { top:'0px', right:'50px'},
            arrowPosition: 'center-right',
            content : 'Before inviting your friends, create your chat room first! Please, click red button!',
            autoFocusLastButton:false,
            buttons : [
                {
                    text: 'Hide Steps',
                    click: function(anno, evt){
                        tour.tourDisabled(anno);
                    }
                },
                AnnoButton.DoneButton
            ]
        }
        
    ]);

    if(_email!='' && '<?=$key?>'=='' && '<?=$pin?>'==''){
        tour.doNext();
    }
    
    // After inserting a pin
    if('<?=$key?>'){

        $.alertWindow.init({
            'title': 'You can invite your guest!',
            'content': "Please send this url to your guest, the guest can go directly to your page!<br><br><span style='background-color:yellow !important'><?=url()?>/pin/<?=$key?></span>",
            'btn': '<button type="button" class="btn btn-default btn-large">Close</button>'
        }, function () {
            $('.alert-window .alert-btn :button:eq(0)').on('click', function () {
                $.alertWindow.close();
                return false;
            });
        });

        // 저장 후 게스트에게 보낼 url 팝업으로 보여줄때, 
        var tourDataWithKey = [
            {
                target  : '.alert-window .alert-pop',
                position: 'right',
                content : 'Please, send this url to your friend!',
                autoFocusLastButton:false,
                buttons : [
                    {
                        text: 'Hide Steps',
                        click: function(anno, evt){
                            tourKey.tourDisabled(anno);
                        }
                    },
                    AnnoButton.DoneButton
                ]
            }
        ];

        $(".anno-overlay").remove();
        var tourKey = new tourForInvitation();
        tourKey.init(tourDataWithKey);
        tourKey.doit();

    }

    // invite with url 
    if('<?=isset($direct_access)?>'){
        makeContent('<?=$pin?>');    
        _latitude = '<?=$lat?>';
        _longitude = '<?=$lng?>'; 

    }

    // scrollbar
    $('.scrollbar-macosx').scrollbar();
    $('.scrollbar-macosx').css('max-height','400px');
    $('.pop-up-days .modal-pop-wrapper').css('top','100px');
    $('.pop-up-days .scrollbar-macosx').css('max-height','600px');

    $("#simLocation").keypress(function(event) {
        if(event.which == 13) {
            event.preventDefault();
            if(!isNullChk(tour)){
                tour.doAllClose();
            }
        
            /*
            $("html, body").animate({ scrollTop: 210 }, 2000, "swing");
            $("#map-simple").animate({height:'400'},500,"swing",function(){
                    google.maps.event.trigger(cMap.map, "resize");               
                }); 
            $(".wrap-search-list").css("display",'block');
            */
        }
    });

    
    // load map pins then check those pins belong to map boundary
    var cMap = new createSearchMap();
    var onLoadMap = function(p_id, p_zoom, callback){

        // if direct access
        var lat = _latitude;
        var lng = _longitude;
        var param = {};
        if(p_id){
            param = {'id':p_id};
        }
        var zoom = 13;
        if(p_zoom){
            zoom = p_zoom;
        }

        $.ajax({
            type: "GET",
            url: base_url+'/callPins',
            data: param,
            success: function( data ) {

                // 마커가 한개일때..다이렉트나..혹은 마커하나인 경우,
                if(data.data.length==1){
                    lat = data.data[0].latitude;
                    lng = data.data[0].longitude;
                }
                
                cMap.run(lat,lng,data,zoom);

                if(typeof(callback)=='function'){
                    callback(cMap.map);
                }
            }
        });
    }
    onLoadMap();

    $(".search-close").on('click',function(){
        $("#simLocation").val('');
        $("#simLocation").focus();
        if($(".wrap-search-list .item-detail").css("display")=='block'){
            $(".wrap-search-list .item-detail-close").trigger('click');
        }
    });


    var fourMarkers = [];
    var fourLinePos = [];
    var youtubes = [];
    function makeContent(id){

        fourMarkers = [];
        $("#search-items").css("display","none");
        $("#fourList").html('');

        // 다이렉트로 온 경우, pintalk 버튼을 눌러 대화를 시작할 수 있도록 가이드
        var tourDirect = new tourForInvitation();
        if('<?=isset($direct_access)?>'){
            var tourDataWithDirect = [
                {
                    target  : '#btnPintalk',
                    position: { top:'70px', right:'-300px' },
                    arrowPosition: 'center-left',
                    content : "Please click 'pintalk' to talk with your friend!",
                    autoFocusLastButton:false,
                    buttons : [
                        {
                            text: 'Hide Steps',
                            click: function(anno, evt){
                                tourDirect.tourDisabled(anno);
                            }
                        },
                        AnnoButton.DoneButton
                    ]
                }
            ];
            tourDirect.init(tourDataWithDirect);
        }


        $.ajax({
            type: "GET",
            url: base_url+'/callPinDetail',
            data: {'id': id },
            success: function( data ) {

                $("#map-simple").animate({height:'400'},500,"swing",function(){
                    google.maps.event.trigger(cMap.map, "resize");               
                }); 
                onLoadMap(id,14,function(){

                    if(data.board && data.board.length>0){
                        var content = data.board[0].content;
                        //content = content.replace(/uploadImages/g, '<?=$fileDir?>');
                        $(".item-title","#item-detail").html(data.board[0].title);
                        $(".item-content","#item-detail").html(content);
                        $(".item-host .item-host-name").html(data.board[0].name);
                        $(".item-host .item-host-name").wrap("<a href='#' id='avatarLink'/>");
                        $("#avatarLink").off('click').on('click', function(){
                            
                            $.ajax({
                                type: "post",
                                url: base_url+'/subscriberInfo',
                                data: {'email':data.board[0].email},
                                success: function( data ) {
                                    personInfoPop(data);
                                }
                            });
                        });
                        $(".item-host .item-host-exp").html(data.board[0].aboutme);
                        $(".item-host .item-host-address").html(data.board[0].address);
                        $(".item-host .item-direct").html('Direct url : <?=url()?>/pin/'+id);
                        if(isNullChk(data.board[0].facebook_id)){
                            $(".item-host .item-host-avatar img").attr("src", _fileProfileDir + data.board[0].avatar);          
                        }else{
                            $(".item-host .item-host-avatar img").attr("src", data.board[0].avatar);                  
                        }
                        $(".item-host .item-host-avatar img").wrap("<a href='" + data.board[0].link + "' target='_blank'>");
                        $("#pin_sno").val(data.board[0].sno);

                        // 로드 후, 3초 후 가이드 뜨도록 처리
                        if(tourDirect.getCookie()=='1'){
                            setTimeout(function(){
                                tourDirect.doit();
                            },3000);
                        }
                    }

                    youtubes = [];
                    if(data.board_pin && data.board_pin.length>0){
                        $.each(data.board_pin, function(i,d){
                            makeFourContent(i,d,data);
                        });
                    }

                    if(data.board[0].owner=="<?=Session::get('email')?>"){
                        $(".wrap-search-list .item-modify").css("display","block");
                    }

                    
                    

                    /*
                    var flightPath = new google.maps.Polyline({
                        path: fourLinePos,
                        geodesic: true,
                        strokeColor: '#999',
                        strokeOpacity: 0.7,
                        strokeWeight: 5
                    });

                    flightPath.setMap(cMap.map);
                    */

                });
            }
        });

        // 대화시작
        $("#btnPintalk").off('click').on('click', function(){
            window.location.href = '<?=url()?>/direct/' + $("#pin_sno").val();
        });

        // update
        $("#btnModify").off('click').on('click', function(){
            window.location.href = '<?=url()?>/indexHost/' + $("#pin_sno").val();
        });

        // close detail window
        $(".wrap-search-list .item-detail-close").off('click').on('click',function(){
            onLoadMap();
            $(".wrap-search-list .item-detail").css("display","none");
            $(".wrap-search-list .item-modify").css("display","none");
            $("#search-items").css("display","block");
            $(".pin-exp").exists(function(){
                this.animate({left:'-500px'},500);
            });
            youtubes = [];
        });

        $(".wrap-search-list .item-detail").css("display","block");
        $(".wrap-search-list .item-detail .tab button:eq(0)").trigger('click');
        

    }

    var youtubeTpl = "<iframe class='video w100' width='640' height='360' src='//www.youtube.com/embed/{{videoid}}' frameborder='0' allowfullscreen></iframe><input type='hidden' name='yPinId[]' value='{{pinid}}'><input type='hidden' name='yTitle[]' value='{{title}}'><input type='hidden' name='yVideoId[]' value='{{videoid}}'>";

    function makeFourContent(i,data,tData){
        
        var tpl = $("#fourPinListTplForIndexGuest").html();
        tpl = tpl.replace(/{{idx}}/g, i+1);
        tpl = tpl.replace(/{{pinid}}/g, data.pin_id);
        tpl = tpl.replace(/{{title}}/g, data.pin_name);
        tpl = tpl.replace(/{{link}}/g, 'https://foursquare.com/venue/'+data.pin_id);
        tpl = tpl.replace(/{{category}}/g, data.category_name);
        
        var img = '';
        if(tData.board_pin_photo && tData.board_pin_photo.length>0){
            var idx = 0;
            $.each(tData.board_pin_photo, function(j,d){
                if(idx<4){
                    if(data.pin_id==d.pin_id){
                        img += '<img src="'+d.url+'">';
                        idx++;
                    }
                }
            });
        }
        tpl = tpl.replace(/{{images}}/g, img);  
        tpl = tpl.replace(/{{address}}/g, data.address);
        tpl = tpl.replace(/{{checkins}}/g, 'Checkin ' + data.checkin_cnt);
        tpl = tpl.replace(/{{rating}}/g, isNull(data.rating,''));

        
        if(tData.board_pin_comment && tData.board_pin_comment.length>0){

            var tipTpl = ''; 
            $.each(tData.board_pin_comment,function(k,kvalue){

                if(data.pin_id==kvalue.pin_id){
                    tipTpl = 
                    '<div class="pin-user-div">' + 
                        '<div class="pin-comment-user">{{user}}</div>' + 
                        '<div class="pin-comment-date">{{date}}</div>' + 
                    '</div>' + 
                    '<div class="pin-comment-text">{{comment}}</div>';

                    tipTpl = tipTpl.replace(/{{user}}/g, kvalue.user);  
                    tipTpl = tipTpl.replace(/{{date}}/g, kvalue.write_dt);  
                    tipTpl = tipTpl.replace(/{{comment}}/g, kvalue.comment); 
                }
            });
            tpl = tpl.replace(/{{tip}}/g, tipTpl);  

            if($("#fourList").length>0){
                $("#fourList").append(tpl); 
            }  
        }else{
            if($("#fourList").length>0){
                $("#fourList").append(tpl); 
            }  
            $(".comment-div-"+i).css("display","none");
        }

        if(_youtube){
            var ytpl = youtubeTpl;      
            $.each(tData.board_pin_youtube, function(yidx, yitem) {
                if(yitem.pin_id == data.pin_id){
                    /*
                    ytpl = ytpl.replace(/{{pinid}}/g, yitem.pin_id);
                    ytpl = ytpl.replace(/{{title}}/g, yitem.title);
                    ytpl = ytpl.replace(/{{videoid}}/g, yitem.video_id);

                    $("#youtube-div-"+yitem.pin_id).append(ytpl);
                    $(".video").css("width", '400');
                    */
                    youtubes.push(yitem);
                }
            });
        }

        
        // map set
        var idx = i + 1;
        var icon = data.icon;
        var markerContent = document.createElement('DIV');
        markerContent.innerHTML =
            '<div class="map-marker color">' +
            '<div class="icon2">' +
            //'<img src="'+ icon + '">' +
            '<div class="markerIdx">' + idx + '<div>' +
            '</div>' +
            '</div>';

        var marker = new RichMarker({
            position: new google.maps.LatLng(data.lat, data.lng),
            map: cMap.map,
            draggable: false,
            content: markerContent,
            flat: true
        });

        marker.content.className = 'marker-loaded';
        fourMarkers.push(marker);
        fourLinePos.push({'lat': Number(data.lat), 'lng': Number(data.lng)});


        google.maps.event.addListener(marker, 'click', (function (i, data, idx) {
            return function () {
                //window.open('https://foursquare.com/venue/' + d.id, '_blank');
                $(".pin-exp").exists(function(){
                    this.animate({left:'0px'},500);
                });

                if($("#fourPinInfo").length>0){
                    $("#fourPinInfo").html('');
                }
                singlePin(idx, data, tData);
            }
        })(i, data, idx));

        // indexGuest 상세 
        $(".four-list-"+i).hover(
            function () {
                if (fourMarkers[i-1].content) {
                    fourMarkers[i-1].content.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded marker-active';
                }
            },
            function () {
                if (fourMarkers[i-1].content) {
                    fourMarkers[i-1].content.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
                }
            }
        );

    }

    

    var singlePin = function(idx, data, tData){

        var address = '';
        $("#fourPinInfo").html('');
        selectedMarkerOn(idx);
        var obj = data;
        if(tData.board_pin && tData.board_pin.length>0){
            $.each(tData.board_pin,function(i,d){
                if(data.pin_id==d.pin_id){
                    obj.title = d.pin_name;
                    obj.rating = d.rating;
                    obj.link = 'https://foursquare.com/venue/' + d.pin_id;
                    obj.category = d.category_name;

                }
            });
        }
        
        var img = '';
        if(tData.board_pin_photo && tData.board_pin_photo.length>0){
            var pIdx=0;
            $.each(tData.board_pin_photo, function(j,d){
                if(pIdx<4){
                    if(data.pin_id==d.pin_id){
                        img += '<img src="'+d.url+'">';
                        pIdx++;
                    }
                }
            });
        }

        if(tData.board_pin_comment && tData.board_pin_comment.length>0){

            var tipTpl = ''; 
            $.each(tData.board_pin_comment,function(k,kvalue){

                if(data.pin_id==kvalue.pin_id){
                    tipTpl = 
                    '<div class="pin-user-div">' + 
                        '<div class="pin-comment-user">{{user}}</div>' + 
                        '<div class="pin-comment-date">{{date}}</div>' + 
                    '</div>' + 
                    '<div class="pin-comment-text">{{comment}}</div>';

                    tipTpl = tipTpl.replace(/{{user}}/g, kvalue.user);  
                    tipTpl = tipTpl.replace(/{{date}}/g, kvalue.write_dt);  
                    tipTpl = tipTpl.replace(/{{comment}}/g, kvalue.comment); 
                }
            });

        }else{
            $(".comment-div-"+i).css("display","none");
        }

        var tpl = $("#fourNativeSinglePinTpl").html();

        tpl = tpl.replace(/{{idx}}/g, idx);
        tpl = tpl.replace(/{{title}}/g, data.title);
        tpl = tpl.replace(/{{link}}/g, data.link);
        tpl = tpl.replace(/{{rating}}/g, data.rating);
        tpl = tpl.replace(/{{address}}/g, data.address);
        tpl = tpl.replace(/{{category}}/g, data.category);
        tpl = tpl.replace(/{{img}}/g, img);
        tpl = tpl.replace(/{{pinid}}/g, data.pin_id);
        tpl = tpl.replace(/{{pinLat}}/g, data.lat);
        tpl = tpl.replace(/{{pinLng}}/g, data.lng);
        tpl = tpl.replace(/{{comment}}/g, tipTpl);
        
        if($("#fourPinInfo").length>0){
            $("#fourPinInfo").append(tpl);
        }

        $("#fourPinInfo").append(
        '<div class="four-pin-close" style="padding-bottom:30px;">' + 
            '<button type="button" id="btnPinInfoClose" class="btn btn-default btn-medium">Close</button>' + 
        '</div>'
        );

        // close event
        $("#btnPinInfoClose").off('click').on('click',function(){
            selectedMarkerOff(self.idx);
            
            $(".pin-exp").exists(function(){
                this.animate({left:'-500px'},500);
            });

            $(".single-youtube").html('');
        });

        if(_youtube){
            var ytpl = youtubeTpl;
            $("#single-youtube-" + data.pin_id).html('');
            $.each(youtubes,function(j,dd){
                if(data.pin_id==dd.pin_id){
                    ytpl = ytpl.replace(/{{videoid}}/g, dd.video_id);
                    $("#single-youtube-" + data.pin_id).append(ytpl);
                }
            });

            $(".single-youtube").css("width", '400');
        }


    } 

    var selectedMarkerOn = function(idx){
        var idx = idx - 1;

        // 일단 닫아!
        $.each(fourMarkers, function(i,d){
            fourMarkers[i].content.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
        });

        if (fourMarkers[idx].content) {
            fourMarkers[idx].content.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded marker-active';
        }
    }

    var selectedMarkerOff = function(){
        $.each(fourMarkers, function(i,d){
            fourMarkers[i].content.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
        });
    }

    $("#simLocation").off('click').on('click',function(){
        if($(".wrap-search-list .item-detail").css("display")=='block'){
            $(".wrap-search-list .item-detail-close").trigger('click');
        }

        tour.doNext();
    });

    // googlemap javascript library limit autocomplete 할때 (You have exceeded your daily request quota for this API) 임시처리 
    function getTempCoordi(val,e){ // val-> $("#simLocation").val()
        var coordis = [];
        if(e.which == 13) {
            coordis = _tempCoordi[val].split('/');
            _latitude = coordis[0];
            _longitude = coordis[1];

            var markerContent = document.createElement('DIV');
            markerContent.innerHTML =
                '<div class="map-marker">' +
                '<div class="icon">' +
                '<img src="' + base_url + '/assets/icons/media/downloadicon.png">' +
                '</div>' +
                '</div>';

            onLoadMap('',13,function(){
                var marker = new RichMarker({
                    position: new google.maps.LatLng(_latitude, _longitude),
                    map: cMap.map,
                    draggable: true,
                    content: markerContent,
                    flat: true
                });
                marker.content.className = 'marker-loaded';
                cMap.map.setCenter(marker.getPosition());
            });

        }
    }

    // 조건에 따라, tour 를 시작할지 말지(초기로딩시)
    var tourStartWithCondition = function(){

        if(!isNullChk(tour)){

            tour.doAllClose();

            // indexGuest 
            if(_email=='' && '<?=Request::url()?>'=='<?=url()?>'){
                setTimeout(function(){
                    tour.doit();
                },500);
            }else if(_email!='' && '<?=Request::url()?>'=='<?=url()?>'){
                setTimeout(function(){
                    tour.reload();
                    tour.doNext();
                },500);    
            // indexHost    
            }else if(_email!='' && '<?=Request::url()?>'=='<?=url()?>/indexHost'){
                setTimeout(function(){
                    tour.reload();
                    tour.doit();
                },500);    
            }
        }
    }


    tourStartWithCondition();

    window.makeContent = makeContent;
    window.getTempCoordi = getTempCoordi;
    window.tour = tour;
    
});


function openCity(evt, cityName) {

    if(cityName=='youtube'){
        $.alertWindow.init({
            'title': "YouTube will be available soon!",
            'content': "We're working on now!",
            'btn': '<button type="button" class="btn btn-default btn-large">Close</button>'
        }, function () {
            $('.alert-window .alert-btn :button:eq(0)').on('click', function () {
                $.alertWindow.close();
                return false;
            });
        });

        return false;
    }


    evt.preventDefault();

    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        $(tablinks[i]).removeClass('active');
    }
    document.getElementById(cityName).style.display = "block";
    $(evt.target).addClass('active'); 
}


// check member or not
function checkMember(){
    if(!'<?=Auth::check()?>'){
        location.href= base_url + '/auth/login';            
    }
}





</script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->

<?php include 'bottom.php'; ?>

</body>
</html>
