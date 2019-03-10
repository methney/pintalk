<!DOCTYPE html>
<html lang="en-US">
<?php
    include 'head.php';

    // url로 직접 초대
    $pin = isset($pin_id)?$pin_id:'';
    $lat = isset($lat)?$lat:'';
    $lng = isset($lng)?$lng:'';

    // 등록 후
    $key = isset($key)?$key:'';
?>
<body>
  <!-- <link rel="stylesheet" href="<?=url()?>/assets/mobile/css/app.css"> -->
  <script>

  $(function(){
    'use strict';

    $(".slider-input-field input").on('click touch',function(){
        swiperSlide.stopAutoplay();
    });

  });


  </script>
  
  
  
  <div class="m-scene" id="main"> <!-- Main Container -->

      <!-- Sidebars -->
      <!-- Right Sidebar -->
      <?php include 'right.php'; ?>
      <!-- Left Sidebar -->
      <?php include 'left.php'; ?>
      <!-- End of Sidebars -->

      <!-- Page Content -->
      <div id="content">

        <!-- Toolbar -->
        <div id="toolbar" class="halo-nav box-shad-none">
          <div class="open-left" id="open-left" data-activates="slide-out-left">
            <i class="ion-android-menu"></i>
          </div>
          <!-- <span class="title">PINTALK</span> -->
          <div class="open-right" id="open-right" data-activates="slide-out">
            <i class="ion-android-person"></i>
          </div>
        </div>
        
        <!-- Main Content -->
        <div class="animated fadeinup fullscreen">
          
          <!-- Slider -->         
          <div class="swiper-container slider slider-fullscreen">
            <!-- Search bar -->
            <div class="slider-search-div">
              
              <div class="slider-search-nav slider-search-card">
                <div class="slider-nav-wrapper">
                  <form>
                    <div class="slider-input-fields input-fields" id="app">
                      <!-- <input class="input-search" id="search" type="search" placeholder="WHERE TO GO?" required="">
                      <i class="ion-android-close"></i> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- contents -->
            <div class="swiper-wrapper"></div>
            <!-- Add Pagination -->
            <div class="swiper-pagination white-bullet"></div>
          <!-- End of Slider -->
          </div>
        </div> <!-- End of Main Contents -->
      
       
      </div> <!-- End of Page Content -->

    </div> <!-- End of Page Container -->
<script src="<?=url()?>/assets/mobile/js/index.min.js"></script>
<?php include 'bottom.php'; ?>

  </body>
</html>