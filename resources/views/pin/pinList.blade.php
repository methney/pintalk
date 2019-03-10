<!DOCTYPE html>
@include('head')
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotter - Universal Directory Listing HTML Template</title>

</head>

<body onunload="" class="page-subpage page-listing-list navigation-off-canvas" id="page-top">

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
                <section class="container">
                    <div class="row">
                        <!--Content-->
                        <div class="col-md-9">
                            <header>
                                <h1 class="page-title">Listing</h1>
                            </header>
                            <figure class="filter clearfix">
                                <div class="buttons pull-left">
                                    <a href="<?=url()?>/pinGridList" class="btn icon"><i class="fa fa-th"></i>Grid</a>
                                    <a href="<?=url()?>/pinList" class="btn icon active"><i class="fa fa-th-list"></i>List</a>
                                </div>
                                <div class="pull-right">
                                    <aside class="sorting">
                                        <span>Sorting</span>
                                        <div class="form-group">
                                            <select class="framed" name="sort">
                                                <option value="">Date - Newest First</option>
                                                <option value="1">Date - Oldest First</option>
                                                <option value="2">Price - Highest First</option>
                                                <option value="3">Price - Lowest First</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </aside>
                                </div>
                            </figure>

                            <!--Listing List-->
                            <section class="block listing">
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span title="Bedrooms"><img src="<?=url()?>/assets/img/bedrooms.png" alt="">2</span>
                                                <span title="Bathrooms"><img src="<?=url()?>/assets/img/bathrooms.png" alt="">2</span>
                                                <span title="Area"><img src="<?=url()?>/assets/img/area.png" alt="">240m<sup>2</sup></span>
                                                <span title="Garages"><img src="<?=url()?>/assets/img/garages.png" alt="">1</span>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-thumbs-up"></i>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Cash Cow Restaurante</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                <span>Restaurant</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/2.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Benny’s Cafeteria</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/cafetaria.png" alt=""></i>
                                                <span>Cafeteria</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span>Daily menu from: $6</span>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/9.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Big Bamboo</h3></a>
                                        <figure>4662 Bruce Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/japanese-food.png" alt=""></i>
                                                <span>Sushi</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span>Daily menu from: $6</span>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/10.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Sushi Wooshi Bar</h3></a>
                                        <figure>357 Trainer Avenue</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/fishchips.png" alt=""></i>
                                                <span>Sushi Bar</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/11.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Max Five Lounge</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                <span>Restaurant</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/4.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Magma Bar & Grill</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant_steakhouse.png" alt=""></i>
                                                <span>Steak House</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span>Menu from: $9.00</span>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/8.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Guild Trattoria</h3></a>
                                        <figure>4662 Bruce Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/barbecue.png" alt=""></i>
                                                <span>BBQ Restaurant</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/12.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Sushi Wooshi Bar</h3></a>
                                        <figure>357 Trainer Avenue</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/fishchips.png" alt=""></i>
                                                <span>Sushi Bar</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/4.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Max Five Lounge</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                <span>Restaurant</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/6.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Magma Bar & Grill</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant_steakhouse.png" alt=""></i>
                                                <span>Steak House</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span>Menu from: $9.00</span>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/7.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Guild Trattoria</h3></a>
                                        <figure>4662 Bruce Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/barbecue.png" alt=""></i>
                                                <span>BBQ Restaurant</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/5.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Sushi Wooshi Bar</h3></a>
                                        <figure>357 Trainer Avenue</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/fishchips.png" alt=""></i>
                                                <span>Sushi Bar</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span title="Bedrooms"><img src="<?=url()?>/assets/img/bedrooms.png" alt="">2</span>
                                                <span title="Bathrooms"><img src="<?=url()?>/assets/img/bathrooms.png" alt="">2</span>
                                                <span title="Area"><img src="<?=url()?>/assets/img/area.png" alt="">240m<sup>2</sup></span>
                                                <span title="Garages"><img src="<?=url()?>/assets/img/garages.png" alt="">1</span>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-thumbs-up"></i>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Steak House Restaurant</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                <span>Restaurant</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/2.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Benny’s Cafeteria</h3></a>
                                        <figure>63 Birch Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/cafetaria.png" alt=""></i>
                                                <span>Cafeteria</span>
                                            </div>
                                            <div class="rating" data-rating="4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span>Daily menu from: $6</span>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/9.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Big Bamboo</h3></a>
                                        <figure>4662 Bruce Street</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/japanese-food.png" alt=""></i>
                                                <span>Sushi</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                                <div class="item list">
                                    <div class="image">
                                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                                        <a href="item-detail.html">
                                            <div class="overlay">
                                                <div class="inner">
                                                    <div class="content">
                                                        <h4>Description</h4>
                                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-specific">
                                                <span>Daily menu from: $6</span>
                                            </div>
                                            <img src="<?=url()?>/assets/img/items/restaurant/10.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="wrapper">
                                        <a href="item-detail.html"><h3>Sushi Wooshi Bar</h3></a>
                                        <figure>357 Trainer Avenue</figure>
                                        <div class="info">
                                            <div class="type">
                                                <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/fishchips.png" alt=""></i>
                                                <span>Sushi Bar</span>
                                            </div>
                                            <div class="rating" data-rating="3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.item-->
                            </section>
                            <!--end Listing List-->
                            <!--Pagination-->
                            <nav>
                                <ul class="pagination pull-right">
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#" class="previous"><i class="fa fa-angle-left"></i></a></li>
                                    <li><a href="#" class="next"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            </nav>
                            <!--end Pagination-->
                        </div>
                        <!--Sidebar-->
                        <div class="col-md-3">
                            <aside id="sidebar">
                                <section>
                                    <header><h2>New Places</h2></header>
                                    <a href="item-detail.html" class="item-horizontal small">
                                        <h3>Cash Cow Restaurante</h3>
                                        <figure>63 Birch Street</figure>
                                        <div class="wrapper">
                                            <div class="image"><img src="<?=url()?>/assets/img/items/1.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
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
                                            <div class="image"><img src="<?=url()?>/assets/img/items/2.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
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
                                            <div class="image"><img src="<?=url()?>/assets/img/items/3.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="<?=url()?>/assets/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                    <span>Restaurant</span>
                                                </div>
                                                <div class="rating" data-rating="5"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <!--/.item-horizontal small-->
                                </section>
                                <section>
                                    <a href="#"><img src="<?=url()?>/assets/img/ad-banner-sidebar.png" alt=""></a>
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
                    </div>
                </section>
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


<script type="text/javascript" src="<?=url()?>/assets/js/before.load.js"></script>
<script type="text/javascript" src="<?=url()?>/assets/js/custom.js"></script>


<!--[if lte IE 9]>
<script type="text/javascript" src="<?=url()?>/assets/js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>