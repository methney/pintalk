<!DOCTYPE html>
@include('head')
<script>
$(function(){

    $("#password_confirmation").keypress(function(event) {
        if(event.which == 13) {
            $('#btnSubmit').trigger('click');
        }
    });


	$("#btnSubmit").on('click',function(){
        
        $.ajax({
            type: "POST",
            url: base_url + "/password/reset",
            data: $("#resetFrm").serialize(),
            success: function(data) {

                if(data.success){
                    $.alertWindow.init({
                        'title' : "Password reset completed!",
                        'content' : "Please use your new password!",
                        'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                    },function(){
                        $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                            $.alertWindow.close();
                            location.href = base_url + '/';
                        });
                    });
                }else{
                    $.alertWindow.init({
                        'title' : "Something went wrong changing pasword!",
                        'content' : "It might be a different email address or bad trying.",
                        'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                    },function(){
                        $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                            $.alertWindow.close();
                        });
                    });
                }
            }
        });
	});
});
</script>



<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotter - Universal Directory Listing HTML Template</title>
</head>

<body onunload="" class="page-subpage page-register navigation-top-header" id="page-top">
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
                    <div class="block">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                                <header>
                                    <h1 class="page-title">Reset Password</h1>
                                </header>
                                <hr>
                                <form class="form-horizontal" role="form" method="POST" action="<?=url()?>/password/reset" id="resetFrm">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" name="email">                                    
                                    </div><!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" name="password">
                                    </div><!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default" id="btnSubmit">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.block-->
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

<form method="post" id="facebookFrm">
    <input type="hidden" name="redirectUrl" id="redirectUrlFacebook">
</form>



<script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/icheck.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/custom.js"></script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>

