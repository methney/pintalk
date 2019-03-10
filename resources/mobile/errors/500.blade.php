<style>

div.tab {
    /*overflow: hidden;*/
    border-bottom: 1px solid #ddd;
    /*background-color: #f1f1f1;*/
    height:53px;
    margin-bottom:20px;
    margin-top:10px;
}

div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    font-family:'Dosis'; 
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #f1f1f1;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ddd;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 0px;
    /*border: 1px solid #ccc;*/
    border-top: none;
}

.scroll-element.scroll-x {
    display: none !important;
}

.item-detail-close img {
    cursor:pointer;
}

.search-content .search-input{
    height:100px;
}

.search-content .reason{
    margin-top:20px;
    font-size: 45px;
    font-family:'Dosis'; 
    padding-top:20px;
}

</style>

<html lang="en-US"> 
<head>
    <!--<meta charset="UTF-8"/>-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<link rel="stylesheet" href="<?=url()?>/assets/css/style.css" type="text/css">

<body onunload="" class="map-fullscreen page-homepage navigation-off-canvas" id="page-top">

<div class="wrap-search-idx">
    <div class="search-exp">
        <div class="left">
            <span class="txt">SOMETHING WRONG HAPPENED</span>
            <!--<span class="exp">EXCERCISE LANGUAGES YOU'VE LEARNED!</span>-->
        </div>
    </div>
    <div class="clr"></div>
    <div class="search-content">
        <div class="search-input">
            <a href="/"><img src="<?=url()?>/assets/img/talkingPin.png"></a>
            <div class="reason">SOMETHING WRONG ERROR CODE 500</div>
        </div>
    </div>
</div>    


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
                <!--pintalk is only available on Google Chrome.<br>
                pintalk is on beta service now. pintalk follows each api's policy.<br>
                If you are interested in this service, please contact me. mindcure@gmail.com-->
            </div>
        </div>
    </div>
    <div class="foot-desc-logo">
        <!--<img src="<?=url()?>/assets/img/powered_by_foursquare.png">
        <img src="<?=url()?>/assets/img/powered_by_google.png">-->
    </div>
</div>

</body>
</html>