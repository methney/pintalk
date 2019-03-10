<!DOCTYPE html>
<html lang="en-US">
<?php
    include 'head.php';

    // direct access
    $pin = isset($pin_id)?$pin_id:'';
    $lat = isset($lat)?$lat:'';
    $lng = isset($lng)?$lng:'';
    $owner = isset($owner)?$owner:'';
    $direct = isset($direct_access)?$direct_access:'';

?>
<body>
<script>
$(function(){

    $("#chatFrm_room_id").val("<?= Input::get('room_id')?>");
    $("#chatFrm_subscriber").val("<?= Input::get('subscriber')?>");
    $("#chatFrm_pin_id").val("<?= Input::get('pin_id')?>");
    $("#owner").val("<?=$owner?>");
    $("#pin_id").val("<?=$pin?>");

    // 대화요청자만 실행 
    <?php if($direct){ ?>
      putEventToPop();
    <?php } ?>
});

</script>



<?php include 'top.php'; ?>
    


    <!-- map window -->
    <div class="m-scene" id="main"> <!-- Main Container -->

      <!-- Sidebars -->
      <!-- Right Sidebar -->
      <?php include 'right.php'; ?>
      <!-- Left Sidebar -->
      <?php include 'left.php'; ?>
      <!-- End of Sidebars -->

      <!-- Page Content -->
      <div id="content" class="page">

        <!-- Toolbar -->
        <?php include 'toolbar.php'; ?>
        
        <!-- Main Content -->
        <div class="animated fadeinup">
          
            <input type="hidden" id="location"/>
            <div id="map"></div>
        </div>
      </div> <!-- End of Page Content -->
    </div> <!-- End of Page Container -->

    <!-- chatting window -->
    <div class="m-scene" id="pin-chat-div"> <!-- Main Container -->
      <!-- Page Content -->
      <div id="content" class="page">
        <!-- Main Content -->
        <div class="animated fadeinup">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <div class="chat">
                  <ul>
                    <li class="message-right animated fadeinright">
                      <img alt="" src="img/user3.jpg">
                      <div class="message">
                        <p>
                          Hello! The brown fox jumps over.
                        </p>
                      </div>
                      <span>Seen at 08:23</span>
                    </li>

                    <li class="message-left animated fadeinright delay-1">
                      <img alt="" src="img/user2.jpg">
                      <div class="message first">
                        <p>
                          The quick, brown fox jumps over a lazy dog.
                        </p>
                      </div>
                      <div class="message">
                        <img alt="" src="img/9.jpg">
                      </div>
                      <div class="message last">
                        <p>
                          Hope to see you soon!
                        </p>
                      </div>
                    </li>
                    
                    <div class="chat-day">
                      <h6>March 27 at 6:32</h6>
                    </div>

                    <li class="message-right animated fadeinright delay-2">
                      <img alt="" src="img/user3.jpg">
                      <div class="message">
                        <p>
                          Quick, Baz, get my woven!
                        </p>
                      </div>
                      <span>Seen at 07:44</span>
                    </li>

                    <li class="message-left animated fadeinright delay-3">
                      <img alt="" src="img/user2.jpg">
                      <div class="message">
                        <p>
                          Call me now!
                        </p>
                      </div>
                    </li>

                    <li class="message-right animated fadeinright delay-4">
                      <img alt="" src="img/user3.jpg">
                      <div class="message first">
                        <p>
                          Let's watch my latest shots.
                        </p>
                      </div>
                      <div class="message last">
                        <p>
                          Ok! You're right!
                        </p>
                      </div>
                    </li>

                    <li class="message-left animated fadeinright delay-5">
                      <img alt="" src="img/user2.jpg">
                      <div class="message first">
                        <p>
                          Junk MTV quiz graced...
                        </p>
                      </div>
                      <div class="message">
                        <p>
                          Ok! You're right!
                        </p>
                      </div>
                      <div class="message last">
                        <p>
                          Bawds jog!
                        </p>
                      </div>
                    </li>

                    <li class="message-right animated fadeinright delay-6">
                      <img alt="" src="img/user3.jpg">
                      <div class="message">
                        <p>
                          Quick zephyrs blow, vexing daft Jim.
                        </p>
                      </div>
                    </li>


                    <div style="width:100%;height:60px;"></div>



                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div> <!-- End of Main Contents -->
      
       
      </div> <!-- End of Page Content -->

    </div> <!-- End of Page Container -->
    
    <!-- video chatting window -->
    <div class="m-scene" id="pin-video-div"> <!-- Main Container -->

      <!-- Page Content -->
      <div id="content" class="page attach-top">

        <!-- Main Content -->
        <div class="animated fadein" >
          <div id="connectControls" style="height:0px;">
              <div id="iam" style="display:none">Not yet connected...</div>
              <div id="otherClients" style="display:none"></div>
          </div>
          <div id="videos">
            <div class="video-myself">
                <video autoplay="autoplay" class="easyrtcMirror" id="selfVideo" muted="muted" volume="0" ></video>
            </div>
            <div class="video-you">
                <video autoplay="autoplay" id="callerVideo"></video>
            </div>
          </div>
        </div>
      
       
      </div> <!-- End of Page Content -->

    </div> <!-- End of Page Container -->
    
        
    <!-- search window -->
    <div class="m-scene" id="pin-search-div"> <!-- Main Container -->

      <!-- Page Content -->
      <div id="content" class="page attach-top">
        
        <!-- Main Content -->
        <div class="animated fadeindown">
            <!-- Project Image -->
            <!-- <div class="project-image z-depth-1 animated fadein delay-1">
                <img src="img/product2.jpg" alt="">
            </div> -->

            <!-- Project Author -->
            <div class="project-info" style="margin-top:30px;">
                <h2 class="uppercase">search places!</h2>
                <span class="small">Newyour / Seoul / London</span>
                <p class="m-t-10 m-b-30">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
            </div>

            <iframe id="searchMap" class="animated fadein" width="100%" height="350px;" src="/autocomplete" style="border: none;"></iframe>
            

          <!-- Comments -->
          <!-- <div class="comments project-comments animated fadeinup delay-3">
            <h3 class="uppercase">5 Comments</h3>
            <ul class="comments-list">
              <li>
                <img src="img/user4.jpg" alt="" class="avatar circle">
                <div class="comment-body">
                  <span class="author uppercase">Luke Noel</span>
                  <p>Awesome work!!</p>
                </div>
              </li>
              <li>
                <img src="img/user.jpg" alt="" class="avatar circle">
                <div class="comment-body">
                  <span class="author uppercase">Joel Roksin</span>
                  <p> You have done a great job there :)</p>
                </div>
              </li>
              <li>
                <img src="img/user3.jpg" alt="" class="avatar circle">
                <div class="comment-body">
                  <span class="author uppercase">Mike White</span>
                  <p>Keep going!</p>
                </div>
              </li>
              <li>
                <img src="img/user4.jpg" alt="" class="avatar circle">
                <div class="comment-body">
                  <span class="author uppercase">Joel Roksin</span>
                  <p> You have done a great job there :)</p>
                </div>
              </li>
              <li>
                <img src="img/user3.jpg" alt="" class="avatar circle">
                <div class="comment-body">
                  <span class="author uppercase">Mike White</span>
                  <p>Keep going!</p>
                </div>
              </li>
            </ul>
          </div> -->

        </div> <!-- End of Main Contents -->
      </div> <!-- End of Page Content -->
    </div> <!-- End of Page Container -->




  <!-- map window -->
  <div class="m-scene" id="pin-info-div"> <!-- Main Container -->

    <!-- Detailed Page Pin Content -->
    <div id="content-detail-pin">

      <!-- Article Content -->
      <div class="animated fadeinup delay-1">
        <!-- HERE!!! pin detail Tpl will be attached -->
        <div id="detail-pin-root"></div>
        <!-- Pins -->
        <div class="comments">
          <h3 class="uppercase">3 Comments</h3>
          <ul class="comments-list" id="detail-pin-comment">
          </ul>
        </div>
      </div> 

      <!-- Footer -->
      <?php include 'footer.php'; ?>
      
    </div> <!-- End of Page Content -->
  </div> <!-- End of Page Container -->

    <!-- button control -->
    <div class="map-left-bottom" id="chattingBtn">
        <div class="map-bottom-circle"></div>
        <i class="ion-chatboxes"></i>
    </div>

    <div class="map-right-bottom" id="infoBtn">
        <div class="map-bottom-circle"></div>
        <i class="ion-information-circled"></i>
    </div>

    <div class="map-center-bottom" id="btnCtrl">
        <div class="map-center-circle"></div>
        <i class="ion-outlet"></i>
    </div>

    <div class="map-left-top" id="videoChattingBtn">
        <div class="map-bottom-circle"></div>
        <i class="ion-person"></i>
    </div>

    <div class="map-left-top " id="streetCloseBtn" style="top:70px !important;">
        <div class="map-bottom-circle"></div>
        <i class="ion-close-round" style="color:#aaa;"></i>
    </div>

    <div class="map-right-top" id="searchBtn">
        <div class="map-bottom-circle"></div>
        <i class="ion-search"></i>
    </div>

    <div style="display:none">
      <button id="btnPintalk">pintalk</button>
    </div>

