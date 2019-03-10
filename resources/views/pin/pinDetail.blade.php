<!DOCTYPE html>
@include('head')
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotter - Universal Directory Listing HTML Template</title>
</head>

<body onunload="" class="page-subpage page-item-detail navigation-off-canvas" id="page-top">

<!-- Outer Wrapper-->
<div id="outer-wrapper">
    <!-- Inner Wrapper -->
    <div id="inner-wrapper">
        <!-- Navigation-->
        @include('top')
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
                            <li><a href="index-directory.html"><i class="fa fa-home"></i></a></li>
                            <li><a href="#">Page</a></li>
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

                <div id="map-detail"></div>
                <section class="container">
                    <div class="row">
                        <!--Item Detail Content-->
                        <div class="col-md-9">
                            <section class="block" id="main-content">
                                <header class="page-title">
                                    <div class="title">
                                        <h1>{{$result->title}}</h1>
                                        <figure>{{$result->address}}</figure>
                                    </div>
                                    <div class="info">
                                        <div class="type">
                                            <i><img src="assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                            <span>{{$result->category}}</span>
                                        </div>
                                    </div>
                                </header>
                                <div class="row">
                                    <aside class="col-md-4 col-sm-4" id="detail-sidebar">
                                        <!--section>
                                            <header><h3>Contact</h3></header>
                                            <address>
                                                <div>Max Five Lounge</div>
                                                <div>63 Birch Street</div>
                                                <div>Granada Hills, CA 91344</div>
                                                <figure>
                                                    <div class="info">
                                                        <i class="fa fa-mobile"></i>
                                                        <span>818-832-5258</span>
                                                    </div>
                                                    <div class="info">
                                                        <i class="fa fa-phone"></i>
                                                        <span>+1 123 456 789</span>
                                                    </div>
                                                    <div class="info">
                                                        <i class="fa fa-globe"></i>
                                                        <a href="#">www.maxfivelounge.com</a>
                                                    </div>
                                                </figure>
                                            </address>
                                        </section-->
                                        <!--Rating-->
                                        <section class="clearfix">
                                            <header class="pull-left"><a href="#reviews" class="roll"><h3>Rating</h3></a></header>
                                            <figure class="rating big pull-right" data-rating="{{$result->score_host}}"></figure>
                                        </section>
                                        <!--end Rating-->
                                        <!--section>
                                            <header><h3>Events</h3></header>
                                            <figure>
                                                <div class="expandable-content collapsed show-60" id="detail-sidebar-event">
                                                    <div class="content">
                                                        <p>Maecenas purus sapien, pellentesque non consectetur eu, rhoncus in mauris.
                                                            Duis et nisl metus. Sed ut pulvinar mauris, bibendum ullamcorper ex.
                                                            Aliquam vitae ante diam. Nam eu blandit odio. Cras erat lorem, iaculis eu nulla eu, sodales aliquam eros.
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="#" class="show-more expand-content" data-expand="#detail-sidebar-event" >Show More</a>
                                            </figure>
                                        </section-->
                                        <!--section>
                                            <header><h3>Contact Form</h3></header>
                                            <figure>
                                                <form id="item-detail-form" role="form" method="post" action="?">
                                                    <div class="form-group">
                                                        <label for="item-detail-name">Name</label>
                                                        <input type="text" class="form-control framed" id="item-detail-name" name="item-detail-name" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item-detail-email">Email</label>
                                                        <input type="email" class="form-control framed" id="item-detail-email" name="item-detail-email" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item-detail-message">Message</label>
                                                        <textarea class="form-control framed" id="item-detail-message" name="item-detail-message"  rows="3" required=""></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn framed icon">Send<i class="fa fa-angle-right"></i></button>
                                                    </div>
                                                </form>
                                            </figure>
                                        </section-->
                                        <!--end Contact Form-->
                                    </aside>
                                    <!--end Detail Sidebar-->
                                    <!--Content-->
                                    <div class="col-md-8 col-sm-8">
                                        <section>
                                            <article class="item-gallery">
                                                <div class="owl-carousel item-slider">
                                                    @foreach($files as $key=>$file)
                                                    <div class="slide"><img src="<?=Config::get('custom.fileDir')?>/{{$file->file_nm}}" data-hash="{{$key+1}}" alt=""></div>
                                                    @endforeach
                                                </div>
                                                <!-- /.item-slider -->
                                                <div class="thumbnails">
                                                    <span class="expand-content btn framed icon" data-expand="#gallery-thumbnails" >More<i class="fa fa-plus"></i></span>
                                                    <div class="expandable-content height collapsed show-70" id="gallery-thumbnails">
                                                        <div class="content">
                                                            @foreach($files as $key=>$file)
                                                            <a href="#{{$key+1}}" id="thumbnail-{{$key+1}}" class="active"><img src="<?=Config::get('custom.fileDir')?>/{{$file->file_nm}}" alt=""></a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- /.item-gallery -->
                                            <article class="block">
                                                <header><h2>Description</h2></header>
                                                <p>
                                                    {{strip_tags($result->content)}}
                                                </p>
                                            </article>
                                            <!-- /.block -->
                                            <!--article class="block">
                                                <header><h2>Daily Menu</h2></header>
                                                <div class="list-slider owl-carousel">
                                                    <div class="slide">
                                                        <header>
                                                            <h3><i class="fa fa-calendar"></i>Monday (today)</h3>
                                                        </header>
                                                        <div class="list-item">
                                                            <div class="left">
                                                                <h4>Chicken wings</h4>
                                                                <figure>Curabitur odio nibh, luctus non pulvinar</figure>
                                                            </div>
                                                            <div class="right">$4.50</div>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="left">
                                                                <h4>Mushroom ragout</h4>
                                                                <figure>Donec a odio rutrum, hendrerit sapien</figure>
                                                            </div>
                                                            <div class="right">$3.60</div>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="left">
                                                                <h4>Nice salad with tuna, beans and hard-boiled egg</h4>
                                                                <figure>Urabitur suscipit, justo eu dignissim lacinia </figure>
                                                            </div>
                                                            <div class="right">$1.20</div>
                                                        </div>
                                                    </div>
                                                    <div class="slide">
                                                        <header>
                                                            <h3><i class="fa fa-calendar"></i>Tuesday</h3>
                                                        </header>
                                                        <div class="list-item">
                                                            <div class="left">
                                                                <h4>Chicken wings</h4>
                                                                <figure>Curabitur odio nibh, luctus non pulvinar</figure>
                                                            </div>
                                                            <div class="right">$4.50</div>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="left">
                                                                <h4>Mushroom ragout</h4>
                                                                <figure>Donec a odio rutrum, hendrerit sapien</figure>
                                                            </div>
                                                            <div class="right">$3.60</div>
                                                        </div>
                                                        <div class="list-item">
                                                            <div class="left">
                                                                <h4>Nice salad with tuna, beans and hard-boiled egg</h4>
                                                                <figure>Urabitur suscipit, justo eu dignissim lacinia </figure>
                                                            </div>
                                                            <div class="right">$1.20</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article-->
                                            <!-- /.block -->
                                            <article class="block">
                                                <header><h2>Features</h2></header>
                                                <ul class="bullets hash_tags">
                                                </ul>
                                            </article>
                                            <!-- /.block -->
                                            <!--article class="block">
                                                <header><h2>Opening Hours</h2></header>
                                                <dl class="lines">
                                                    <dt>Monday</dt>
                                                    <dd>08:00 am - 11:00 pm</dd>
                                                    <dt>Tuesday</dt>
                                                    <dd>08:00 am - 11:00 pm</dd>
                                                    <dt>Wednesday</dt>
                                                    <dd>08:00 am - 11:00 pm</dd>
                                                    <dt>Thursday</dt>
                                                    <dd>08:00 am - 11:00 pm</dd>
                                                    <dt>Friday</dt>
                                                    <dd>08:00 am - 11:00 pm</dd>
                                                    <dt>Saturday</dt>
                                                    <dd>08:00 am - 11:00 pm</dd>
                                                </dl>
                                            </article-->
                                            <!-- /.block -->
                                        </section>
                                        <!--Reviews-->
                                        <!--section class="block" id="reviews">
                                            <header class="clearfix">
                                                <h2 class="pull-left">Reviews</h2>
                                                <a href="#write-review" class="btn framed icon pull-right roll">Write a review <i class="fa fa-pencil"></i></a>
                                            </header>
                                            <article class="clearfix overall-rating">
                                                <strong class="pull-left">Over Rating</strong>
                                                <figure class="rating big color pull-right" data-rating="4"></figure>
                                            </article>
                                            <section class="reviews">
                                                <article class="review">
                                                    <figure class="author">
                                                        <img src="assets/img/default-avatar.png" alt="">
                                                        <div class="date">12.05.2014</div>
                                                    </figure>
                                                    <div class="wrapper">
                                                        <h5>Catherine Brown</h5>
                                                        <figure class="rating big color" data-rating="4"></figure>
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                            Nulla vestibulum, sem ut sollicitudin consectetur, augue diam ornare massa,
                                                            ac vehicula leo turpis eget purus. Nunc pellentesque vestibulum mauris,
                                                            eget suscipit mauris imperdiet vel. Nulla et massa metus.
                                                        </p>
                                                        <div class="individual-rating">
                                                            <span>Value</span>
                                                            <figure class="rating" data-rating="4"></figure>
                                                        </div>
                                                        <div class="individual-rating">
                                                            <span>Service</span>
                                                            <figure class="rating" data-rating="4"></figure>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="review">
                                                    <figure class="author">
                                                        <img src="assets/img/default-avatar.png" alt="">
                                                        <div class="date">10.05.2014</div>
                                                    </figure>
                                                    <div class="wrapper">
                                                        <h5>John Doe</h5>
                                                        <figure class="rating big color" data-rating="5"></figure>
                                                        <p>
                                                            Nunc pellentesque vestibulum mauris, eget suscipit mauris
                                                            imperdiet vel. Nulla et massa metus. Nam porttitor quam eget ante
                                                        </p>
                                                        <div class="individual-rating">
                                                            <span>Value</span>
                                                            <figure class="rating" data-rating="5"></figure>
                                                        </div>
                                                        <div class="individual-rating">
                                                            <span>Service</span>
                                                            <figure class="rating" data-rating="5"></figure>
                                                        </div>
                                                    </div>
                                                </article>
                                            </section>
                                        </section>
                                        <section id="write-review">
                                            <header>
                                                <h2>Write a Review</h2>
                                            </header>
                                            <form id="form-review" role="form" method="post" action="?" class="background-color-white">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="form-review-name">Name</label>
                                                            <input type="text" class="form-control" id="form-review-name" name="form-review-name" required="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="form-review-email">Email</label>
                                                            <input type="email" class="form-control" id="form-review-email" name="form-review-email" required="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="form-review-message">Message</label>
                                                            <textarea class="form-control" id="form-review-message" name="form-review-message"  rows="3" required=""></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-default">Submit Review</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <aside class="user-rating">
                                                            <label>Value</label>
                                                            <figure class="rating active" data-name="value"></figure>
                                                        </aside>
                                                        <aside class="user-rating">
                                                            <label>Service</label>
                                                            <figure class="rating active" data-name="score"></figure>
                                                        </aside>
                                                    </div>
                                                </div>
                                            </form>
                                        </section-->
                                        <!--end Review Form-->
                                    </div>
                                    <!-- /.col-md-8-->
                                </div>
                                <!-- /.row -->
                            </section>
                            <!-- /#main-content-->
                        </div>
                        <!-- /.col-md-8-->
                        <!--Sidebar-->
                        <div class="col-md-3">
                            <aside id="sidebar">
                                <section>
                                    <header><h2>New Places</h2></header>
                                    <a href="item-detail.html" class="item-horizontal small">
                                        <h3>Cash Cow Restaurante</h3>
                                        <figure>63 Birch Street</figure>
                                        <div class="wrapper">
                                            <div class="image"><img src="assets/img/items/1.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                    <span>Restaurant</span>
                                                </div>
                                                <div class="rating" data-rating="4"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <!--/.item-horizontal small-->
                                    <a href="item-detail.html" class="item-horizontal small">
                                        <h3>Blue Chilli</h3>
                                        <figure>2476 Whispering Pines Circle</figure>
                                        <div class="wrapper">
                                            <div class="image"><img src="assets/img/items/2.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                    <span>Restaurant</span>
                                                </div>
                                                <div class="rating" data-rating="3"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <!--/.item-horizontal small-->
                                    <a href="item-detail.html" class="item-horizontal small">
                                        <h3>Eddie’s Fast Food</h3>
                                        <figure>4365 Bruce Street</figure>
                                        <div class="wrapper">
                                            <div class="image"><img src="assets/img/items/3.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                    <span>Restaurant</span>
                                                </div>
                                                <div class="rating" data-rating="5"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <!--/.item-horizontal small-->
                                </section>
                                <section>
                                    <a href="#"><img src="assets/img/ad-banner-sidebar.png" alt=""></a>
                                </section>
                                <section>
                                    <header><h2>Categories</h2></header>
                                    <ul class="bullets">
                                        <li><a href="#" >Restaurant</a></li>
                                        <li><a href="#" >Steak House & Grill</a></li>
                                        <li><a href="#" >Fast Food</a></li>
                                        <li><a href="#" >Breakfast</a></li>
                                        <li><a href="#" >Winery</a></li>
                                        <li><a href="#" >Bar & Lounge</a></li>
                                        <li><a href="#" >Pub</a></li>
                                    </ul>
                                </section>
                                <section>
                                    <header><h2>Events</h2></header>
                                    <div class="form-group">
                                        <select class="framed" name="events">
                                            <option value="">Select Your City</option>
                                            <option value="1">London</option>
                                            <option value="2">New York</option>
                                            <option value="3">Barcelona</option>
                                            <option value="4">Moscow</option>
                                            <option value="5">Tokyo</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </section>
                            </aside>
                            <!-- /#sidebar-->
                        </div>
                        <!-- /.col-md-3-->
                        <!--end Sidebar-->
                    </div><!-- /.row-->
                </section>
                <!-- /.container-->
            </div>
            <!-- end Page Content-->
        </div>
        <!-- end Page Canvas-->
        <!--Page Footer-->
        @include('bottom')
        <!--end Page Footer-->
    </div>
    <!-- end Inner Wrapper -->
</div>
<!-- end Outer Wrapper-->


<script type="text/javascript" src="assets/js/before.load.js"></script>
<script type="text/javascript" src="assets/js/richmarker-compiled.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="assets/js/maps.js"></script>

<script>

    $(window).load(function(){

        var json = {};
        json.latitude = "{{$result->lat}}";
        json.longitude = "{{$result->lng}}";
        json.type_icon = base_url+'/assets/icons/media/downloadicon.png';

        itemDetailMap(json);
        var rtl = false; // Use RTL
        initializeOwl(rtl);

        var hash_tags = "{{$result->hash_tag}}";
        var hashs = isNullChk(hash_tags)?'':hash_tags.split("#");
        var hash = '';
        $.each(hashs,function(i,single){
            if(i!=0){
                hash += "<li>" + single + "</li>";
            }
        });
        $(".hash_tags").html(hash);



    });
</script>

<!--[if lte IE 9]>
<script type="text/javascript" src="assets/js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>