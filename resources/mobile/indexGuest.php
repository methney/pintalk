<!DOCTYPE html>
<html lang="en-US">
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
  #map-detail {
    width:100%;
    height:300px;
  }
  #detail-root{
    width:100%;
    height:100%;
  }
  #detail-root .page-content img {
    max-width:100%;
    height:auto !important;
  }
  .fake-header{
    position:relative;
    width:100%;
    height:56px;
  }

  #detail-pin-root {
    width:100%;
    height:100%;
    margin-top:56px;
  }
  .btn-larget {
    color:#555;
  }
</style>


<body>
    
    <?php include 'top.php'; ?>

    <div class="m-scene" id="main"> <!-- Main Container -->

      <!-- Sidebars -->
      <!-- Right Sidebar -->
      <?php include 'right.php'; ?>
      <!-- Left Sidebar -->
      <?php include 'left.php'; ?>
      <!-- End of Sidebars -->

      <!-- Page Content -->
      <div id="content" class="page grey-blue">

        <!-- Toolbar -->
        <?php include 'toolbar.php'; ?>
      
        <!-- Main Content -->
        <div class="animated fadeinup">
        </div> <!-- End of Main Contents -->

        <!-- Footer -->
        <?php include 'footer.php'; ?>
      </div> <!-- End of Page Content -->


      <!-- Detailed Page Content -->
      <div id="content-detail">

        <!-- Toolbar -->
        <?php include 'toolbar.php'; ?>
        
        <div class="fake-header"></div>
        <div id="map-detail"></div>
        
        <!-- Article Content -->
        <div class="animated fadeinup delay-1">
          <!-- HERE!!! pin detail Tpl will be attached -->
          <div id="detail-root">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>  
          </div>

          <!-- Pins -->
          <!-- <div class="comments">
            <h3 class="uppercase">3 Comments</h3>
            <ul class="comments-list">
            </ul>
          </div> -->
        </div> 

        <!-- Footer -->
        <?php include 'footer.php'; ?>
      
       
      </div> <!-- End of Page Content -->


      <!-- Detailed Page Pin Content -->
      <div id="content-detail-pin">

        <!-- Toolbar -->
        <?php include 'toolbar.php'; ?>

        
        
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



<?php include 'bottom.php'; ?>


<!-- map -->
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/maps.js"></script>


<script>
var $ = jQuery.noConflict();

