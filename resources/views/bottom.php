
<!--alert window-->
<script type="text/x-template" id="alertWindowTpl">
    <div class="alert-window modal-window fade_in">
        <!--looks popup itself-->
        <div class="modal-pop-wrapper alert-pop">
            <div class="alert-title">
                <h2>{{title}}</h2>
            </div>
            <div class="alert-content">
                {{content}}
            </div>
            <div class="alert-btn">
                {{button}}
            </div>
            <div class="alert-close"><img src="<?=url()?>/assets/img/close.png"></div>
        </div>
        <!--transparent background-->
        <div class="modal-background fade_in"></div>
    </div>
</script>



<!--popup window-->
<script type="text/x-template" id="popUpInDaysTpl">
    <div class="pop-up-days modal-window fade_in">
        <!--looks popup itself-->
        <div class="modal-pop-wrapper alert-pop">
            <div class="alert-content scrollbar-macosx">
                {{content}}
            </div>
            <div class="alert-btn">
                {{button}}
            </div>
            <div class="alert-close"><img src="<?=url()?>/assets/img/close.png"></div>
        </div>
        <!--transparent background-->
        <div class="modal-background fade_in"></div>
    </div>
</script>



<!--foursquare-->
<script type="text/x-template" id="fourSiteTpl">
    <div class="alert-window modal-window fade_in">
        <!--looks popup itself-->
        <div class="modal-pop-wrapper alert-pop">
            <div class="site">
                <iframe src="{{url}}" style="border: 0px none; height: 100%; width: 926px;"></iframe>
            </div>
            <div class="alert-close"><img src="<?=url()?>/assets/img/close.png"></div>
        </div>
        <!--transparent background-->
        <div class="modal-background fade_in"></div>
    </div>
</script>


<!--guide-->
<script type="text/x-template" id="guideChoiceTpl">
    <div class="guide-window modal-window fade_in">
        
        <div class="modal-pop-wrapper alert-pop">
            <div class="content-pop-wrapper">
                <div class="pop-left"><a class="hand" id="visitblog">VISIT BLOG</a></div>
                <div class="pop-right"><a class="hand" id="takemyfriends">HOW TO USE?<br>FOLLOW STEPS!</a></div>
            </div>
            <div class="alert-close"><img src="<?=url()?>/assets/img/close.png"></div>
        </div>
        
        <!--transparent background-->
        <div class="modal-background fade_in"></div>
    </div>
</script>



<!--chat guide-->
<script type="text/x-template" id="chatGuideChoiceTpl">
    <div class="chat-guide-window modal-window fade_in">
        
        <div class="modal-pop-wrapper alert-pop">
            <div class="chat-guide-title">
                <h2>People could use Pintalk just like this!</h2>
            </div>
            <div class="content-pop-wrapper">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/MfCul3sSwPE" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="alert-btn">
                <button type="button" class="btn btn-default btn-large">Close</button>
            </div>
            <div class="alert-close"><img src="<?=url()?>/assets/img/close.png"></div>
        </div>
        
        <!--transparent background-->
        <div class="modal-background fade_in"></div>
    </div>
</script>



<script>
var cfg = "<?= Session::get('cfg')?>";
var cfg_video = "<?= Session::get('video_enable')?>";
var cfg_audio = "<?= Session::get('audio_enable')?>";
var cfg_youtube = "<?= Session::get('youtube_enable')?>";
var video_true = (cfg_video=='1')?'checked="checked"':'';
var video_false = (cfg_video!='1')?'checked="checked"':'';
var youtube_true = (cfg_youtube=='1')?'checked="checked"':'';
var youtube_false = (cfg_youtube!='1')?'checked="checked"':'';
var tpl = 
    '<section>' + 
        '<div class="form-group">' + 
            '<label for="video">Video Chat</label>' + 
            '<label class="radio-inline"><input type="radio" name="video" value="1" ' + video_true +
            '>On</label>' + 
            '<label class="radio-inline"><input type="radio" name="video" value="0" ' + video_false +
            '>Off</label>' + 
        '</div>' + 
    '</section>' + 
    '<section>' + 
        '<div class="form-group">' + 
            '<label for="audio">Youtube</label>' + 
            '<label class="radio-inline"><input type="radio" name="youtube" value="1" ' + youtube_true + 
            '>On</label>' + 
            '<label class="radio-inline"><input type="radio" name="youtube" value="0" ' + youtube_false + 
            '>Off</label>' + 
        '</div>' + 
    '</section><br>';


    

