<?php
    include 'head.php';

    // direct access
    $pin = isset($pin_id)?$pin_id:'';
    $lat = isset($lat)?$lat:'';
    $lng = isset($lng)?$lng:'';
?>
<script>
$(function(){

    $("#chatFrm_room_id").val("<?= Input::get('room_id')?>");
    $("#chatFrm_subscriber").val("<?= Input::get('subscriber')?>");
    $("#chatFrm_pin_id").val("<?= Input::get('pin_id')?>");
    //$("#location").val("<?=Input::get('location')?>");

    // invite with url 
    if('<?=isset($direct_access)?>'){
        quickView('<?=$pin?>');     
    }

});

</script>
<html lang="en-US"> 
<head>
    <!--<meta charset="UTF-8"/>-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body onunload="" class="map-fullscreen page-homepage navigation-off-canvas" id="page-top">
<!-- Outer Wrapper-->
<div id="outer-wrapper">
    <!-- Inner Wrapper -->
    <div id="inner-wrapper">
        <!-- Navigation-->
        <?php include 'top.php'; ?>
        <!-- end Navigation-->
        <!-- Page Canvas-->
        <div id="page-canvas">
            <!--Off Canvas Navigation-->
            <nav class="off-canvas-navigation">
                <header>Navigation</header>
                <div class="main-navigation navigation-off-canvas" id="navi_list">
                </div>
            </nav>
            <!--end Off Canvas Navigation-->
            <!--Page Content-->
            <div id="page-content">
                <!-- Map Canvas-->
                <div class="map-canvas list-width-30">
                    <!-- Map -->
                    <div class="map">
                        <div class="toggle-navigation">
                            <div class="icon">
                                <div class="line"></div>
                                <div class="line"></div>
                                <div class="line"></div>
                            </div>
                        </div>
                        <!--/.toggle-navigation-->
                        <div id="map" class="has-parallax"></div>
                        <div id="pano">
                            <div class="pano-handle">DRAG THIS WINDOW HOLDING HERE!</div>
                            <div class="item-time">
                                <div class="circle"></div>
                                <div class="circle-text" id="circleText"></div>
                                <div class="circle-text-down">seconds</div>
                            </div>
                            <div class="alert-close"><img src="<?=url()?>/assets/img/close.png"></div>
                        </div>

                        <!--/#map-->
                        <div class="search-bar horizontal">
                            <form class="main-search border-less-inputs" role="form" id="searchFrm" method="post">
                                <div class="input-row">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <div class="input-group location">
                                            <input type="text" class="form-control" id="location" placeholder="Enter Location">
                                            <span class="input-group-addon"><i class="fa fa-map-marker geolocation" data-toggle="tooltip" data-placement="bottom" title="Find my position"></i></span>
                                        </div>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <select name="category" id="mapCategory" multiple title="Select Category" data-live-search="true">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="keyword" placeholder="Enter Keyword">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <button type="button" id="searchBtn" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.input-row -->
                            </form>
                            <!-- /.main-search -->
                        </div>
                        <!-- /.search-bar -->
                    </div>
                    <!-- end Map -->
                    <!--Items List-->
                    <div class="items-list scrollbar-inner">
                        <div class="inner">
                            <header>
                                <h3>Current Talk List</h3>
                            </header>
                            <ul class="results list"></ul>
                        </div>
                    </div>
                    <!--end Items List-->
                    <!--Chatting window-->
                    <div class="chatting-window" id="chatting-window">
                        <div class="inner">
                            <header>
                                <h3>Chatting!</h3>
                            </header>
                            <div class="chatting-div">
                                <div class="chatting-section">
                                    <div id="videoContainer">
                                        <div id="connectControls" style="height:0px;">
                                            <div id="iam" style="display:none">Not yet connected...</div>
                                            <div id="otherClients" style="display:none"></div>
                                        </div>
                                        <div id="videos">
                                            <div class="selfDiv">
                                                <video autoplay="autoplay" class="easyrtcMirror" id="selfVideo" muted="muted" volume="0" ></video>
                                            </div>
                                            <div class="callerDiv">
                                                <video autoplay="autoplay" id="callerVideo"></video>
                                            </div>
                                            <img src='<?=url()?>/assets/img/sunny-suite.png' class='repVideoImg'>
                                        </div>
                                    </div>         
                                </div>
                                <div class="chatting-section">
                                    <div id="msgContainer">
                                        <div id="msgDiv" class="scrollbar-inner"></div> 
                                    </div>
                                </div>    
                                <div class="clr"></div>
                                <div class="chatting-section">
                                    <div class="msgRow">
                                        <div class="msgInput">  
                                            <div class="form-group large">
                                                <input type="text" class="form-control" id="inputMsg" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="msgBtn">    
                                            <button type="button" id="btnSendMsg" class="btn btn-default btn-medium">Send</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clr"></div>
                                <div class="chattingFloor">
                                    <div class="ctrlBtn">
                                        <button type="button" id="btnCtrl" class="btn btn-default btn-medium">Control</button>
                                        <button type="button" id="btnCloseStreet" class="btn btn-default btn-medium dpNone">Close Street</button>
                                        <button type="button" id="btnTalkClose" class="btn btn-default btn-medium">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end Chatting window-->
                    <!--foursquare single pin on left side-->
                    <div class="chatting-window" id="pin-info-window">
                        <div class="inner">
                            <header>
                                <h3>Pins Information</h3>
                            </header>
                            <div class="pin-info-div scrollbar-macosx" id="fourPinInfo">
                            </div>
                        </div>
                    </div>
                    <!--end foursquare single pin on left side-->
                </div>
                <!-- end Map Canvas-->
            </div>
            <!-- end Page Content-->
        </div>
        <!-- end Page Canvas-->
        <?php include 'bottom.php'; ?>
    </div>
    <!-- end Inner Wrapper -->
