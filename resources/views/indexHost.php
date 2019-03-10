<?php
    include 'head.php';
    $pin = isset($pin_id)?$pin_id:'';
    $board = isset($board)?$board:'';
    $modify = isset($modify)?$modify:'';
    $pin_cate = '';
    $board_content = '';
    $board_lat = '';
    $board_lng = '';

    if(!empty($board)){
        $pin_cate = $board[0]->category;
        $board_content = $board[0]->content;
        $board_lat = $board[0]->lat;
        $board_lng = $board[0]->lng;
    }
?>

<link rel="stylesheet" href="<?=url()?>/redactor/redactor.css" />
<link rel="stylesheet" href="<?=url()?>/assets/css/dropzone.css" type="text/css">
<link rel="stylesheet" href="<?=url()?>/assets/css/bootstrap-checkbox.css" type="text/css">
<style>

.bootstrap-select .dropdown-menu li a{
    font-size: 30px !important;
    font-family: Dosis-Regular;
    text-transform: uppercase;
    position:relative;
}


.bootstrap-select .selectpicker .filter-option{
    font-size: 50px !important;
    font-family: Dosis-Regular;
    text-transform: uppercase;
    position:relative;
}

.wrap-search-idx .search-category {
    position:relative;
}

.search-category .category-desc {
    position:absolute;
    right:10;
    font-size: 12px;
    font-family: Dosis-Regular;
    text-transform: uppercase;
    color:#999;
}

.search-category .category-desc a{
    color:red;
}

#fourList{
    font-family: 'Arial', sans-serif;
}

#fourList .pin-title {
    font-family: 'Arial', sans-serif;
    font-weight:bold;
}

#fourList .pin-number {
    font-family: 'Arial', sans-serif;
    font-weight:bold;
}


.scroll-element.scroll-x {
    display: none !important;
}

.youtubelist {
    margin:10px 0 20px 1px;
}

.search-language {
    display:none;
}


