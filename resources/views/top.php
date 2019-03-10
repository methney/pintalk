<script>

$(function(){

   // chrome target _blank issue.
    $("#avatarTop").off('click').on('click',function(){
        <?php if(Session::get('facebook_id')=='-'){ ?>
            linkFilter(base_url+"/profile?email=<?=Session::get('email')?>");
            //window.location.href = base_url+"/profile?email=<?=Session::get('email')?>";
        <?php }else{ ?>
            window.open('<?=Session::get('link')?>');return false;
        <?php } ?>
    });


    // make avatar url depend on where this comes from
    <?php if(Session::get('avatar')){ ?>
        <?php if(Session::get('facebook_id')=='-'){ ?>
            $("#avatarTop").attr("src", _fileProfileDir + "<?=Session::get('avatar')?>");
        <?php }else{ ?>
            $("#avatarTop").attr("src", "<?=Session::get('avatar')?>");
        <?php } ?>    
    <?php } ?>

    /*
    $('#logo').on('click', function(){
        linkFilter(base_url);
    });
    */

});

</script>

<!-- Navigation-->
<div class="header">
    <div class="wrapper">
        <div class="brand">
            <a href="#" onclick="linkFilter('<?=url()?>');"><img src="<?=url()?>/assets/img/logo.png" alt="logo" id="logo" class="hand"></a>
        </div>
        <nav class="navigation-items">
            <div class="wrapper">
                <!--<ul class="main-navigation navigation-top-header">
                </ul>-->
                <ul class="user-area">
                    <?php if(Auth::check()){ ?>
                        <li><img src="<?=url()?>/assets/img/member-5.jpg" class="avatarTop hand" id="avatarTop" ></li>
                        <li><a href="#" onclick="linkFilter('<?=url()?>/profile?email=<?=Session::get('email')?>');"><?=Session::get('name')?></a></li>
                        <li><a href="<?=url()?>/logout">Log out</a></li>
                    <?php }else{ ?>
                        <li><a href="<?=url()?>/auth/login">Log In</a></li> 
                        <li><a href="<?=url()?>/auth/register"><strong>Sign Up</strong></a></li>
                    <?php } ?>    
                    
                </ul>
                <!--<a href="<?=url()?>/pinRegister" class="submit-item">-->
                <?php if(Auth::check()){ ?>
                <a href="<?=url()?>/indexHost" class="submit-item">
                    <!--div class="content"><span>Make your own pin!</span></div-->
                    <div class="icon">
                        <i class="fa fa-plus"></i>
                    </div>
                </a>
                <?php } ?>
                <?php if(Session::get('email')=='mindcure@nate.com'){?>
                <div class="toggle-navigation">
                    <div class="icon">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </nav>
    </div>
</div>