$(function(){  

  
  // make side swife area shorter
  $(".drag-target").addClass("drag-target-map");

  // list
  var pinList = (function(){

      var start = '';
      var pageCnt = 5;

      return {
          init : function(callback){
              this.getData();
          },
          getData : function(callback){
              var self = this;

              $.ajax({
                  type: 'GET',
                  url : base_url + '/m_getSlider',
                  data: {'start':start, 'pageCnt': pageCnt},
                  success: function (obj) {
                      
                      console.log('objs',obj);
                      var html = '';
                      var arr_title = [];
                      var avatar = "<?=url()?>/assets/mobile/img/user4.jpg";
                      var img = "<?=url()?>/assets/img/default-location.png";
                      var link = "";

                      $.each(obj.data,function(i,d){
                          
                          if(isNullChk(d.facebook_id)){
                              avatar = _fileProfileDir+d.host_avatar;
                          }else{
                              avatar = d.host_avatar;
                          }

                          if(!isNullChk(d.file_name)){
                              img = _fileDir+d.file_name;
                          }
                          
                          arr_title = d.title.split('@');

                          html = $("#mobileListTpl").html();
                          html = html.replace(/{{idx}}/g, i);
                          html = html.replace(/{{sno}}/g, d.sno);
                          html = html.replace(/{{category}}/g, arr_title[0]);
                          html = html.replace(/{{title}}/g, arr_title[1]);
                          html = html.replace(/{{avatar}}/g, avatar);
                          html = html.replace(/{{author}}/g, d.host_name);
                          html = html.replace(/{{img}}/g, img);
                          html = html.replace(/{{description}}/g, removeTags(d.description));
                          $(html).insertBefore("#content footer");
                          start = d.id;
                      });

                      $('.blog-preview-description').dotdotdot();
                      $('.blog-preview h4').dotdotdot();
                      self.pagenation(callback);
                  }
              });
          },
          // paging 처리
          nextPage : function(){
              // 상단에서 받아올때, 자동으로 start변수에 set! this.getData만 다시호출하면 될..
          },

          pagenation : function(callback){
              if(typeof(callback)=='function'){
                  callback();
              }
          }
      }
  })();

  // execute!
  pinList.init();


  // organize controls
  var allHide = function(){
    $("#content").hide();
    $("#content-detail").hide();
    $("#content-detail-pin").hide();
    
  }


  var fourMarkers = [];
  var fourLinePos = [];
  var youtubes = [];
  var cMap = new createSearchMap();
  function makeContent(id){

    // page depth set 
    detectBack.setDeepByone();

    fourMarkers = [];
    go2Depth();
    

    $.ajax({
        type: "GET",
        url: base_url+'/callPinDetail',
        data: {'id': id },
        success: function( data ) {

            onLoadMap(id,14,function(){

                if(data.board && data.board.length>0){
                    console.log('content',content, data);
                    
                    var content = data.board[0].content;
                    var tpl = $("#mobilePinDetailTpl").html();
                    var aboutme = data.board[0].aboutme;
                    tpl = tpl.replace(/{{title}}/g,data.board[0].title);
                    
                    if(isNullChk(data.board[0].facebook_id)){
                        tpl = tpl.replace(/{{host_avatar}}/g, _fileProfileDir + data.board[0].avatar);
                    }else{
                        tpl = tpl.replace(/{{host_avatar}}/g, data.board[0].avatar);
                    }
                    tpl = tpl.replace(/{{description}}/g, content);
                    tpl = tpl.replace(/{{host}}/g, data.board[0].name);
                    tpl = tpl.replace(/{{aboutme}}/g, aboutme);
                    $("#detail-root").html("");
                    $("#detail-root").append(tpl);
                    $("#pin_sno").val(data.board[0].sno);
                    
                    // after dom
                    if(isNullChk(aboutme)){
                      $(".aboutme").hide();
                    }
                    /*
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
                    */

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

                // 대화시작
                $("#btnPintalk").off('click').on('click', function(){
                    window.location.href = '<?=url()?>/direct/' + $("#pin_sno").val();
                });


            });
        }
    });

    
    /*
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
    */
  }





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
  //onLoadMap();


  function makeFourContent(i,data,tData){

      /*
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
                  
                  //ytpl = ytpl.replace(/{{pinid}}/g, yitem.pin_id);
                  //ytpl = ytpl.replace(/{{title}}/g, yitem.title);
                  //ytpl = ytpl.replace(/{{videoid}}/g, yitem.video_id);

                  //$("#youtube-div-"+yitem.pin_id).append(ytpl);
                  //$(".video").css("width", '400');
                  
                  youtubes.push(yitem);
              }
          });
      }

      */
      
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

    console.log('single', data);

    // page depth set 
    detectBack.setDeepByone();
    go3Depth();
      
    var address = '';
    //$("#fourPinInfo").html('');
    //selectedMarkerOn(idx);
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
                    img += '<div class="swiper-slide"><img src="'+d.url+'"></div>';
                    pIdx++;
                }
            }
        });
    }

    $("#detail-pin-comment").html("");

    if(tData.board_pin_comment && tData.board_pin_comment.length>0){

        var tipTpl = ''; 
        var tipCnt = 0;
        $.each(tData.board_pin_comment,function(k,kvalue){
            if(data.pin_id==kvalue.pin_id){
              ++tipCnt;
                tipTpl = 
                '<li>' +
                  '<div class="comment-body" style="padding-left:10px">' + 
                    '<span class="author uppercase">{{user}}</span>' +
                    '<span class="date">{{date}}</span>' + 
                    '<p>{{comment}}</p>' + 
                  '</div>' + 
                '</li>';
                tipTpl = tipTpl.replace(/{{user}}/g, kvalue.user);  
                tipTpl = tipTpl.replace(/{{date}}/g, kvalue.write_dt);  
                tipTpl = tipTpl.replace(/{{comment}}/g, kvalue.comment); 
                $("#detail-pin-comment").append(tipTpl);
            }

        });

        var tipCntTxt = (tipCnt>0)?tipCnt + ' Comments':'No Comment';
        if(tipCnt>0){
          if(tipCnt==1){
            tipCntTxt = tipCnt + ' Comment';
          }else{
            tipCntTxt = tipCnt + ' Comments';
          }
        }else{
          tipCntTxt = 'No Comment';
        }
        $("#content-detail-pin .comments h3").html(tipCntTxt);

    }else{
        $(".comment-div-"+i).css("display","none");
    }

    
    var tpl = $("#mobilePinDetailPinTpl").html();

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
    
    $("#detail-pin-root").html("");
    if($("#detail-pin-root").length>0){
        $("#detail-pin-root").append(tpl);
    }

    // Swiper sliders
    swiperSlide = new Swiper('.slider', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        autoplay: 5000,
        loop: true,
    });

    /*
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
    */

  }

  // go 1 depth
  var go1Depth = function(){
    allHide();
    $("#content").show();
    $("#map-detail").animate({height:'300'},100,"swing"); 
  }

  // go 2 depth
  var go2Depth = function(){
    allHide();
    $("#content-detail").show();
  }

  // go 3 depth
  var go3Depth = function(){
    allHide();
    $("#content-detail-pin").show();
  }

  // onload
  allHide();
  $("#content").show();


  

  // detect back button (뒤로가기 처리, 각레벨에서 구현..)
  detectBack.init(function(deep){
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
  });
  

  window.makeContent = makeContent;



});