</style>
<script>
$(function(){

    // 수정일때, 
    if('<?=$modify?>'=='not_allowed'){ // 권한없음 
        $.alertWindow.init({
            'title' : "You are not allowed!",
            'content' : "You could not modify or delete this pin. please check this out!",
            'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight">Close</button>'
        },function(){
            $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                $.alertWindow.close();
                window.location.href='/';
            });
        });     
    }else if('<?=$modify?>'=='modify'){ // 수정 
        var content = $("#pin_content").val();
        //content = content.replace(/uploadImages/g, '<?=$fileDir?>');
        $("#pin_content").val(content);
        $(".four-pin-list .four-list-height").css('height','400px');
        $(".search-textarea").css("display","block");
        $(".search-button button").css("display","block");
        $("#sno").val('<?=$pin?>');

        _latitude = "<?=$board_lat?>";
        _longitude = "<?=$board_lng?>";

        $(".map-simple .pin-control").animate({
            bottom:'0px'
        });

    }

    var map = {};
    
    // foursquare category
    var fourCate = function(id){

        if('<?=$modify?>'=='modify'){ // 수정 
            $.alertWindow.init({
                'title': "Please wait to set pins!",
                'content': "It'll take few seconds..",
                'btn': '<button type="button" class="btn btn-default btn-large" disabled="disabled">Close</button>'
            }, function () {
                $('.alert-window .alert-btn :button:eq(0)').on('click', function () {
                    $.alertWindow.close();
                });
            });
        }

        $.ajax({
            type: "GET",
            url: base_url+'/fourCategories',
            success: function( data ) {

                $("#category").html("<option value=''>What to talk about?</option><option value='explore'>Popular!</option>");
                $.each(data.response.categories,function(i,d){
                    $("#category").append($('<option>', { value : d.id, text : d.name }));
                });

                if(!isNullChk(id)){
                    $("#category").val(id);
                }
                $("#category").selectpicker('refresh');

                // declare pins use for map
                foursqaurePins = new fourPins(map,tour);            

                if('<?=$modify?>'=='modify'){ // 수정 
                    foursqaurePins.pinFromDB('<?=$pin?>');
                    mapDrag(map);
                }
            }
        });
    }
    
    var foursqaurePins = {};

    // category event
    $("#category").on('change',function(){

        if($("#map-simple").css('height')!='500px'){
            mapDrag(map);
        }
        
        if(foursqaurePins.getPinIdx() >= 20){
            $.alertWindow.init({
                'title' : "Pins are available up to 20!",
                'content' : "If you'd like to talk on more pins over 20, please make another pintalk!",
                'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight">Close</button>'
            },function(){
                $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                    $.alertWindow.close();
                    return false;
                });
            });    

        }else{

            var clusterUse = false;
            var category = $("#category").val();
            foursqaurePins.init({ // @maps.js
                'lat':$("#lat").val(),
                'lng':$("#lng").val(),
                'category':category,
                'clusterUse':clusterUse
            });
            $(".map-simple .pin-control").animate({
                bottom:'0px'
            });
            $(".four-pin-list .four-list-height").css('height','400px');
            $(".search-textarea").css("display","block");
            $(".search-button button").css("display","block");
            
            
            //$(".search-language").css("display","block");
        }

        // tour close
        $('.search-category .anno-btn:eq(1)').trigger('click');


        
    });

    $("#btnOrganizePins").on('click',function(){
        $.alertWindow.init({
            'title' : "Please wait! Organizing...",
            'content' : "It'll take few seconds!",
            'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight" disabled="disabled">Close</button>'
        },function(){
            $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                $.alertWindow.close();
                return false;
            });
        });    
        foursqaurePins.organizePin(function(){
            $.alertWindow.close();
        });

    });


    $("#btnResetPins").on('click',function(){
        foursqaurePins.resetPin();
        setTimeout(function(){
            $(".map-simple .pin-control").animate({
                bottom:'-40px'
            })
        },1000);
        $(".four-pin-list .four-list-height").css('height','0px');
        $(".search-textarea").css("display","none");
        $(".search-button button").css("display","none");
        $("#category").val('');
        $("#category").selectpicker('refresh');

    });

    // map search
    $("#submit").on('click',function(){

        // create title automatically...or..

        var title = $("#category option:selected").text();
        var location = $("#simLocation").val();
        $("#title").val(isNull(title,'Anything!') + ' @ ' + location);

        if('<?=$modify?>'=='modify'){ // 수정 

            $("#pinFrm").attr("action", "/modPin");

            $.alertWindow.init({
                'title' : "Want to update this pin?",
                'content' : "You can check this out before doing operation!",
                'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight">Check</button><button type="button" class="btn btn-default btn-large">Update</button>'
            },function(){
                $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                    $.alertWindow.close();
                    //return false;
                });
                $('.alert-window .alert-btn :button:eq(1)').on('click',function(){

                    $.alertWindow.init({
                        'title' : "Please wait! We are working on!",
                        'content' : "It'll take few seconds!",
                        'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight" disabled="disabled">Close</button>'
                    },function(){
                        $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                            $.alertWindow.close();
                            return false;
                        });
                    });  

                    foursqaurePins.organizePin(function(){
                        //callback후에도 그리는 시간을 좀 더 줌..
                        setTimeout(function(){
                            $.alertWindow.close();
                            $("#pinFrm").submit();  
                        },2500);
                    });



                });
            });

        }else{

            $.alertWindow.init({
                'title' : "Want to register this pin?",
                'content' : "You can check this out before doing operation!",
                'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight">Check</button><button type="button" class="btn btn-default btn-large">Save</button>'
            },function(){
                $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                    $.alertWindow.close();
                    //return false;
                });
                $('.alert-window .alert-btn :button:eq(1)').on('click',function(){
                    
                    $.alertWindow.init({
                        'title' : "Please wait! We are working on!",
                        'content' : "It'll take few seconds!",
                        'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight" disabled="disabled">Close</button>'
                    },function(){
                        $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                            $.alertWindow.close();
                            return false;
                        });
                    });  

                    foursqaurePins.organizePin(function(){
                        //callback후에도 그리는 시간을 좀 더 줌..
                        setTimeout(function(){
                            $.alertWindow.close();
                            $("#pinFrm").submit();  
                        },2500);
                    });
                    
                });
            });    

        }
    });


    var tourData = [
        {
            target  : '.search-input',
            position: 'right',
            content : "Please, Type your favorite place!",
            autoFocusLastButton:false,
            buttons : [
                {
                    text: 'Hide Steps',
                    click: function(anno, evt){
                        tour.tourDisabled(anno);
                    }
                },
                {
                    text: 'Done',
                    click: function(anno, evt){
                        tour.doClose(anno);
                    }
                },
            ]
        },
        {
            target  : '.search-category .bootstrap-select',
            position: 'right',
            content : "Please, Select categories you like!",
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
            target  : '.redactor-box',
            position: 'right',
            content : "Please, fill this blank with what you want! Then save!",
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
    ];
    var tour = new tourForInvitation();
    tour.init(tourData);

    if('<?=$modify?>'!='modify'){
        // tour(guide)
        tour.doit();
    }

    // delete
    $("#submitDelete").on('click',function(){
        $("#pinFrm").attr("action", "/delPin");
        $.alertWindow.init({
            'title' : "Want to delete this pin?",
            'content' : "You can check this out before doing operation!",
            'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight">Check</button><button type="button" class="btn btn-default btn-large">Delete</button>'
        },function(){
            $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                $.alertWindow.close();
                //return false;
            });
            $('.alert-window .alert-btn :button:eq(1)').on('click',function(){
                $.alertWindow.close();
                $("#pinFrm").submit();
            });
        });    
    });
    

    // load map pins then check those pins belong to map boundary
    var onLoadMap = function(){
        map = simpleMap(_latitude,_longitude, true, 15, mapStyles);
        fourCate('<?=$pin_cate?>');
    }
    onLoadMap();

    $(".search-close").on('click',function(){
        $("#simLocation").val('');
        $("#simLocation").focus();
        $("#btnResetPins").trigger('click');
    });

    // scroll 참고(https://gromo.github.io/jquery.scrollbar/demo/basic.html)
    $('.scrollbar-macosx').scrollbar();
    $('.scrollbar-macosx').css('max-height','400px');
    

    $('#pin_content').redactor({
        imageUpload: '/singleUpload',
        imageResizable: true,
        imagePosition: true,
        minHeight:400,
        placeholder: 'Add your own content!',
        callbacks: {
            imageUpload: function(image,json)
            {
                $('<input />').attr('type', 'hidden')
                .attr('name', "filenames[]")
                .attr('value', json.fileName)
                .appendTo('#pinFrm');
            }
        } 
    });

    $("#simLocation").keypress(function(event) {
        if(event.which == 13) {

            event.preventDefault();
            if(!isNullChk(tour)){
                tour.doAllClose();
            }
            /*
            $("html, body").animate({ scrollTop: 210 }, 2000, "swing");

            if($("#simLocation").val()!=''){
                $(".search-category").css("display","block");
            }
            mapDrag(map);
            */            
        }
    });

    $("#simLocation").off('click').on('click',function(){
        $("#btnResetPins").trigger('click');
    });

    // googlemap javascript library limit autocomplete 할때  (You have exceeded your daily request quota for this API) 임시처리 
    function getTempCoordi(val,e){ // val-> $("#simLocation").val()
        var coordis = [];
        if(e.which == 13) {
            e.preventDefault();
            $("#btnResetPins").trigger('click');

            coordis = _tempCoordi[val].split('/');
            _latitude = coordis[0];
            _longitude = coordis[1];
            $("#lat").val(coordis[0]);
            $("#lng").val(coordis[1]);

            onLoadMap();
            mapDrag(map);  
            $("html, body").animate({ scrollTop: 210 }, 2000, "swing");
            
        }
    }


    function mapDrag(map){
        if($("#map-simple").height()=='200'){
            $("#map-simple").animate({height:'400'},500,"swing",function(){
                google.maps.event.trigger(map, "resize");   
            }); 

            if('<?=$modify?>'!='modify'){
                tour.doNext();
            }
        }
    }

    // foursquare list bottom event
    function chkScroll(e){
        var elem = $(e.currentTarget);
        if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()){
            if('<?=$modify?>'!='modify'){
                tour.doNext();
            }
        }
    }



    window.getTempCoordi = getTempCoordi;
    window.mapDrag = mapDrag;
    window.tour = tour;
    window.chkScroll = chkScroll;
});




