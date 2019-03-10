<!DOCTYPE html>

@include('head')
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotter - Universal Directory Listing HTML Template</title>
    <link rel="stylesheet" href="<?=url()?>/redactor/redactor.css" />
    <link rel="stylesheet" href="<?=url()?>/assets/css/dropzone.css" type="text/css">
    <link rel="stylesheet" href="<?=url()?>/assets/css/bootstrap-checkbox.css" type="text/css">
</head>


<script>

//var imgArr = [];
$(document).ready(function(){

    $('#pin_content').redactor({
        imageUpload: 'singleUpload',
        imageResizable: true,
        imagePosition: true,
        minHeight:400,
        callbacks: {
            imageUpload: function(image,json)
            {
                console.log('file', image, json);
                /*
                $('<input />').attr('type', 'hidden')
                .attr('name', "filenames[]")
                .attr('value', link.fileName)
                .appendTo('#pinFrm');
                */
            }
        } 
        /*
        imageUpload: 'singleUpload',
        clickToEdit: true,
        minHeight:400,
        imageUploadCallback: function(option,link){
            console.log('file',link.fileName);
            $('<input />').attr('type', 'hidden')
            .attr('name', "filenames[]")
            .attr('value', link.fileName)
            .appendTo('#pinFrm');
        }
        */
    });
    
    // category select box 
    //$("#category").selectBox('category',2);

    // foursquare category
    var fourCate = function(){
        $.ajax({
            type: "GET",
            url: base_url+'/fourCategories',
            success: function( data ) {
                /*
                console.log('data',data.response.groups[0].items[4].venue.photos.groups[0].items[0].prefix+'300x500'+data.response.groups[0].items[4].venue.photos.groups[0].items[0].suffix);
                */
                $("#category").html("<option value=''>Select</option><option value='explore'>Popular!</option>");
                $.each(data.response.categories,function(i,d){
                    $("#category").append($('<option>', { value : d.id, text : d.name }));
                });
                $("#category").selectpicker('refresh');

                // declare pins use for map
                foursqaurePins = new fourPins(map);
            }
        });
    }
    fourCate();
    
    // category event
    var foursqaurePins = {};
    $("#category").on('change',function(){
        
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
        }
        
    });


    $("#btnResetPins").on('click',function(){
        foursqaurePins.resetPin();
        setTimeout(function(){
            $(".map-simple .pin-control").animate({
                bottom:'-40px'
            })
        },1000);
        $(".four-pin-list .four-list-height").css('height','0px');
        $("#category").val('');
        $("#category").selectpicker('refresh');
    });
    

    // map search
    $("#submit").on('click',function(){

        if(isNullChk($("#title").val())){
            $.alertWindow.init({
                'title' : "Title item is esscential",
                'content' : "Please, check title item then fill it up!",
                'btn' : '<button type="button" class="btn btn-default btn-large btnGapRight">Close</button>'
            },function(){
                $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                    $.alertWindow.close();
                    $("#title").focus();
                });
            });    
            return false;
        }

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
                $.alertWindow.close();
                $("#pinFrm").submit();
            });
        });    
    });

    // prevent submit enter
    $("#simLocation").keypress(function(event) {
        if(event.which == 13) {
            event.preventDefault();
            return false;
        }
    });


    // hash tag
    $("#hash").bind("keyup", function () {

        var input = $(this);
        var value = input.val();
        var ends_with_space = (value.substr(-1) == " ");

        var hashed_value = "";
        var parts = value.split(" ");
        for (var i = 0; i < parts.length; i++) {
        var part = parts[i];
        if (part.indexOf("#") != 0) {
            part = "#" + part;
        }
        if (part != "#") {
            if (hashed_value == "") {
            hashed_value = part;
            } else {
            hashed_value += " " + part;
            }
        }
        }
        if (ends_with_space) {
        hashed_value = hashed_value + " ";
        }
        input.val(hashed_value.replace(",", ""));
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



    // map
    var draggableMarker = true;
    var map = simpleMap(_latitude, _longitude,draggableMarker, _zoom, mapStyles);

    // checkbox 참고(http://montrezorro.github.io/bootstrap-checkbox/)
    $('.pin-check').checkbox();

    // scroll 참고(https://gromo.github.io/jquery.scrollbar/demo/basic.html)
    $('.scrollbar-macosx').scrollbar();

    window.getTempCoordi = getTempCoordi;

});

</script>

<style>
.scroll-element.scroll-x {
    display: none !important;
}
</style>


