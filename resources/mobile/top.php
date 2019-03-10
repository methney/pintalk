<script>

$(function(){

});

</script>


<!-- Modal Structure Bottom Sheet -->
<div id="alert-bottom-window" class="modal bottom-sheet">
    <div class="modal-content">
    <h4>Modal header</h4>
    <p>content</p>
    </div>
    <div class="modal-footer">
    <!--a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Disagree</a>
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a-->
    </div>
</div>
<!-- alert-start -->
<a id="alert-trigger" class="waves-effect waves-light btn modal-trigger displayNone" href="#alert-bottom-window">Modal</a>



<div id="floorAlert" class="modal bottom-sheet">
    <input type="hidden" id="currentSubscriber">
    <div class="modal-content">
      <h4>Someone wants to talk with you!</h4>
      <p>  
        <div class="floor_profile" style="width:50px;height:auto;"><img class="avatarBottom hand" id='floorAvatar'></div>
        <div class="floor_msg hand" id='floorMsg'></div>
      </p>
    </div>
    <div class="modal-footer">
      <button type="button" id="btnReceiveTalk" class="modal-action modal-close waves-effect waves-green btn-flat">PinTalk!</button>
    </div>
</div>
<!-- alert-start -->
<a id="floorAlert-trigger" class="waves-effect waves-light btn modal-trigger displayNone" href="#floorAlert">Modal</a>
