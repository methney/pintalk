<!DOCTYPE html>
@include('head')

<script>
$(function(){
    $("#redirectUrl").val('<?=URL::previous()?>');
    $("#redirectUrlFacebook").val('<?=URL::previous()?>');
    $("#btnFacebook").off('click').on('click',function(){
        $("#facebookFrm").attr("action", base_url+'/facebook');
        $("#facebookFrm").submit();
    });


    // event
    $("#forgotPassword").on('click',function(){
        $.alertWindow.init({
            'title' : "Please, input your email!",
            'content' : "<input type='text' class='form-control' id='passEmail' placeholder='Email' style='margin-top:10px;'><div class='floatL' style='margin-top:10px;'>We will send you new password to your registered email</div>",
            'btn' : '<button type="button" class="btn btn-default btn-large">Submit</button>'
        },function(){

            $("#passEmail").keypress(function(event) {
                if(event.which == 13) {
                    $('.alert-window .alert-btn :button:eq(0)').trigger('click');
                }
            });

            $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){

                $("#passEmailSpan").html('');

                if(isNullChk($("#passEmail").val())){
                    var msg = "<span id='passEmailSpan' style='color:#999;'>It's blank!</span>";
                    $(msg).insertAfter($("#passEmail"));
                    return false;
                }
                    
                $("#passEmailSpan").remove();

                var email = $("#passEmail").val();
                $.alertWindow.init({
                    'title' : "Please wait!",
                    'content' : "We are checking your account...",
                    'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                },function(){
                    $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                        $.alertWindow.close();
                    });
                });

                $.ajax({
                    type: "POST",
                    url: base_url+'/password/sendPassMail',
                    data: {'email': email, 'token': "{{ csrf_token() }}"},
                    success: function(data) {
                        
                        if(data.success){
                            sentMail();
                        }else{
                            sentMail('f');
                        } 
                    }
                });
            });
        });
    });

    // 메일발송완료 
    function sentMail(value){
        if(value=='f'){
            $.alertWindow.init({
                'title' : "Someting went wrong!",
                'content' : "Please contact us our at customer service!",
                'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
            },function(){
                $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                    $.alertWindow.close();
                });
            });
        }else{
            $.alertWindow.init({
                'title' : "Please check your email!",
                'content' : "We sent you the procedure to change your password!",
                'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
            },function(){
                $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                    $.alertWindow.close();
                });
            });
        }
    }

    // tour(guide)
    var tourData = [
        {
            target  : '.btnFacebook',
            position: 'right',
            content : "If you have a facebook account, just login! you don't need to sign up!",
            autoFocusLastButton:false,
            onShow: function (anno, $target, $annoElem) {
                tour.removeBg();
            },
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
    setTimeout(function(){
        tour.init(tourData);
        tour.doit();
    },500);

});
</script>
    
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <!--div class="redefine-search">
                            <a href="#redefine-search-form" class="inner" data-toggle="collapse" aria-expanded="false" aria-controls="redefine-search-form">
                                <span class="icon"></span>
                                <span>Redefine Search</span>
                            </a>
                        </div-->
                        <ol class="breadcrumb">
                            <li><a href="/"><i class="fa fa-home"></i></a></li>
                            <li><a href="#">Login</a></li>
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
                                    <h1 class="page-title">Login</h1>
                                </header>
                                <hr>
                                <form class="form-horizontal" role="form" method="POST" action="login">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="redirectUrl" id="redirectUrl">
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">                                    
                                    </div><!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" name="password">
                                    </div><!-- /.form-group -->
                                    <div class="form-group clearfix floatTop w100">
                                        <!-- ajaxSubmit 이어도 type은 submit이 맞다-->
                                        <button type="submit" class="btn btn-default floatTop w50">Login</button>
                                        <img src="<?=url()?>/assets/img/facebook_login.png" id="btnFacebook" class="btnFacebook hand">
                                    </div><!-- /.form-group -->
                                    <div class="checkbox floatTop w100">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </form>
                                <hr>
                                <div class="center">
                                    <figure class="note"><a href="#" id="forgotPassword">Forgot Your Password?</a></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.block-->
            </div>
            <!-- end Page Content-->

            @if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif  

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