<body onunload="" class="page-subpage page-submit navigation-off-canvas" id="page-top">
<!-- Outer Wrapper-->
<div id="outer-wrapper">
    <!-- Inner Wrapper -->
    <div id="inner-wrapper">
        <!-- Navigation-->
        @include('top')
        <!-- end Navigation-->
        <!-- Page Canvas-->
        <div id="page-canvas">
            <!--Off Canvas Navigation-->
            <nav class="off-canvas-navigation">
                <header>Navigation</header>
                <div class="main-navigation navigation-off-canvas"></div>
            </nav>
            <!--end Off Canvas Navigation-->

            <!--Sub Header-->
            <section class="sub-header">
                <div class="search-bar horizontal collapse" id="redefine-search-form"></div>
                <!-- /.search-bar -->
                <div class="breadcrumb-wrapper">
                    <div class="container">
                        <div class="redefine-search">
                            <a href="#redefine-search-form" class="inner" data-toggle="collapse" aria-expanded="false" aria-controls="redefine-search-form">
                                <span class="icon"></span>
                                <span>Redefine Search</span>
                            </a>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="index-directory.html"><i class="fa fa-home"></i></a></li>
                            <li><a href="#">Page</a></li>
                            <li class="active">Detail</li>
                        </ol>
                        <!-- /.breadcrumb-->
                    </div>
                    <!-- /.container-->
                </div>
                <!-- /.breadcrumb-wrapper-->
            </section>
            <!--end Sub Header-->

            <!--Page Content-->
            <div id="page-content">
                <section class="container">
                    <div class="row">
                        <!--Content-->
                        <div class="col-md-9">
                            <header>
                                <h1 class="page-title">Submit Item</h1>
                            </header>
                            <form id="pinFrm" name="pinFrm" role="form" method="post" action="addPin" enctype="multipart/form-data">
                                <input type="hidden" name="board_id" value="pinBoard">
                                <input type="hidden" name="rep_img" id="rep_img">
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                                <input type="hidden" name="district" id="district">
                                <input type="hidden" id="country" name="country">
                                <input type="hidden" id="address" name="address">

                                <section>
                                    <div class="form-group large">
                                        <h3>Title</h3>
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                </section>
                                <!--section>
                                    <div class="form-group large">
                                        <h3>What's your goal?</h3>
                                        <select name="category" id="category" class="framed">
                                        </select>
                                    </div>
                                </section-->
                                <section>
                                    <div class="form-group large">
                                        <h3>What you want to talk about?</h3>
                                        <select name="category" id="category" class="framed">
                                        </select>
                                    </div>
                                </section>
                                <!--/#address-contact-->
                                <section>
                                    <h3>Map</h3>
                                    <div class="map-simple">
                                        <div id="map-simple" class="map-submit"></div>
                                        <div class="search-bar">
                                            <div class="main-search">
                                                <div class="input-row">
                                                    <div class="simple-group">
                                                        <div class="location">
                                                            <input type="text" class="form-control" id="simLocation" placeholder="Enter Location">
                                                            <span class="input-group-addon"><i class="fa fa-map-marker geolocation" data-toggle="tooltip" data-placement="bottom" title="Find my position"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pin-control">
                                            <div class="pin-control-btn">
                                                <button type="button" class="btn btn-default" id="btnResetPins">Reset pins</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <!--<h3>Select pins!</h3>-->
                                    <div class="four-pin-list scrollbar-macosx">
                                        <div class="four-list-height" style="width:100%;height:0px;">
                                            <ul id="fourList">
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                                <section style="clear:both">
                                    <h3>Desscription</h3>
                                    <textarea id="pin_content" name="pin_content"></textarea>
                                </section>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group large">
                                                <h3>Tags</h3>
                                                <input type="text" class="form-control" id="hash" name="hash">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <hr>
                            </form>
                            <section>
                                <figure class="pull-left margin-top-15">
                                    <p>By clicking “Submit & Pay” button you agree with <a href="terms-conditions.html" class="link">Terms & Conditions</a></p>
                                </figure>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default pull-right" id="submit">Submit</button>
                                <!-- /.form-group -->
                            </section>
                        </div>
                        <!--/.col-md-9-->
                        <!--Sidebar-->
                        <div class="col-md-3">
                            <aside id="sidebar">
                                <div class="sidebar-box">
                                    <h3>Payment</h3>
                                    <div class="form-group">
                                        <label for="package">Your Package</label>
                                        <select name="package" id="package" class="framed">
                                            <option value="">Select your package</option>
                                            <option value="1">Free</option>
                                            <option value="2">Silver</option>
                                            <option value="3">Gold</option>
                                            <option value="4">Platinum</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <h4>This package includes</h4>
                                    <ul class="bullets">
                                        <li>1 Property</li>
                                        <li>1 Agent Profile</li>
                                        <li class="disabled">Agency Profile</li>
                                        <li class="disabled">Featured Properties</li>
                                    </ul>
                                </div>
                            </aside>
                            <!-- /#sidebar-->
                        </div>
                        <!-- /.col-md-3-->
                        <!--end Sidebar-->
                    </div>
                </section>
            </div>
            <!-- end Page Content-->
        </div>
        <!-- end Page Canvas-->
        <!--Page Footer-->
        @include('bottom')
        <!--end Page Footer-->
    </div>
    <!-- end Inner Wrapper -->
</div>
<!-- end Outer Wrapper-->


<script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/richmarker-compiled.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/icheck.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/jquery.ui.timepicker.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/custom.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/maps.js"></script>
<script type="text/javascript" src="<?=url()?>/redactor/redactor.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/dropzone.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/bootstrap-checkbox.js"></script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>