function chkCfg(){

    if(cfg=='false'){

        $.alertWindow.init({
            'title': "Please, Check this out!",
            'content': tpl,
            'btn': '<button type="button" class="btn btn-default btnGapRight">Save</button><button type="button" class="btn btn-default">Close</button>'
        }, function () {
            $('.alert-window .alert-btn :button:eq(0)').on('click', function () {
                $("#cfg_video").val($('input:radio[name=video]:checked').val());
                $("#cfg_youtube").val($('input:radio[name=youtube]:checked').val());

                var data = $("#cfgFrm").serialize();
                $.ajax({
                    type: "POST",
                    url: base_url+'/cfg',
                    data: data,
                    success: function( data ) {

                        $.alertWindow.init({
                            'title' : "It's applied! Thank you!",
                            'content' : "Enjoy your talking!",
                            'btn' : '<button type="button" class="btn btn-default btn-large">Close</button>'
                        },function(){
                            $('.alert-window .alert-btn :button:eq(0)').off('click').on('click',function(){
                                $.alertWindow.close();
                                location.reload();
                            });
                        }); 
                    }
                });
            });
            $('.alert-window .alert-btn :button:eq(1)').on('click', function () {
                $.ajax({
                    type: "POST",
                    url: base_url+'/cfg_close',
                    data: {},
                    success: function( data ) {
                        $.alertWindow.close();
                        location.reload();
                    }
                });
            });
        });
        return false;
    }
}


$(function(){
    // 첫 로긴시, 대화바로 이전에 2번 띄움.
    //chkCfg();
});

</script>


<div id="floorAlert">
    <input type="hidden" id="currentSubscriber">
    <div class="col-md-7 col-sm-7">
        <div class="floor_profile"><img class="avatarBottom hand" id='floorAvatar'></div>
        <div class="floor_msg hand" id='floorMsg'></div>
    </div>
    <div class="col-md-4 col-sm-4"></div>
    <div class="col-md-1 col-sm-1">    
        <div class="floor_btn"><button type="button" id="btnReceiveTalk" class="btn btn-default btn-large">PinTalk!</button></div>
        <div class="floor_btnClose" id="btnIgnoringCall"><img src="<?=url()?>/assets/img/close.png"></div>
    </div>
</div>

<div class="pinPop"></div>
<div class="profilePop"></div>

<form id="chatFrm" name="chatFrm" method="post" action="/chat" style="height:0px;margin:0px;">
    <input type="hidden" name="chat" id="chatFrm_chat">
    <input type="hidden" name="subscriber" id="chatFrm_subscriber">
    <input type="hidden" name="room_id" id="chatFrm_room_id">
    <input type="hidden" name="pin_id" id="chatFrm_pin_id">
</form>


<form id="cfgFrm" name="cfgFrm" method="post" action="/cfg" style="height:0px;margin:0px;">
    <input type="hidden" name="video" id="cfg_video">
    <input type="hidden" name="youtube" id="cfg_youtube">
</form>


<script type="text/x-template" id="fourPinListTpl">
<li class="four-list-{{idx}}" data-sort="{{idx}}">
    <div class="row">
        <div class="pin-number">{{idx}}</div>
        <div class="pin-title-div">
            <div class="pin-title"><a href="{{link}}" target="_blank">{{title}}</a></div>
            <div class="pin-category">{{category}}</div>
        </div>
        <div class="pin-load">
            <!--<button type="button" class="btn btn-default" id="btnPinLoad">Load Pin</button>-->
            <input type="checkbox" class="pin-check" name="fourUse[]" value="{{idx}}" checked="true">
        </div>
    </div>
    <div class="row">
        <div class="pin-photo-div">
            <div class="pin-photo">
                {{images}}
            </div>
            <div class="pin-desc-div">
                <div class="pin-desc-rating">{{rating}}</div>
                <div class="pin-desc-visit">{{checkins}}</div>
                <div class="pin-desc-address">
                    {{address}}
                </div>
            </div>
        </div>
    </div>
    <div class="row comment-div-{{idx}}">
        <ul>
            <li>
                <div class="pin-comment-div">
                    {{tip}}
                </div>                                            
            </li>
            
        </ul>
    </div>
    <div class="row youtubelist" id="youtube-div-{{pinid}}">
    </div>
    <div class="four-pin-devide"></div>
