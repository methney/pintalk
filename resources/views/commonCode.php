<!DOCTYPE html>

<?php
    include 'head.php';
?>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--
    <link href="assets/fonts/font-awesome.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/user.style.css" type="text/css">
    -->
    <title>Spotter - Universal Directory Listing HTML Template</title>

</head>

<script>
var $ = jQuery.noConflict();
var navigationStyle;

$( document ).ready(function() {

    // call code list
    var callCdList = function(connectCd){
        $.ajax({
            type: "GET",
            url: base_url+'/callCdList',
            data: {'connectCd':connectCd},
            success: function( data ) {
                $("#cdList").empty();
                $.each(data,function(i,d){
                    var $obj = $('<tr>');
                    var content = 
                        '<td><label class="checkbox-inline"><input type="checkbox" name="chk_cd" value="'+d.connect_cd+'"></label></td>' + 
                        '<td>'+d.level+'</td>' +
                        '<td style="cursor:pointer">'+d.cd+'</td>' +  
                        '<td>'+d.cd_nm+'</td>' + 
                        '<td>'+isNull(d.grp_cd,'')+'</td>' + 
                        '<td>'+d.etc+'</td>';
                     
                    $obj.append(content);
                    cdRowClickEvent($obj, d.connect_cd);
                    $("#cdList").append($obj);
                });
            }
        });
    };

    // row click event
    var cdRowClickEvent = function($obj, connectCd){
        $('td:eq(1)', $obj).on('click',function(e){
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: base_url+'/callSingleCd',
                data: {'connectCd' : connectCd },
                success: function( data ) {
                    //console.log('data',data[0].cd);
                    $("#connectCd").val(data[0].connect_cd);
                    $("#cd").val(data[0].cd);
                    $("#cdNm").val(data[0].cd_nm);
                    $("#etc").val(data[0].etc);
                    $("#level").val(data[0].level);
                    $("#level").selectpicker('refresh');
                    $("#level").attr("disabled", true);
                    $("#cdGrp").val(data[0].grp_cd);
                    $("#cdGrp").selectpicker('refresh');
                    $("#cdGrp").attr("disabled", true);
                    $("#btnSubmit").text("Modify Code");
                    $("#type").val("update");
                    $("#cd").attr("readonly","readonly");
                }
            });                 
        });
    };


    // call group code
    $.fn.callGrpCd = function(param, callback){
        var self = this;
        $.ajax({
            type: "GET",
            url: base_url+'/callGrpCd',
            data: param,
            success: function( data ) {
                self.html("<option value=''>Select!</option>");
                $.each(data,function(i,d){
                    self.append($('<option>', { value : d.connect_cd, text : d.cd_nm }));
                });
                self.selectpicker('refresh');
                
                if(typeof(callback)=='function'){
                    callback();
                }
            }
        });
    };

    // execute!
    $("#search_cdGrp").callGrpCd({'level':'1'},function(){
        $($('#search_cdGrp option:first')).trigger('change');
    });


    $("#search_cdGrp").on('change',function(){
        initialCodeFrm($(this).val());
    })

    
    $("#cdFrm").ajaxForm({
        success: function( data ){
            alert('Complete!');
            //initialCodeFrm();
            $($('#search_cdGrp option:first')).trigger('change');
        }, 
        error: function(){
            console.log('something wrong!');
        }
    });

    // delete code on the list
    $("#btnSubmitDelete").on('click',function(){

        if(!confirm('Are you sure?')){
            return false;
        }

        var chk_cd = [];
        $("input[name='chk_cd']:checked").each(function(i,d){
            chk_cd.push($(d).val());
        });

        
        $.ajax({
            type: "GET",
            url: base_url+'/deleteCd',
            data: {'connectCds' : JSON.stringify(chk_cd)}, 
            success: function( data ) {
                //initialCodeFrm();
                $($('#search_cdGrp option:first')).trigger('change');
            }
        });


    });


    function initialCodeFrm(connectCd){
        callCdList(connectCd);
        $("#cdGrp").callGrpCd();
        $("#connectCd").val("");
        $("#cd").val("");
        $("#cdNm").val("");
        $("#etc").val("");
        $("#level").val("");
        $("#level").attr("disabled", false);
        $("#level").selectpicker('refresh');
        $("#cdGrp").val("");
        $("#cdGrp").attr("disabled", false);
        $("#cdGrp").selectpicker('refresh');
        $("#btnSubmit").text("Create Code");
        $("#type").val("insert");
        $("#cd").removeAttr("readonly");

    };

    // $("#btnSubmit").click(function(){
    //     $("#cdFrm").attr("action", "saveCode");
    //     $("#cdFrm").submit();
    // });
});





