<!DOCTYPE html>
<html>
  <head>
    <title>react-places-autocomplete Demo</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" integrity="sha256-t2/7smZfgrST4FS1DT0bs/KotCM74XlcqZN5Vu7xlrw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=url()?>/assets/mobile/css/app.css">
    <script src="<?=url()?>/assets/mobile/js/jquery-2.1.0.min.js"></script>
    <style>
      #app {
        margin-top:3px;
      }
    </style>
  </head>
  <script>
    $(function(){
      setTimeout(function(){
        disableInput();
      },0)
    });

    function disableInput(){
      $("#my-input-id").attr("disabled","disabled");
    }

    function ableInput(){
      $("#my-input-id").removeAttr("disabled");
    }
  </script>


  <body>
    <div id="app" />
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoq4_-BeKtYRIs-3FjJL721G1eP5DaU0g&libraries=places"></script>
    <script src="<?=url()?>/assets/mobile/js/index.min.js"></script>
  </body>
</html>