</script>



<!-- mobile main slide template -->
<script type="text/x-template" id="mobileListTpl">
    <div class="blog-card animated fadein delay-{{idx}} hands" onclick="makeContent({{sno}})">
        <div class="blog-header">
            <img class="avatar circle" src="{{avatar}}" alt="">
            <div class="blog-author">
            <span>{{author}}</span>
            <span class="small">{{category}}</span>
            </div>
        </div>
        <div class="blog-image">
            <img src="{{img}}" alt="">
        </div>
        <div class="blog-preview p-20">
            <h4 class="uppercase">{{title}}</h4>
            <p class="blog-preview-description">{{description}}</p>
            <a class="waves-effect waves-light btn primary-color hands">Read</a>
        </div>
    </div>
</script>

<!-- pin detail -->
<script type="text/x-template" id="mobilePinDetailTpl">
  <div class="page-content">
    <h2 class="uppercase">{{title}}</h2>
    <div class="post-author">
      <img src="{{host_avatar}}" alt="" class="avatar circle">
      <span>{{host}}</span>
    </div>
    <div>
      <button class="waves-effect waves-light btn-large modal-trigger primary-color width-100 m-b-20"  id="btnPintalk" type="button">pintalk!</button>
      <input type="hidden" id="pin_sno">
    </div>
    <p class="text-flow"><!--span class="dropcap">A</span--> {{description}}</p>
    <!-- <blockquote class="primary-border">"The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog."</blockquote> -->
    <!-- Slider -->         
    <!-- <div class="swiper-container slider m-b-20">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="{{img}}" alt="">
        </div>
        <div class="swiper-slide">
          <img src="{{img}}" alt="">
        </div>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div> -->
    <!-- End of Slider -->
    <p class="text-flow aboutme"><b>About me </b> {{aboutme}}</p>

    <!-- Share -->
    <div class="share center-align m-t-30">
      <h3 class="uppercase">Share it!</h3>
      <i class="ion-social-facebook p-20 blue-text text-darken-4"></i>
      <i class="ion-social-twitter p-20 blue-text"></i>
      <i class="ion-social-pinterest p-20 red-text"></i>
    </div>
  </div>
</script>

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