</script>


<body onunload="" class="page-subpage page-register navigation-top-header" id="page-top">

<!-- Outer Wrapper-->
<div id="outer-wrapper">
    <!-- Inner Wrapper -->
    <div id="inner-wrapper">
        <!-- Navigation-->
        <?php include 'top.php'; ?>
        <!-- end Navigation-->
        <!-- Page Canvas-->
        <div id="page-canvas">
            <!--Off Canvas Navigation-->
            <nav class="off-canvas-navigation">
                <header>Navigation</header>
                <div class="main-navigation navigation-off-canvas"></div>
            </nav>
            <!--end Off Canvas Navigation-->

            <!--Sub Header-->
            <section class="sub-header">
                <div class="search-bar horizontal collapse" id="redefine-search-form"></div>
                <!-- /.search-bar -->
                <div class="breadcrumb-wrapper">
                    <div class="container">
                        <div class="redefine-search">
                            <a href="#redefine-search-form" class="inner" data-toggle="collapse" aria-expanded="false" aria-controls="redefine-search-form">
                                <span class="icon"></span>
                                <span>Redefine Search</span>
                            </a>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="<?=url()?>"><i class="fa fa-home"></i></a></li>
                            <li><a href="#">CommonCode</a></li>
                            <li class="active">Detail</li>
                        </ol>
                        <!-- /.breadcrumb-->
                    </div>
                    <!-- /.container-->
                </div>
                <!-- /.breadcrumb-wrapper-->
            </section>
            <!--end Sub Header-->


            <!--Page Content-->
            <div id="page-content">
               <div class="container">
                <h2>Common Code</h2>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="search_cdGrp">1 Level Search</label>
                        <div class="form-group">
                            <select id="search_cdGrp" class="form-control">
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Level</th>
                        <th>Code</th>
                        <th>Code Name</th>
                        <th>Group Code</th>
                        <th>Etc</th>
                        
                    </tr>
                    </thead>
                    <tbody id="cdList">
                    </tbody>
                </table>
                <div class="row">
                    <button type="button" class="btn btn-default icon" id="btnSubmitDelete">Delete Code<i class="fa fa-angle-right"></i></button>
                </div>
                </div> 

                <section class="container">
                    <header class="no-border"><h3>CODE Register/Modification Form</h3></header>
                    <form id="cdFrm" role="form" method="post" action="saveCode" class="background-color-white">
                        <input type="hidden" id="type" name="type" value="insert">
                        <div class="row">
                            <div class="col-md-9 col-sm-9">
                                <div class="form-group">
                                    <label for="cd">CODE</label>
                                    <input type="text" class="form-control" id="cd" name="cd" required="">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-sm-9">
                                <div class="form-group">
                                    <label for="cdNm">CODE NAME</label>
                                    <input type="text" class="form-control" id="cdNm" name="cdNm" required="">
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="cdGrp">Code Group:</label>
                                    <select name="cdGrp" id="cdGrp" class="form-control"><option value=''>Select!</option></select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-sm-9">
                                <div class="form-group">
                                    <label for="etc">etc</label>
                                    <input type="text" class="form-control" id="etc" name="etc" >
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="level">level</label>
                                    <select id="level" name="level" class="form-control">
                                        <option value=''>Select!</option>
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                        <option value='3'>3</option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default icon" id="btnSubmit">Create Code<i class="fa fa-angle-right"></i></button>
                            <button type="submit" class="btn btn-default icon" id="btnSubmitModify" style="display:none;">Modify Code<i class="fa fa-angle-right"></i></button>
                        </div>
                        <!-- /.form-group -->
                    </form>
                    <!--/#contact-form-->
                </section>
                

            </div>
            <!-- end Page Content-->
        </div>
        <!-- end Page Canvas-->
        <!--Page Footer-->
        <?php include 'bottom.php'; ?>
        <!--end Page Footer-->
    </div>
    <!-- end Inner Wrapper -->
</div>
<!-- end Outer Wrapper-->

<script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/icheck.min.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/custom.js"></script>

<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>