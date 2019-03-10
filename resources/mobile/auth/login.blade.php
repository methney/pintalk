<!DOCTYPE html>
<html lang="en-US">
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
                            //sentMail();
                        }else{
                            //sentMail('f');
                        } 
                    }
                });
            });
        });
    });


  

    

});
</script>


  <body>
    @include('top')

    <div class="m-scene" id="main"> <!-- Main Container -->

      <!-- Sidebars -->
      <!-- Right Sidebar -->
      @include('right')
      <!-- Left Sidebar -->
      @include('left')
      <!-- End of Sidebars -->

      
      <!-- Page Content -->
      <div id="content" class="grey-blue login">

        <!-- Toolbar -->
        <div id="toolbar" class="tool-login primary-color animated fadeindown">
          <a href="javascript:history.back()" class="open-left">
            <i class="ion-android-arrow-back"></i>
          </a>
        </div>
        
        <!-- Main Content -->
        <div class="login-form animated fadeinup delay-2 z-depth-1">
          <form role="form" method="POST" action="login" id="loginFrm" >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="redirectUrl" id="redirectUrl" >

          <h1>Login</h1>
          <div class="input-field">
            <i class="ion-android-contact prefix"></i> 
            <input class="validate" id="email" name="email" type="text" value="{{ old('email') }}"> 
            <label for="email">Email</label>
          </div>

          <div class="input-field" style="margin-bottom:20px;">
            <i class="ion-android-lock prefix"></i> 
            <input class="validate" id="login-psw" type="password" name="password"> 
            <label for="login-psw">Password</label>
          </div>

          <button class="waves-effect waves-light btn-large width-100 m-b-20 animated bouncein delay-4">Login</button>

          </form>

          
          <button class="waves-effect waves-light btn-large width-100 m-b-20 animated bouncein delay-4" id="btnFacebook" type="button">facebook login</button>


          <div style="width:100%;margin-top:10px;text-align:center">
            <span>Don't have an account? <a class="primary-text" href="signup.html">Sign Up</a></span>
          </div>
        </div><!-- End of Main Contents -->
      
       
      </div> <!-- End of Page Content -->

      </form>

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

    </div> <!-- End of Page Container -->
    

    @include('bottom')


    <form method="post" id="facebookFrm">
        <input type="hidden" name="redirectUrl" id="redirectUrlFacebook">
    </form>

    <script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
    <script type="text/javascript" src="<?=url()?>/assets/js/icheck.min.js"></script>



  </body>
</html>