</script>
<html lang="en-US"> 
<head>
    <!--<meta charset="UTF-8"/>-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body onunload="" class="map-fullscreen page-homepage navigation-off-canvas" id="page-top">

<?php include 'top_nologo.php'; ?>

<form id="pinFrm" name="pinFrm" role="form" method="post" action="/addPin" enctype="multipart/form-data">
<input type="hidden" name="board_id" value="pinBoard">
<input type="hidden" name="rep_img" id="rep_img">
<input type="hidden" name="lat" id="lat">
<input type="hidden" name="lng" id="lng">
<input type="hidden" name="district" id="district">
<input type="hidden" id="country" name="country">
<input type="hidden" id="address" name="address">
<input type="hidden" id="title" name="title">
<input type="hidden" id="sno" name="sno">

<div class="wrap-search-idx">
    <div class="search-exp">
        <div class="left">
            <span class="txt">JUST TALK WHAT YOU SEE ABOUT!</span>
            <span class="exp">EXCERCISE LANGUAGES YOU'VE LEARNED!</span>
        </div>
        <div class="right">
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
    <div class="pin-control">
        <div class="pin-control-btn">
            <button type="button" class="btn btn-default btnGapRight" id="btnResetPins">Reset pins</button>
            <button type="button" class="btn btn-default" id="btnOrganizePins">Organize pins</button>
        </div>
    </div>