<input type="hidden" id="owner" >
<input type="hidden" id="pin_id">

<?php include 'bottom.php'; ?>

<!-- map -->
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/maps.js"></script>


<script>
var $ = jQuery.noConflict();

// map use count
var mapUse = {};
var streetTimer = {};

$(function(){   

    mapUse = new mapUseCnt('<?=Session::get('use_cnt')?>'); 
    streetTimer = new streetviewOpenTimer();
    
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

    // onload
    onLoadMap();

    // make side swife area shorter
    $(".drag-target").addClass("drag-target-map");

    // get invite message on some other pages.
    if(_chat){ // true
        //$('.map .toggle-navigation').trigger('click');  // close
        //$('.map .toggle-navigation').trigger('click');  // open 
    }

    // check member or not
    var checkMember = function(){
        if(!'<?=Auth::check()?>'){
            location.href= base_url + '/auth/login';
        }
    };
    

    // info
    $("#infoBtn").on('click touch',function(){

        if($('#pin-info-div:visible').length){
            pinInfoCtrl.close();
        }else{
            pinInfoCtrl.open();
        }
    });


    var pinInfoCtrl = (function(){

      return {
        open : function(){
          allHide();
          $("#pin-info-div").show();
          $("#infoBtn i").attr("class","ion-map");
          _pinInfo = true;
        },
        close: function(){
          toTheMap();
          fourPinInfoClose();
          _pinInfo = false;
        }
      }
    })();




    // chat
    $("#chattingBtn").on('click touch',function(){
        
        if($('#pin-chat-div:visible').length){
            toTheMap();
        }else{
            allHide();
            $("#pin-chat-div").show();
            $("#chattingBtn i").attr("class","ion-map");
            $("#videoChattingBtn").show();
        }
    });

    // video chat
    $("#videoChattingBtn").on('click touch',function(){
        if($("#pin-video-div:visible").length){
            toTheMap();
        }else{
            allHide();
            $("#pin-video-div").show();
            $("#videoChattingBtn i").attr("class","ion-map");
            $("#videoChattingBtn").show();
            $("#video-myself").show();
            $("#video-you").show();
        }
    });


    

    // search
    $("#searchBtn").on('click touch',function(){
        if($("#pin-search-div:visible").length){
            toTheMap();
            window.frames[0].frameElement.contentWindow.disableInput();
        }else{
            allHideWithCtrl();
            window.frames[0].frameElement.contentWindow.ableInput();
            $("#pin-search-div").show();
            $("#searchBtn").show();
            $("#searchBtn i").attr("class","ion-map");
            $("#searchBtn").animate({
                top:'20px' 
            });
        }
    });


    
    var allHide = function(){
        $("#main").hide();
        $("#pin-info-div").hide();
        $("#pin-chat-div").hide();
        $("#pin-video-div").hide();
        $("#pin-search-div").hide();
        $("#infoBtn i").attr("class","ion-information-circled");
        $("#chattingBtn i").attr("class","ion-chatboxes");
        $("#videoChattingBtn i").attr("class","ion-person");
        $("#searchBtn i").attr("class","ion-search");
        $("#videoChattingBtn").hide();
        $("#video-myself").hide();
        $("#video-you").hide();
        $("#searchBtn").hide();
        streetViewOff();
        closeStreetview();
        
    }

    var allHideWithCtrl = function(){
        allHide();
        $("#infoBtn").hide();
        $("#chattingBtn").hide();
        $("#videoChattingBtn").hide();
        $("#searchBtn").hide();
        $("#btnCtrl").hide();
    }

    // organize control
    var toTheMap = function(){
        allHide();
        $("#main").show();
        $("#searchBtn").show();
        $("#infoBtn").show();
        $("#chattingBtn").show();
        $("#btnCtrl").show();
        $("#searchBtn").animate({
            top:'70px' 
        });
        refreshMap();
    }

    // apply the value from iframe search result
    var searchApplyMap = function(lat,lng){
        var center = new google.maps.LatLng(lat, lng);
        map.panTo(center);
        toTheMap();
    }


    var refreshMap = function(){
        google.maps.event.trigger(map, 'resize');
    }

    // detect back button (뒤로가기 처리, 각레벨에서 구현..)
    detectBack.init(function(deep){
      /*
      // when page gets back to previous..
      if(deep==1){
        detectBack.setStateWithMinus();
        go1Depth();
      }else if(deep==2){
        detectBack.setStateWithMinus();
        go2Depth();
      }else{
        console.log('etc',deep);
      }
      */
    });

    // map control button 
    var mapCtrlBtn = (function(){
      return {
        deSelect : function(){
          $(".map-center-circle").removeClass("map-select");
        },
        select: function(){
          $(".map-center-circle").addClass("map-select");
        }
      }
    })();


    // when executing street view 
    var streetViewOn = function(){
      $("#streetCloseBtn").show();
      $("#streetCloseBtn").on('click',function(){
        closeStreetview();
      });
    }

    

    // when close street view
    var streetViewOff = function(){
      if($("#streetCloseBtn").length){
        $("#streetCloseBtn").hide();
        $("#streetCloseBtn").off('click');
      }
    }

    window.streetViewOn = streetViewOn;
    window.streetViewOff = streetViewOff;
    window.searchApplyMap = searchApplyMap;
    window.onLoadMap = onLoadMap;
    window.checkMember = checkMember;
    window.toTheMap = toTheMap;
    window.mapCtrlBtn = mapCtrlBtn;
    window.pinInfoCtrl = pinInfoCtrl;
});

