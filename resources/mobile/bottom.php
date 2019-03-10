

<script type="text/javascript" src="<?=url()?>/assets/mobile/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/infobox.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/richmarker-compiled.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/markerclusterer.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/custom.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/leaflet.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/mobile/js/functions.js"></script>



<!-- mobile main slide template -->
<script type="text/x-template" id="mobileSliderTpl">
<div class="swiper-slide mobile-bg-{{idx}}">
    <div class="opacity-overlay-black"></div>
    <div class="bottom-abs left-align">
        <p class="slider-category white-text">{{category}}</p>
        <h4 class="slider-title uppercase white-text">{{title}}</h4>
        <p class="slider-text small white-text">{{description}}</p>
        <a class="waves-effect waves-light btn-large primary-color block animated bouncein delay-4" href="article.html">Read More</a> 
    </div>
</div>
</script>


<form id="chatFrm" name="chatFrm" method="post" action="/chat" style="height:0px;margin:0px;">
    <input type="hidden" name="chat" id="chatFrm_chat">
    <input type="hidden" name="subscriber" id="chatFrm_subscriber">
    <input type="hidden" name="room_id" id="chatFrm_room_id">
    <input type="hidden" name="pin_id" id="chatFrm_pin_id">
</form>
