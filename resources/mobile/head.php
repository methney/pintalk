<?php
require_once '/home/projects/work/vendor/autoload.php';
$pattern = '/\bpin\/\b\d+/'; // https://.../pintalk/pin/3
$pattern2 = '/\bdirect\/\b\d+/'; // https://.../pintalk/direct/3
$pattern3 = '/\bpassword\/reset\/\b\S+/'; 
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
$nodeUrl = 'https://pintalk.co.kr:8890';
$fileDir = $site.'/uploadImages/';
$fileProfileDir = $site.'/uploadProfileImages/';

?>

<head> 
<title>pintalk - Just talk what you see about!</title>
<meta content="IE=edge" http-equiv="x-ua-compatible"> 
<meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport"> 
<meta content="yes" name="apple-mobile-web-app-capable"> 
<meta content="yes" name="apple-touch-fullscreen">
</head>


<!-- Fonts --> 
<link href="https://fonts.googleapis.com/css?family=Dosis:400,600,700|Source+Sans+Pro:300,400|Montserrat:400,700" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'> 
<!-- Icons --> 
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" media="all" rel="stylesheet" type="text/css"> <!-- Styles --> <link 
href="<?=url()?>/assets/mobile/css/keyframes.css" rel="stylesheet" type="text/css"> 
<link href="<?=url()?>/assets/mobile/css/materialize.min.css" rel="stylesheet" type="text/css"> 
<link href="<?=url()?>/assets/mobile/css/swiper.css" rel="stylesheet" type="text/css"> 
<link href="<?=url()?>/assets/mobile/css/swipebox.min.css" rel="stylesheet" type="text/css"> 
<link href="<?=url()?>/assets/mobile/css/style.css" rel="stylesheet" type="text/css">


<script>
// when session alive but no facebook_id, default facebook_id is '-' 
if("<?=Auth::check()?>"!="" && "<?=Session::get('facebook_id')?>"==""){
    location.href = "<?=url()?>/logout";
}


window.base_url = '<?=url()?>';    
window._server_user = [];
window._user = {
    'email' : "<?=Session::get('email')?>"
};
window._chatUser = {};
window._nodeUrl = '<?=$nodeUrl?>';
window._fileDir = '<?=$fileDir?>';
window._chat = "<?= Input::get('chat')?>";                      // true, false (대화수락의 경우, 화면을 indexMap으로 이동하고 채팅창을 연다)
window._pinInfo = false;                                        // foursquare pin list @indexMap
window._iname = "<?= Session::get('name')?>";
window._email = "<?= Session::get('email')?>";
window._latitude = ("<?=Session::get('lat')?>")?"<?=Session::get('lat')?>":'51.541216';
window._longitude = ("<?=Session::get('lng')?>")?"<?=Session::get('lng')?>":'-0.095678';
window._fileProfileDir = '<?=$fileProfileDir?>';                // profile 이미지 경로
window._video = "<?=Session::get('video_enable')?>";
window._audio = "<?=Session::get('audio_enable')?>";
window._page = "<?=Request::url()?>";
window._reviewCheck = {};
window._fourRadius = '1000';                                    // foursquare 핀범위 1000m 
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
window._mobileBg = ['street01.jpg','street02.jpg','street03.jpg','street04.jpg','_DSF2910.jpg','_DSF3020.jpg','_DSF3222.jpg','_DSF3243.jpg'];

var idx=window.location.toString().indexOf("#_=_"); 
if (idx>0) { window.location = window.location.toString().substring(0, idx); }

</script>

<script src="<?=url()?>/assets/mobile/js/jquery-2.1.0.min.js"></script> <script 
src="<?=url()?>/assets/mobile/js/jquery.swipebox.min.js"></script> <script 
src="<?=url()?>/assets/mobile/js/materialize.min.js"></script> <script 
src="<?=url()?>/assets/mobile/js/swiper.min.js"></script> <script 
src="<?=url()?>/assets/mobile/js/jquery.mixitup.min.js"></script> <script 
src="<?=url()?>/assets/mobile/js/masonry.min.js"></script> <script 
src="<?=url()?>/assets/mobile/js/chart.min.js"></script> <script 
src="https://maps.google.com/maps/api/js?key=AIzaSyDC3tDHpHL01AKEm7dhEJFXxOjmYMeNqVU&libraries=places"></script> 
<script src="<?=url()?>/assets/js/jquery.dotdotdot.min.js"></script>
<script type="text/javascript" src="<?=url()?>/socket.io/socket.io.js"></script> 
<script type="text/javascript" src="<?=url()?>/easyrtc/easyrtc.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/audio_video.js"></script> 
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/event.js"></script>