</script>

<style>
        #map {
            width: 100%;
            height:calc(100vh - 56px);
        }

        #main {
            position:relative;
        }

        #pin-info-div{
            position:relative;
            display:none;
        }

        #pin-chat-div{
            position:relative;
            display:none;
        }

        #videoChattingBtn{
            display:none;
        }

        #pin-video-div{
            display:none;
        }

        #pin-search-div{
            display:none;
        }

        .attach-top{
            margin-top:0px;
        }

        .map-select{
          background-color:red;
        }

        .talkingLittlePin{
          width:30px;
          height:auto;
        }

</style>

<!-- pin detail pin -->
<script type="text/x-template" id="mobilePinDetailPinTpl">
  <div class="page-content">
    <h2 class="uppercase">{{title}}</h2>
    <div class="post-author">
      <!-- <img src="{{host_avatar}}" alt="" class="avatar circle"> -->
      <span style="padding-left:0px;">{{category}}</span>
    </div>
    <p class="text-flow"><!--span class="dropcap">A</span--> {{address}}</p>
    <!-- <blockquote class="primary-border">"The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog."</blockquote> -->
    <!-- Slider -->         
    <div class="swiper-container slider m-b-20">
      <div class="swiper-wrapper">
        <!-- <div class="swiper-slide">
          <img src="{{img}}" alt="">
        </div>
        <div class="swiper-slide">
          <img src="{{img}}" alt="">
        </div> -->
        {{img}}
      </div>
      <!-- Add Arrows -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
    </div>
    <!-- End of Slider -->

    <!-- Share -->
    <div class="share center-align m-t-30">
      <h3 class="uppercase">Share it!</h3>
      <i class="ion-social-facebook p-20 blue-text text-darken-4"></i>
      <i class="ion-social-twitter p-20 blue-text"></i>
      <i class="ion-social-pinterest p-20 red-text"></i>
    </div>
  </div>
</script>


</body>
</html>