</div>
<!-- end Outer Wrapper-->

<!--<div class="pinPop"></div>-->

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

// map use count
var mapUse = {};
var streetTimer = {};

$(function(){   

    mapUse = new mapUseCnt('<?=Session::get('use_cnt')?>'); 
    streetTimer = new streetviewOpenTimer();

    $( "#pano" ).draggable({ handle: "div.pano-handle" });
    
    // load map pins then check those pins belong to map boundary
    var onLoadMap = function(id, keyword, category){

        var param = {'id': id, 'keyword': keyword, 'category': category};

        // if direct access
        var lat = isNull('<?=$lat?>',_latitude);
        var lng = isNull('<?=$lng?>',_longitude);

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
                createHomepageGoogleMap(lat,lng,data);

            }
        });

    }

    // pin category
    var onLoadCategory = function(){
        
        $.ajax({
            type: "GET",
            url: base_url+'/callCdListByGrp',
            data: {'connectCd': 'category'},
            success: function( data ) {
                $.each(data,function(i,d){
                    var cls = (d.level==3)?'sub-category':'';
                    var item = "<option value='"+d.cd+"' class='"+ cls + "'>"+d.cd_nm+"</option>";
                    $("#mapCategory").append(item);
                    $("#mapCategory").selectpicker('refresh');
                });
            }
        });
    }

    // onload
    onLoadMap();
    onLoadCategory();

    // Set if language is RTL and load Owl Carousel
    var rtl = false; // Use RTL
    initializeOwl(rtl);

    var autocomplete = '';
    // when searching, recommend keywords right underneath of search input
    autoComplete();
    
    // get invite message on some other pages.
    if(_chat){ // true
        $('.map .toggle-navigation').trigger('click');  // close
        $('.map .toggle-navigation').trigger('click');  // open 
    }

    // check member or not
    var checkMember = function(){
        if(!'<?=Auth::check()?>'){
            location.href= base_url + '/auth/login';            
        }
    };

    
    // Events
    // map 검색시 현재 리스트업되어있는 map상의 것들중에서 검색.
    $("#searchBtn").off('click').on('click',function(){
        
        $.alertWindow.init({
            'title': "It's not working now!",
            'content': "We are working on it! <br><br> Fortunately, <b>searching location</b> is on service now! <br> Just enter where you want to, then select the place on searched list! ",
            'btn': '<button type="button" class="btn btn-default btn-large">Close</button>'
        }, function () {
            $('.alert-window .alert-btn :button:eq(0)').on('click', function () {
                $.alertWindow.close();
                return false;
            });
        });

        //onLoadMap('',$("#keyword").val(), $("#mapCategory").val() );
    });

    $("#keyword").keypress(function(event) {
        if(event.which == 13) {
            $("#searchBtn").trigger('click');
        }
    });

    //$.chatGuideWindow.init();

    window.onLoadMap = onLoadMap;
    window.checkMember = checkMember;
});



</script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->


</body>
</html>
