
<?php
require_once '/home/projects/work/vendor/autoload.php';
$pattern = '/\bpin\/\b\d+/'; // https://.../pintalk/pin/3
$pattern2 = '/\bdirect\/\b\d+/'; // https://.../pintalk/direct/3
$pattern3 = '/\bpassword\/reset\/\b\S+/'; // https://.../password/reset/LI1w2ngBIlR6kuqQQYKlqnWzVN8Lk
if(Auth::check() > 0
|| Request::url()==url().'/auth/login' 
|| Request::url()==url().'/auth/register'
|| preg_match($pattern, Request::url())
|| preg_match($pattern2, Request::url())
|| preg_match($pattern3, Request::url())
|| Request::url()==url().'/indexGuest'
|| Request::url()==url().'/entry'
|| Request::url()==url()
){}else{
    header('Location: '.url());
    die();
}

$site = '';
//$nodeUrl = 'https://pintalk.co.kr:8890';
$nodeUrl = 'https://pintalk.co.kr/nodeRoot/';
$fileDir = $site.'/uploadImages/';
$fileProfileDir = $site.'/uploadProfileImages/';

?>
<title>pintalk - Just talk what you see!</title>

<link href="<?=url()?>/assets/fonts/font-awesome.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Dosis:400,600,700|Source+Sans+Pro:300,400|Montserrat:400,700" rel="stylesheet">
<link rel="stylesheet" href="<?=url()?>/assets/bootstrap/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="<?=url()?>/assets/css/bootstrap-select.min.css" type="text/css">
<link rel="stylesheet" href="<?=url()?>/assets/css/owl.carousel.css" type="text/css">
<!--<link rel="stylesheet" href="<?=url()?>/assets/css/jquery.mCustomScrollbar.css" type="text/css">-->
<!--<link rel="stylesheet" href="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css" type="text/css">-->
<link rel="stylesheet" href="<?=url()?>/assets/css/jquery.scrollbar.css" type="text/css">
<link rel="stylesheet" href="<?=url()?>/assets/css/style.css" type="text/css">
<link rel="stylesheet" href="<?=url()?>/assets/css/user.style.css" type="text/css">
<link rel="stylesheet" href="<?=url()?>/assets/css/anno.css" type="text/css">
<link href="<?=url()?>/assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<script>

if("<?=Auth::check()?>"!="" && "<?=Session::get('facebook_id')?>"==""){
    location.href = "<?=url()?>/logout";
}


window.base_url = '<?=url()?>'; window._server_user = []; window._user = {
    'email' : "<?=Session::get('email')?>"
};
window._chatUser = {};
window._nodeUrl = '<?=$nodeUrl?>';
window._fileDir = '<?=$fileDir?>';
window._chat = "<?= Input::get('chat')?>";                     
window._pinInfo = false;                                        
window._iname = "<?= Session::get('name')?>";
window._email = "<?= Session::get('email')?>";
window._latitude = ("<?=Session::get('lat')?>")?"<?=Session::get('lat')?>":'51.541216';
window._longitude = ("<?=Session::get('lng')?>")?"<?=Session::get('lng')?>":'-0.095678';
window._fileProfileDir = '<?=$fileProfileDir?>';                
window._video = "<?=Session::get('video_enable')?>";
window._audio = "<?=Session::get('audio_enable')?>";
window._page = "<?=Request::url()?>";
window._reviewCheck = {};
window._fourRadius = '1000';                                    
window._fourPinList = 10;
window._zoom = 14;
window._tempCoordi = {
    'toronto': '43.6638125/-79.39068880000002',
    'newyork': '40.7039882/-73.98233420000003',
    'boston' : '42.31331/-71.05883599999999',
    'seoul'  : '37.5057307/127.0234021'
};
window._facebookId = "<?=Session::get('facebook_id')?>"; 
window._youtube = ("<?=Session::get('youtube_enable')?>"=="0")?false:true; 
window._cfg = "<?=Session::get('cfg')?>"; 
window._useCnt = "<?=Session::get('use_cnt')?>"; 
window._streetviewTime = 180; //(3minutes)
window._days = 1; //popup enable for this day;
window._guide = ("<?=Session::get('guide_enable')?>"=="0")?"0":"1";



var idx=window.location.toString().indexOf("#_=_"); 
if (idx>0) { window.location = window.location.toString().substring(0, idx); }
</script>

<script type="text/javascript" src="<?=url()?>/assets/js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/jquery.form.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/bootstrap/js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="<?=url()?>/assets/js/smoothscroll.js"></script>-->
<script type="text/javascript" src="<?=url()?>/assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/jquery.hotkeys.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/jquery.nouislider.all.min.js"></script>
<!--<script type="text/javascript" src="<?=url()?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>-->
<!--<script type="text/javascript" src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>-->
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDC3tDHpHL01AKEm7dhEJFXxOjmYMeNqVU&libraries=places"></script>

<script type="text/javascript" src="<?=url()?>/assets/js/jquery.scrollbar.min.js"></script>
<script type="text/javascript" src="<?=url()?>/socket.io/socket.io.js"></script>
<script type="text/javascript" src="<?=url()?>/easyrtc/easyrtc.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/audio_video.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/event.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/moment.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/anno.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/jquery.scrollintoview.min.js"></script>


<script> $(document).ready(function(){
   $('meta[name="viewport"]').prop('content', 'width=1440');
});
</script>