</li>
</script>



<script type="text/x-template" id="fourPinListTplForIndexGuest">
<li class="four-list-{{idx}}" data-sort="{{idx}}">
    <div class="row">
        <div class="pin-number">{{idx}}</div>
        <div class="pin-title-div">
            <div class="pin-title"><a href="{{link}}" target="_blank">{{title}}</a></div>
            <div class="pin-category">{{category}}</div>
        </div>
        <div class="pin-load">
            <!--<button type="button" class="btn btn-default" id="btnPinLoad">Load Pin</button>-->
            <!--<input type="checkbox" class="pin-check" name="fourUse[]" value="{{idx}}" checked="true">-->
        </div>
    </div>
    <div class="row">
        <div class="pin-photo-div">
            <div class="pin-photo">
                {{images}}
            </div>
            <div class="pin-desc-div">
                <div class="pin-desc-rating">{{rating}}</div>
                <div class="pin-desc-visit">{{checkins}}</div>
                <div class="pin-desc-address">
                    {{address}}
                </div>
            </div>
        </div>
    </div>
    <div class="row comment-div-{{idx}}">
        <ul>
            <li>
                <div class="pin-comment-div">
                    {{tip}}
                </div>                                            
            </li>
            
        </ul>
    </div>
    <div class="row youtubelist" id="youtube-div-{{pinid}}"></div>
    <div class="four-pin-devide"></div>
</li>
</script>



<script type="text/x-template" id="fourSinglePinTpl">
<div class="pin-info singlePin-{{idx}}">
    <div class="pin-row">
        <div class="pin-icon"><img src="{{icon}}">
        </div>
        <div class="pin-title-div">
            <div class="pin-title"><a href="{{link}}" target="_blank">{{title}}</a></div>
            <div class="pin-category">{{category}}</div>
            <div class="pin-rating">{{rating}}</div>
            <div class="pin-address">{{address}}</div>
        </div>
    </div>
    <div class="pin-row">
        <div class="pin-photo">
            {{img}}                                     
        </div>
    </div>
    <div class="pin-row">   
        {{comment}}
    </div>
</div>
<div id="single-youtube-{{pinid}}" class="single-youtube"></div>
<div class="pin-info-split"></div>
<input type="hidden" name="pinLat" value="{{pinLat}}">
<input type="hidden" name="pinLng" value="{{pinLng}}">
</script>


<script type="text/x-template" id="fourNativeSinglePinTpl">
<div class="pin-info singlePin-{{idx}}">
    <div class="pin-row">
        <div class="pin-number">{{idx}}</div>
        <div class="pin-title-div">
            <div class="pin-title"><a href="{{link}}" target="_blank">{{title}}</a></div>
            <div class="pin-category">{{category}}</div>
            <div class="pin-rating">{{rating}}</div>
            <div class="pin-address">{{address}}</div>
        </div>
    </div>
    <div class="pin-row">
        <div class="pin-photo">
            {{img}}                                     
        </div>
    </div>
    <div class="pin-row">   
        {{comment}}
    </div>
</div>
<div id="single-youtube-{{pinid}}" class="single-youtube"></div>
<div class="pin-info-split"></div>
<input type="hidden" name="pinLat" value="{{pinLat}}">
<input type="hidden" name="pinLng" value="{{pinLng}}">
</script>


<div class="clr"></div>
<div class="foot-desc">
    <div class="foot-desc-div">
        <div class="foot-desc-row">
            <div class="foot-desc-col">
            </div>
            <div class="foot-desc-col"></div>
            <div class="foot-desc-col"></div>
        </div>
        <div class="foot-desc-row">
            <div class="foot-desc-text">
                <img src="<?=url()?>/assets/img/onlysupport2.png"><br>
                pintalk is only available on Google Chrome.<br>
                pintalk is on beta service now. pintalk follows each api's policy.<br>
                If you are interested in this service, please contact me. mindcure@gmail.com
            </div>
        </div>
    </div>
    <div class="foot-desc-logo">
        <img src="<?=url()?>/assets/img/powered_by_google.png">
        <img src="<?=url()?>/assets/img/powered_by_foursquare.png">
        <img src="<?=url()?>/assets/img/powered_by_youtube.png">
    </div>
</div>

