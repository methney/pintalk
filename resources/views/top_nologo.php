
<style>
.wrapper .brand a{
    font-family:'Dosis';
    font-weight:600;
    color:#c0c0c0;
    margin-top:15px;
}

a{
    text-decoration:none;
}
</style>

<script>

var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;





$(function(){

    /*
    if(isMobile){
        $.alertWindow.init({
            'title' : "It's not working on mobile devices!",
            'content' : "You can use pintalk on your desktop pc now, <br>It'll be able to use in any devices in really soon!",
            'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
        },function(){
            $('.alert-window .alert-btn :button:eq(0)').on('click',function(){
                $.alertWindow.close();
                closeRTC();
                return false;
            });
        });
        return false;
    }
    */


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

    // 상단 how to use pintalk
    $('.brand .hand').off('click').on('click',function(){
        $.guideWindow.init(function(){

            $("#visitblog").off('click').on('click',function(){
                window.open('<?=url()?>/wordpress');
                $.guideWindow.close();
            });


            $("#takemyfriends").off('click').on('click',function(){
                $.guideWindow.close();

                // tour make active!
                tour.tourEnabled();
                tour.doAllClose();

                // indexGuest 
                if(_email=='' && '<?=Request::url()?>'=='<?=url()?>'){
                    setTimeout(function(){
                        tour.doit();
                    },500);
                }else if(_email!='' && '<?=Request::url()?>'=='<?=url()?>'){
                    setTimeout(function(){
                        tour.reload();
                        tour.doNext();
                    },500);    
                // indexHost    
                }else if(_email!='' && '<?=Request::url()?>'=='<?=url()?>/indexHost'){
                    setTimeout(function(){
                        tour.reload();
                        tour.doit();
                    },500);    
                }
            });
        });
    });


});



</script>

<!--a class="hand" onclick="window.open('<?=url()?>/wordpress')" >HOW TO USE PINTALK?</a-->

<!-- Navigation-->
<div class="header">
    <div class="wrapper">
        <div class="brand">
            <a class="hand" href="#">HOW TO USE PINTALK?</a>
        </div>
        <nav class="navigation-items">
            <div class="wrapper">
                <ul class="main-navigation navigation-top-header">
                </ul>
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
                <?php if(Auth::check()){ ?>
                <a href="<?=url()?>/indexHost" class="submit-item">
                    <!--div class="content"><span>Make your own pin!</span></div-->
                    <div class="icon">
                        <i class="fa fa-plus"></i>
                    </div>
                </a>
                <?php } ?>

            </div>
        </nav>
    </div>
</div>

<input type="hidden" id="fb_sess_chk">