<?php
    include 'head.php';
?>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<script>
$(function(){

    <?php if(Session::get('facebook_id')=='-'){ ?>
        $("#profile-picture").dropzone({
            url: "profileImgUpload",
            addRemoveLinks: true,
            init : function(){
                this.on('complete',function(file){
                    var fileName = JSON.parse(file.xhr.response);
                    $("#rep_img").val(fileName.fileName);
                });
            }
        });
    <?php }else{ ?>
        $("#name").attr("readonly","readonly");
        $("#profile-picture").on('click',function(){
            notFix();
        });
    <?php } ?>

    // profile 
    var init = function(email){

        var draggableMarker = true;
        var zoom = 1;
    

        $.ajax({
            type: "POST",
            url: base_url+'/callUserInfo',
            data: {'email':email},
            success: function( data ) {
                $("#name").val(data[0].name);
                $("#email").val(data[0].email);
                $("#passwordEmail").val(data[0].email);
                $("#aboutme").val(data[0].aboutme);

                if(data[0].video_enable==1){
                    $('input:radio[name=video][value=1]').prop('checked',true);
                }else{
                    $('input:radio[name=video][value=0]').prop('checked',true);
                }

                if(data[0].audio_enable==1){
                    $('input:radio[name=audio][value=1]').prop('checked',true);
                }else{
                    $('input:radio[name=audio][value=0]').prop('checked',true);
                }

                if(data[0].youtube_enable==1){
                    $('input:radio[name=youtube][value=1]').prop('checked',true);
                }else{
                    $('input:radio[name=youtube][value=0]').prop('checked',true);
                }

                if(!isNullChk(data[0].avatar)){
                    <?php if(Session::get('facebook_id')=='-'){ ?>
                        $("#profileImg").attr("src","<?=$fileProfileDir?>" + data[0].avatar);
                    <?php }else{ ?>
                        $("#profileImg").attr("src","<?=Session::get('avatar')?>");
                    <?php } ?>
                }else{
                    $("#profileImg").attr("src", base_url + "/assets/img/sunny-suite.png");
                }
                var cnt = $("#aboutme").val().length;
                $("#aboutmeSpan").html(cnt);

                var lat = data[0].lat;
                var lng = data[0].lng;

                // map 
                simpleMap(isNullChk(lat)?_latitude:lat, isNullChk(lng)?_longitude:lng, draggableMarker, zoom, mapStyles2);

            }
        });
    };

    // some elements can't be modifed
    var notFix = function(){
        // can't modify facebook information
        $.alertWindow.init({
            'title' : "It can't be modified!",
            'content' : "You are logged in using facebook profile which can be modified at facebook site!",
            'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
        },function(){
            $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                $.alertWindow.close();
            });
        });
    };

    $("#aboutme").on('keypress',function(){
        var cnt = $(this).val().length;
        $("#aboutmeSpan").html(cnt);
    });

    init("<?=Request::get('email')?>");
    
    


    // when submit
    $("#submit").on('click', function(){

        // protect html injection  
        var val = $("#aboutme").val();
        var aboutme = val.replace(/<\/?[^>]+(>|$)/g, "");
        $("#aboutme").val(aboutme);


        $.ajax({
            type: "POST",
            url: base_url+'/modifyProfile',
            data: $("#uFrm").serialize(),
            success: function( data ) {

                $.alertWindow.init({
                    'title' : "It's modified!",
                    'content' : "Next time you log in, it'll applied!",
                    'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                },function(){
                    $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                        $.alertWindow.close();
                        init("<?=Request::get('email')?>");
                    });
                });

            }
        });

    })



    // change password by keypress
    $("#confirm-new-password").keypress(function(event) {
        if(event.which == 13) {
            $('#btnChangePassword').trigger('click');
        }
    });

    // chagne password
    $("#btnChangePassword").on('click',function(){

        $.ajax({
            type: "POST",
            url: base_url+'/password/changePassword',
            data: $("#pFrm").serialize(),
            success: function( data ) {
                
                if(data.success){
                
                    $.alertWindow.init({
                        'title' : "It's updated!",
                        'content' : "Next time you log in, it'll applied!",
                        'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                    },function(){
                        $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                            $.alertWindow.close();
                            $("#current-password").val('');
                            $("#new-password").val('');
                            $("#confirm-new-password").val('');
                        });
                    });
                }else{
                    // wrong comfirmation
                    if(data.error>0){
                       $.alertWindow.init({
                            'title' : "Confirmation password is wrong!",
                            'content' : "Please try again",
                            'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                        },function(){
                            $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                                $.alertWindow.close();
                                $("#new-password").val('');
                                $("#confirm-new-password").val('');
                                $("#new-password").focus();
                            });
                        }); 
                    }else{
                        // wrong current password
                        $.alertWindow.init({
                            'title' : "Current password is wrong!",
                            'content' : "Please try again",
                            'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                        },function(){
                            $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                                $.alertWindow.close();
                                $("#current-password").val('');
                                $("#current-password").focus();
                            });
                        }); 
                    }
                }
            }
        });
    });



});

</script>