</div>
<div class="clr"></div>
<div class="wrap-search-idx wrap-search-split">
    <div class="search-content">
        <div class="search-category">
            <!--<img src="<?=url()?>/assets/img/talkingPin.png">-->
            <select id="category" name="category">
            </select>
            <div class='category-desc'>PINS FROM <a href="http://foursquare.com" target="_blank">FOURSQUARE</a></div>
        </div>
    </div>
</div>
<div class="wrap-search-idx">
    <div class="four-pin-list scrollbar-macosx">
        <div class="four-list-height" style="width:100%;height:0px;">
            <ul id="fourList">
            </ul>
        </div>
    </div>
</div>    
<div class="clr"></div>
<div class="wrap-search-idx wrap-search-split" style="margin-top:15px;>
    <div class="search-content">
        <div class="search-language">
            <select id="language" name="language">
                <option>Language</option>
            </select>
        </div>
    </div>
</div>
<div class="clr"></div>
<div class="wrap-search-idx search-textarea">
    <textarea id="pin_content" name="pin_content"><?=$board_content?></textarea>
</div>
</form>
<div class="clr"></div>
<div class="wrap-search-idx search-button">
    <?php
        if($modify=='modify'){ ?>
        <button type="button" class="btn btn-default pull-right" id="submitDelete">Delete</button>
        <button type="button" class="btn btn-default pull-right btnGapRight" id="submit">Modify</button>
    <?php 
        }else{ ?>        
        <button type="button" class="btn btn-default pull-right" id="submit">Submit</button>
    <?php 
        } ?>
</div>
<div style="width:100%;height:100px;"></div>
<div class="clr"></div>


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
<script src="https://apis.google.com/js/client.js?onload=init"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/maps.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/leaflet.js"></script>
<script type="text/javascript" src="<?=url()?>/redactor/redactor.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/dropzone.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/bootstrap-checkbox.js"></script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->


<?php include 'bottom.php'; ?>

</body>
</html>