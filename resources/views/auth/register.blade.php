<!DOCTYPE html>
@include('head')
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotter - Universal Directory Listing HTML Template</title>

</head>

<script>
var $ = jQuery.noConflict();

$( document ).ready(function(){

    /*
    // execute!
    initialCodeFrm();

    
    $("#regFrm").ajaxForm({
        success: function( data ){
            alert('Complete!');
            initialCodeFrm();
        }, 
        error: function(){
            console.log('something wrong!');
        }
    });
    
    function initialCodeFrm(){

        $("#userNm").val("");
        $("#userEmail").val("");
        $("#userPwd").val("");
        $("#userPwdChk").val("");

    };
    */


    $("#btnSubmit").on('click',function(){
        $.alertWindow.init({
            'title': "Only facebook account is available now!",
            'content': "Please login with your facebook account!<br>It doesn't need signning up process! just login!",
            'btn': '<button type="button" class="btn btn-default btn-large">Close</button>'
        }, function () {
            $('.alert-window .alert-btn :button:eq(0)').on('click', function () {
                $.alertWindow.close();
                location.href="<?=url()?>/auth/login";
                return false;
            });
        });

        return false;
    });

    

});

function termsandcondition(){
    $("#term").css("display","block");
}


</script>


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
                            <li><a href="#">SignIn</a></li>
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
                                    <h1 class="page-title">Sign up</h1>
                                </header>
                                <hr>
                                <form class="form-horizontal" role="form" method="POST" action="register">
						        <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                                <!--<form role="form" id="regFrm" method="post" action="addUser">-->
                                    <div class="form-group">
                                        <label for="name">Full Name:</label>
                                        <!--<input type="text" class="form-control" id="userNm" name="userNm" required>-->
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    </div><!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <!--<input type="email" class="form-control" id="userEmail" name="userEmail" required>-->
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    </div><!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <!--<input type="password" class="form-control" id="userPwd" name="userPwd" required>-->
                                        <input type="password" class="form-control" name="password">
                                    </div><!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password:</label>
                                        <!--<input type="password" class="form-control" id="userPwdChk" name="userPwdChk" required>-->
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div><!-- /.form-group -->
                                    <div class="checkbox pull-left">
                                        <label>
                                            <input type="checkbox" name="newsletter">Receive Newsletter
                                        </label>
                                    </div>
                                    <div class="form-group clearfix">
                                        <!-- ajaxSubmit 이어도 type은 submit이 맞다-->
                                        <button type="button" class="btn pull-right btn-default" id="btnSubmit">Create an Account</button>
                                    </div><!-- /.form-group -->
                                </form>
                                <hr>
                                <div class="center">
                                    <figure class="note">By clicking the “Create an Account” button you agree with our <span onclick="termsandcondition()" class="link hand" style="color:red">Terms and conditions</span></figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block" id="term">
                        <div class="row">
                            <div class="div-term">
                                <h2>TERMS AND CONDITONS</h2>
                                <ul>
                                    <li>pintalk follow each api's policy.</li>
                                    <li>pintalk doesn't colloect your personal information except facebook's policy allows us.</li>
                                    <li>Data from foursquare will be removed in a monthly basis. That might affect your talking pins. </li>
                                    <li>pintalk can collect what users write or speak but it's not related to users themselves. it's for statistical use. And it makes better pintalk for sure.</li>
                                    <li>This is on beta service now, some other policy can be added on the list.</li>
                                    <li>When user registers, it regards to be agreed with this policy.</li>
                                </ul>

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
<script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/icheck.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/custom.js"></script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>