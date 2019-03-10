<ul id="slide-out-left" class="side-nav collapsible">
        <li>
          <div class="sidenav-header primary-color">
            <div class="nav-social">
              <i class="ion-social-facebook"></i>
              <i class="ion-social-twitter"></i>
              <i class="ion-social-tumblr"></i>
            </div>
            <div class="nav-avatar">
              <img class="circle avatar" src="<?=url()?>/assets/mobile/img/user.jpg" alt="">
              <div class="avatar-body">
                <h3>Pintalk</h3>
                <p>Talking with map!</p>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="ion-android-home"></i> Home <span class="badge lime darken-2">5</span>
          </div>
          <div class="collapsible-body">
            <ul class="collapsible">
              <li>
                <a href="index.html">Classic</a>
                <a href="index-sliced.html">Sliced</a>
                <a href="index-slider.html">Slider</a>
                <a href="index-drawer.html">Drawer</a>
                <a href="index-walkthrough.html">Walkthrough</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="ion-android-exit"></i> Layout <span class="badge lime darken-2">5</span>
          </div>
          <div class="collapsible-body">
            <ul class="collapsible">
              <li>
                <a href="material.html">Material</a>
                <a href="left-sidebar.html">Left</a>
                <a href="right-sidebar.html">Right</a>
                <a href="dual-sidebar.html">Dual</a>
                <a href="blank.html">Blank</a>
              </li>
            </ul>
          </div>  
        </li>
        <li>
          <div class="collapsible-header">
            <i class="ion-android-document"></i> Pages <span class="badge lime darken-2">12</span>
          </div>
          <div class="collapsible-body">
            <ul class="collapsible">
              <li>
                <?php if(Auth::check()){ ?>
                <a href="<?=url()?>/logout">Logout</a>
                <?php }else{ ?>
                <a href="<?=url()?>/auth/login">Login</a>
                <?php } ?>    
                <a href="<?=url()?>/indexMap">IndexMap</a>
                <a href="article.html">Article</a>
                <a href="event.html">Event</a>
                <a href="project.html">Project</a>
                <a href="player.html">Music Player</a>
                <a href="todo.html">ToDo</a>
                <a href="category.html">Category</a>
                <a href="product.html">Product</a>
                <a href="checkout.html">Checkout</a>
                <a href="search.html">Search</a>
                <a href="faq.html">Faq</a>
                <a href="coming-soon.html">Coming Soon</a>
                <a href="404.html">404</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="ion-android-apps"></i> App <span class="badge lime darken-2">11</span>
          </div>
          <div class="collapsible-body">
            <ul class="collapsible">
              <li>
                <a href="calendar.html">Calendar</a>
                <a href="profile.html">Profile</a>
                <a href="chat.html">Chat</a>
                <a href="login.html">Login</a>
                <a href="signup.html">Sign Up</a>
                <a href="lockscreen.html">Lockscreen</a>
                <a href="forgot.html">Password</a>
                <a href="notification.html">Notification</a>
                <a href="chart.html">Chart</a>
                <a href="timeline.html">Timeline</a>
                <a href="activity.html">Activity</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="ion-android-list"></i> Blog <span class="badge lime darken-2">2</span>
          </div>
          <div class="collapsible-body">
            <ul class="collapsible">
              <li>
                <a href="blog.html">Classic</a>
                <a href="blog-card.html">Card</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="ion-android-image"></i> Gallery <span class="badge lime darken-2">3</span>
          </div>
          <div class="collapsible-body">
            <ul class="collapsible">
              <li>
                <a href="gallery-filter.html">Filter</a>
                <a href="gallery-masonry.html">Masonry</a>
                <a href="gallery-card.html">Card</a>
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header">
            <i class="ion-android-camera"></i> Portfolio <span class="badge lime darken-2">3</span>
          </div>
          <div class="collapsible-body">
            <ul class="collapsible">
              <li>
                <a href="portfolio-filter.html">Filter</a>
                <a href="portfolio-masonry.html">Masonry</a>
                <a href="portfolio-card.html">Card</a>
              </li>
            </ul>
          </div>
        </li>
        <li><a href="shop.html" class="no-child"><i class="ion-android-playstore"></i> Shop</a></li>
        <li><a href="video.html" class="no-child"><i class="ion-ios-videocam"></i> Video</a></li>
        <li><a href="news.html" class="no-child"><i class="ion-social-rss"></i> News</a></li>
        <li><a href="contact.html" class="no-child"><i class="ion-android-map"></i> Contact</a></li>
      </ul>