<body onunload="" class="page-subpage page-profile navigation-top-header" id="page-top">
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
                <!--<div class="main-navigation navigation-off-canvas"></div>-->
            </nav>
            <!--end Off Canvas Navigation-->

            <!--Sub Header-->
            <section class="sub-header">
                <div class="search-bar horizontal collapse" id="redefine-search-form"></div>
                <!-- /.search-bar -->
                <div class="breadcrumb-wrapper">
                    <div class="container">
                        <!--div class="redefine-search">
                            <a href="#redefine-search-form" class="inner" data-toggle="collapse" aria-expanded="false" aria-controls="redefine-search-form">
                                <span class="icon"></span>
                                <span>Redefine Search</span>
                            </a>
                        </div-->
                        <ol class="breadcrumb">
                            <li><a href="/"><i class="fa fa-home"></i></a></li>
                            <li><a href="#">MyPage</a></li>
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
                    <header>
                        <ul class="nav nav-pills">
                            <li class="active"><a href="<?=url()?>/profile?email=<?=Session::get('email')?>"><h1 class="page-title"><?=Session::get('name')?></h1></a></li>
                            <!--li><a href="my-items.html"><h1 class="page-title">My Items</h1></a></li-->
                        </ul>
                    </header>
                    <div class="row">
                        <div class="col-md-9">
                            <form role="form" method="post" name="uFrm" id="uFrm" >
                                <input type="hidden" id="rep_img" name="avatar" value="<?=Session::get('avatar')?>">
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                                <div class="row">
                                    <!--Profile Picture-->
                                    <div class="col-md-3 col-sm-3">
                                        <section>
                                            <h3><i class="fa fa-image"></i>Profile Picture</h3>
                                            <div id="profile-picture" class="profile-picture dropzone">
                                                <input name="file" type="file" id="pFile">
                                                <div class="dz-default dz-message"><span>Click or drop picture here</span></div>
                                                <img src="<?=url()?>/assets/img/member-2.jpg" id="profileImg" class="profileImg">
                                            </div>
                                        </section>
                                    </div>
                                    <!--/.col-md-3-->

                                    <!--Contact Info-->
                                    <div class="col-md-9 col-sm-9">
                                        <section>
                                            <h3><i class="fa fa-user"></i>Personal Info</h3>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name">
                                                    </div>
                                                    <!--/.form-group-->
                                                </div>
                                                <!--/.col-md-3-->
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" readonly="readonly">
                                                    </div>
                                                    <!--/.form-group-->
                                                </div>
                                                <!--/.col-md-3-->
                                            </div>
                                        </section>
                                        <section>
                                            <h3><i class="fa fa-info-circle"></i>About Me</h3>
                                            <div class="form-group">
                                                <label for="about-me">Some Words About Me (<span id="aboutmeSpan"> 0</span> in 100 characters)</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="aboutme" rows="3" name="aboutme" required></textarea>
                                                </div>
                                                <!--/.form-group-->
                                            </div>
                                            <!--/.form-group-->
                                        </section>
                                        <section>
                                            <div class="form-group">
                                                <label for="video">Video</label>
                                                <label class="radio-inline"><input type="radio" name="video" value="1">On</label>
                                                <label class="radio-inline"><input type="radio" name="video" value="0">Off</label>
                                            </div>
                                        </section>
                                        <section>
                                            <div class="form-group">
                                                <label for="audio">Audio</label>
                                                <label class="radio-inline"><input type="radio" name="audio" value="1">On</label>
                                                <label class="radio-inline"><input type="radio" name="audio" value="0">Off</label>
                                            </div>
                                        </section>
                                        <section>
                                            <div class="form-group">
                                                <label for="audio">Youtube</label>
                                                <label class="radio-inline"><input type="radio" name="youtube" value="1">On</label>
                                                <label class="radio-inline"><input type="radio" name="youtube" value="0">Off</label>
                                            </div>
                                        </section>
                                        <section>
                                            <h3>Where you belong to..</h3> 
                                            <div class="map-simple">
                                                <div id="map-simple" class="map-submit"></div>
                                                <div class="search-bar">
                                                    <div class="main-search">
                                                        <div class="input-row">
                                                            <div class="simple-group">
                                                                <div class="location">
                                                                    <input type="text" class="form-control" name="location" id="simLocation" placeholder="Enter Location">
                                                                    <span class="input-group-addon"><i class="fa fa-map-marker geolocation" data-toggle="tooltip" data-placement="bottom" title="Find my position"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-large btn-default" id="submit">Save Changes</button>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!--/.col-md-6-->
                                </div>
                            </form>
                        </div>
                        <!--Password-->
                        <div class="col-md-3 col-sm-9">
                            <h3><i class="fa fa-asterisk"></i>Password Change</h3>
                            <form class="framed" id="pFrm" role="form" >
                                <input type="hidden" name="email" id="passwordEmail">
                                <div class="form-group">
                                    <label for="current-password">Current Password</label>
                                    <input type="password" class="form-control" id="current-password" name="current-password">
                                </div>
                                <!--/.form-group-->
                                <div class="form-group">
                                    <label for="new-password">New Password</label>
                                    <input type="password" class="form-control" id="new-password" name="new-password">
                                </div>
                                <!--/.form-group-->
                                <div class="form-group">
                                    <label for="confirm-new-password">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm-new-password" name="confirm-new-password">
                                </div>
                                <!--/.form-group-->
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" id="btnChangePassword">Change Password</button>
                                </div>
                                <!-- /.form-group -->
                            </form>
                        </div>
                        <!-- /.col-md-3-->
                    </div>
                </section>
            </div>
            <!-- end Page Content-->
        </div>
        <!-- end Page Canvas-->
        <!--Page Footer-->
        <?php include 'bottom.php'; ?>
        <!--end Page Footer-->
    </div>
    <!-- end Inner Wrapper -->
</div>
<!-- end Outer Wrapper-->
<script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/richmarker-compiled.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/jquery.ui.timepicker.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/icheck.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/custom.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/maps.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/dropzone.min.js"></script>


<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>