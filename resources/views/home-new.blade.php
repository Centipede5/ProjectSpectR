@extends('layouts.master')

@section('page-title')Home @endsection

@section('main-content')
    <!-- main -->
    <section class="p-y-5">
        <div class="owl-carousel owl-posts">
            <div class="post-carousel">
                <a href="blog-post.html"><img src="https://img.youtube.com/vi/82Xd-lHmtzk/maxresdefault.jpg" alt=""></a>
                <span class="badge badge-ps4">ps4</span>
                <div class="post-block">
                    <div class="post-caption">
                        <h2 class="post-title">
                            <a href="blog-post.html">World of Tanks Campaign Hands-On: It's Got War Stories to Tell</a>
                        </h2>
                        <div class="post-meta">
                            <span><i class="fa fa-clock-o"></i> Julye 28, 2017 by <a href="profile.html">Venom</a></span>
                            <span><a href="blog-post.html#comments"><i class="fa fa-comment-o"></i> 98 comments</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post-carousel">
                <a href="blog-post.html"><img src="https://img.youtube.com/vi/BlINFsdTKQ4/maxresdefault.jpg" alt=""></a>
                <span class="badge badge-xbox-one">xbox one</span>
                <div class="post-block">
                    <div class="post-caption">
                        <h2 class="post-title">
                            <a href="blog-post.html">Monster Hunter World Is the Best Introduction to the Series</a>
                        </h2>
                        <div class="post-meta">
                            <span><i class="fa fa-clock-o"></i> Julye 25, 2017 by <a href="profile.html">Lobo</a></span>
                            <span><a href="blog-post.html#comments"><i class="fa fa-comment-o"></i> 13 comments</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post-carousel">
                <a href="blog-post.html"><img src="https://img.youtube.com/vi/SP8ZN7uXJ10/maxresdefault.jpg" alt=""></a>
                <span class="badge badge-steam">steam</span>
                <div class="post-block">
                    <div class="post-caption">
                        <h2 class="post-title">
                            <a href="blog-post.html">For Honor: Every Highlander Execution and Emote</a>
                        </h2>
                        <div class="post-meta">
                            <span><i class="fa fa-clock-o"></i> Julye 20, 2017 by <a href="profile.html">YAKUZI</a></span>
                            <span><a href="blog-post.html#comments"><i class="fa fa-comment-o"></i> 7 comments</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-secondary p-t-15 p-b-5 p-x-15">
        <div class="owl-carousel owl-videos">
            <div class="card card-video">
                <div class="card-img">
                    <a href="video-post.html">
                        <img src="https://i1.ytimg.com/vi/GaERL8Nrl9k/mqdefault.jpg" alt="Tom Clancy's Ghost Recon: Wildlands">
                    </a>
                    <div class="card-meta">
                        <span>4:32</span>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><a href="video-post.html">Tom Clancy's Ghost Recon: Wildlands</a></h4>
                    <div class="card-meta">
                        <span><i class="fa fa-clock-o"></i> 2 hours ago</span>
                        <span>423 views</span>
                    </div>
                </div>
            </div>

            <div class="card card-video">
                <div class="card-img">
                    <a href="video-post.html">
                        <img src="https://i1.ytimg.com/vi/mW4LMCtoIkg/mqdefault.jpg" class="card-img-top" alt="Anthem Official Gameplay Reveal">
                    </a>
                    <div class="card-meta">
                        <span>6:46</span>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><a href="video-post.html">Anthem Official Gameplay Reveal</a></h4>
                    <div class="card-meta">
                        <span><i class="fa fa-clock-o"></i> 2 weeks ago</span>
                        <span>447 views</span>
                    </div>
                </div>
            </div>

            <div class="card card-video">
                <div class="card-img">
                    <a href="video-post.html">
                        <img src="https://i1.ytimg.com/vi/-PohBqV_i7s/mqdefault.jpg" class="card-img-top" alt="Shadow of War Gameplay Walkthrough">
                    </a>
                    <div class="card-meta">
                        <span>9:58</span>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><a href="video-post.html">Shadow of War Gameplay Walkthrough</a></h4>
                    <div class="card-meta">
                        <span><i class="fa fa-clock-o"></i> March 10, 2017</span>
                        <span>914 views</span>
                    </div>
                </div>
            </div>

            <div class="card card-video">
                <div class="card-img">
                    <a href="video-post.html">
                        <img src="https://i1.ytimg.com/vi/feqIj5PaqCQ/mqdefault.jpg" class="card-img-top" alt="Call of Duty WW2 Multiplayer Gameplay">
                    </a>
                    <div class="card-meta">
                        <span>4:32</span>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><a href="video-post.html">Call of Duty WW2 Multiplayer Gameplay</a></h4>
                    <div class="card-meta">
                        <span><i class="fa fa-clock-o"></i> 3 days ago</span>
                        <span>423 views</span>
                    </div>
                </div>
            </div>

            <div class="card card-video">
                <div class="card-img">
                    <a href="video-post.html">
                        <img src="https://i.ytimg.com/vi/N1NsF9c90f0/mqdefault.jpg" alt="Final Fantasy VII Remake">
                    </a>
                    <div class="card-meta">
                        <span>3:05</span>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><a href="video-post.html">Final Fantasy VII Remake</a></h4>
                    <div class="card-meta">
                        <span><i class="fa fa-clock-o"></i> 2 days ago</span>
                        <span>589 views</span>
                    </div>
                </div>
            </div>

            <div class="card card-video">
                <div class="card-img">
                    <a href="video-post.html">
                        <img src="https://i.ytimg.com/vi/lQXpDL3SNWQ/mqdefault.jpg" class="card-img-top" alt="Spider-Man Official 4K Trailer">
                    </a>
                    <div class="card-meta">
                        <span>3:07</span>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><a href="video-post.html">Spider-Man Official 4K Trailer</a></h4>
                    <div class="card-meta">
                        <span><i class="fa fa-clock-o"></i> 2 weeks ago</span>
                        <span>1798 views</span>
                    </div>
                </div>
            </div>

            <div class="card card-video">
                <div class="card-img">
                    <a href="video-post.html">
                        <img src="https://i1.ytimg.com/vi/9EzRBzdf--g/mqdefault.jpg" alt="METRO EXODUS Gameplay Trailer">
                    </a>
                    <div class="card-meta">
                        <span>1:24</span>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="card-title"><a href="video-post.html">Wolfenstein II Gameplay Trailer</a></h4>
                    <div class="card-meta">
                        <span><i class="fa fa-clock-o"></i> July 16, 2017</span>
                        <span>7330 views</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-t-35">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="toolbar-custom">
                        <a class="btn btn-default btn-icon m-r-10 float-left hidden-xs-down" href="#" data-toggle="tooltip" title="refresh" data-placement="bottom" role="button"><i class="fa fa-refresh"></i></a>
                        <div class="dropdown float-left">
                            <button class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">All Platform <i class="fa fa-caret-down"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item active" href="#">All platform</a>
                                <a class="dropdown-item" href="#">Playstation 4</a>
                                <a class="dropdown-item" href="#">Xbox One</a>
                                <a class="dropdown-item" href="#">Origin</a>
                                <a class="dropdown-item" href="#">Steam</a>
                            </div>
                        </div>

                        <a class="btn btn-default btn-icon m-l-10 float-right hidden-xs-down" href="#" data-toggle="tooltip" title="list" data-placement="bottom" role="button"><i class="fa fa-bars"></i></a>
                        <div class="dropdown float-right">
                            <button class="btn btn-default" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Date Added <i class="fa fa-caret-down"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item active" href="#">Date Added</a>
                                <a class="dropdown-item" href="#">Popular</a>
                                <a class="dropdown-item" href="#">Newest</a>
                                <a class="dropdown-item" href="#">Oldest</a>
                            </div>
                        </div>
                    </div>

                    <!-- post -->
                    <div class="post">
                        <h2 class="post-title"><a href="blog-post.html">Uncharted The Lost Legacy First Gameplay Details Revealed</a></h2>
                        <div class="post-meta">
                            <span><i class="fa fa-clock-o"></i> June 16, 2017 by <a href="profile.html">Constantine</a></span>
                            <span><a href="blog-post.html#comments"><i class="fa fa-comment-o"></i> 98 comments</a></span>
                        </div>
                        <div class="post-thumbnail">
                            <img src="img/blog/blog-1.jpg" alt="Uncharted The Lost Legacy First Gameplay Details Revealed">
                            <span class="badge badge-ps4">PS4</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
                            porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
                    </div>

                    <!-- post -->
                    <div class="post">
                        <h2 class="post-title"><a href="blog-post-carousel.html">The Last of Us 2 Was Teased in September and Nobody Noticed</a></h2>
                        <div class="post-meta">
                            <span><i class="fa fa-clock-o"></i> May 30, 2017 by <a href="profile.html">YAKUZI</a></span>
                            <span><a href="blog-post-carousel.html#comments"><i class="fa fa-comment-o"></i> 6 comments</a></span>
                        </div>
                        <div class="post-thumbnail">
                            <div id="carousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active"><img src="img/blog/blog-2.jpg"></div>
                                    <div class="carousel-item"><img src="img/blog/blog-3.jpg"></div>
                                </div>
                                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <span class="badge badge-ps4">PS4</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
                            porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
                    </div>

                    <!-- post -->
                    <div class="post">
                        <h2 class="post-title"><a href="blog-post-video.html">Dead Island 2 Official E3 Announce Gameplay Trailer</a></h2>
                        <div class="post-meta">
                            <span><i class="fa fa-clock-o"></i> May 22, 2017 by <a href="profile.html">Lobo</a></span>
                            <span><a href="blog-post-video.html#comments"><i class="fa fa-comment-o"></i> 33 comments</a></span>
                        </div>
                        <div class="post-thumbnail">
                            <div class="video-play" data-src="https://www.youtube.com/embed/ST262ZbNcos?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <img class="embed-responsive-item" src="https://img.youtube.com/vi/tklQ47Hpfxw/maxresdefault.jpg">
                                    <div class="video-play-icon"><i class="fa fa-play"></i></div>
                                </div>
                            </div>
                            <span class="badge badge-steam">Steam</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
                            porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
                    </div>

                    <!-- post -->
                    <div class="post">
                        <h2 class="post-title"><a href="blog-post-disqus.html">The Witcher 3: Don't Miss This Hidden Contract in Blood and Wine</a></h2>
                        <div class="post-meta">
                            <span><i class="fa fa-clock-o"></i> June 16, 2017 by <a href="profile.html">Venom</a></span>
                            <span><a href="blog-post-disqus.html#comments"><i class="fa fa-comment-o"></i> 9 comments</a></span>
                        </div>
                        <div class="post-thumbnail">
                            <img src="img/blog/blog-4.jpg" alt="The Witcher 3: Don't Miss This Hidden Contract in Blood and Wine">
                            <span class="badge badge-xbox-one">Xbox One</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas elit ante, congue sodales orci ac, ultrices pretium lectus. Maecenas lorem enim, dignissim sed lacus non, feugiat iaculis lorem. Integer eu aliquet diam. Suspendisse fringilla
                            porta justo, vel tempus risus. Ut et enim sit amet libero fermentum aliquam et ut sem.</p>
                    </div>

                    <div class="pagination-results">
                        <span>Showing 10 to 20 of 48 results</span>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="separate"><span>...</span></li>
                                <li class="page-item"><a class="page-link" href="#">25</a></li>
                                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /.post -->
                </div>

                <!-- sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- widget-games -->
                        <div class="widget widget-games">
                            <h5 class="widget-title">Upcoming Games</h5>
                            <a href="#" style="background-image: url('https://i1.ytimg.com/vi/mW4LMCtoIkg/mqdefault.jpg')">
                                <span class="overlay"></span>
                                <div class="widget-block">
                                    <div class="count">1</div>
                                    <div class="description">
                                        <h5 class="title">Horizon: Zero Dawn The Frozen Wilds</h5>
                                        <span class="date">November 14, 2017</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" style="background-image: url('https://i1.ytimg.com/vi/GaERL8Nrl9k/mqdefault.jpg')">
                                <span class="overlay"></span>
                                <div class="widget-block">
                                    <div class="count">2</div>
                                    <div class="description">
                                        <h5 class="title">Tom Clancy's Ghost Recon: Wildlands</h5>
                                        <span class="date">August 29, 2017</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" style="background-image: url('https://i1.ytimg.com/vi/feqIj5PaqCQ/mqdefault.jpg')">
                                <span class="overlay"></span>
                                <div class="widget-block">
                                    <div class="count">3</div>
                                    <div class="description">
                                        <h5 class="title">Call of Duty WW2</h5>
                                        <span class="date">December 15, 2017</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" style="background-image: url('https://i.ytimg.com/vi/N1NsF9c90f0/mqdefault.jpg')">
                                <span class="overlay"></span>
                                <div class="widget-block">
                                    <div class="count">4</div>
                                    <div class="description">
                                        <h5 class="title">Final Fantasy VII</h5>
                                        <span class="date">Q3 2018</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" style="background-image: url('https://i1.ytimg.com/vi/xUGRjNzGz3o/mqdefault.jpg')">
                                <span class="overlay"></span>
                                <div class="widget-block">
                                    <div class="count">5</div>
                                    <div class="description">
                                        <h5 class="title">Mass Effect Andromeda</h5>
                                        <span class="date">Q1, 2018</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- widget post  -->
                        <div class="widget widget-post">
                            <h5 class="widget-title">Recommends</h5>
                            <a href="blog-post.html"><img src="https://i1.ytimg.com/vi/4BLkEJu9szM/mqdefault.jpg" alt=""></a>
                            <h4><a href="blog-post.html">Titanfall 2's Trophies Only Have 3 Multiplayer</a></h4>
                            <span><i class="fa fa-clock-o"></i> June 12, 2017</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed ante facilisis efficitur.</p>
                        </div>

                        <!-- widget facebook -->
                        <div class="widget">
                            <h5 class="widget-title">Follow Us on Facebook</h5>
                            <div id="fb-root"></div>
                            <script async="" src="https://www.google-analytics.com/analytics.js"></script>
                            <script id="facebook-jssdk" src="//connect.facebook.net/en_US/sdk.js#xfbml=1&amp;version=v2.8"></script>
                            <script>
                                (function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));
                            </script>
                            <div class="fb-page" data-href="https://www.facebook.com/yakuthemes" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
                        </div>

                        <!-- widget post -->
                        <div class="widget widget-post">
                            <h5 class="widget-title">Popular on Gameforest</h5>
                            <a href="blog-post.html"><img src="img/blog/blog-widget-popular-1.jpg" alt=""></a>
                            <h4><a href="blog-post.html">Red Dead Redemption Being Modded Into GTA5 Multiplayer</a></h4>
                            <span><i class="fa fa-clock-o"></i> June 16, 2017</span>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
                            <ul class="widget-list">
                                <li>
                                    <div class="widget-img"><a href="blog-post.html"><img src="img/blog/blog-widget-1.jpg" alt=""></a></div>
                                    <div>
                                        <h4><a href="blog-post.html">Dead Island 2 and Escape Impressions</a></h4>
                                        <span>June 16, 2017</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="widget-img"><a href="blog-post.html"><img src="img/blog/blog-widget-2.jpg" alt=""></a></div>
                                    <div>
                                        <h4><a href="blog-post.html">How to Finish Mafia 3 With All of Your Underbosses</a></h4>
                                        <span>May 30, 2017</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="widget-img"><a href="blog-post.html"><img src="img/blog/blog-widget-3.jpg" alt=""></a></div>
                                    <div>
                                        <h4><a href="blog-post.html">Spider-Man Spin-Off, Venom, Gets Release Date</a></h4>
                                        <span>June 10, 2017</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="widget-img"><a href="blog-post.html"><img src="img/blog/blog-widget-4.jpg" alt=""></a></div>
                                    <div>
                                        <h4><a href="blog-post.html">Is Ghost Recon: Wildlands Worth Your Time?</a></h4>
                                        <span>June 16, 2017</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- widget tabs -->
                        <div class="widget widget-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" href="#comments" aria-controls="comments" role="tab" data-toggle="tab"><i class="fa fa-comment-o"></i> Comments</a></li>
                                <li class="nav-item"><a class="nav-link" href="#popular" aria-controls="popular" role="tab" data-toggle="tab">Popular</a></li>
                                <li class="nav-item"><a class="nav-link" href="#recent" aria-controls="recent" role="tab" data-toggle="tab">Recent</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="comments">
                                    <ul class="widget-comments">
                                        <li>
                                            <div><a href="profile.html"><img src="img/user/user-2.jpg" alt=""></a></div>
                                            <div>
                                                <a href="blog-post.html#comments"><b>Elizabeth:</b> It would have taken a ridiculous amount of careful precise actions.</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div><a href="profile.html"><img src="img/user/user-3.jpg" alt=""></a></div>
                                            <div>
                                                <a href="blog-post-disqus.html#comments"><b>Clark:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit curabitur risque.</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div><a href="profile.html"><img src="img/user/user-1.jpg" alt=""></a></div>
                                            <div>
                                                <a href="blog-post-video.html#comments"><b>Venom:</b> Practically no verticality, which on levels like The Spire (Geonosis) incredible.</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div><a href="profile.html"><img src="img/user/user-3.jpg" alt=""></a></div>
                                            <div>
                                                <a href="blog-post-disqus.html#comments"><b>Clark:</b> I'm low level at this point and have almost nothing unlocked, and veteran players have an unfair advantage over me thanks.</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div><a href="profile.html"><img src="img/user/user-5.jpg" alt=""></a></div>
                                            <div>
                                                <a href="blog-post-disqus.html#comments"><b>Trevor:</b> A lot of people would have stopped playing now if it wasn't for the online stuff!</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="popular">
                                    <div class="widget-post">
                                        <ul class="widget-list">
                                            <li>
                                                <img src="https://i1.ytimg.com/vi/B6qY-P4eo1Q/mqdefault.jpg" alt="">
                                                <h4><a href="blog-post.html">How to Finish Mafia 3 With All of Your Underbosses</a></h4>
                                                <span><i class="fa fa-clock-o"></i> July 12, 2017</span>
                                                <span>19 comments</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
                                            </li>
                                            <li>
                                                <h4><a href="blog-post.html">Uncharted: The Lost Legacy's Demo</a></h4>
                                                <span>June 28, 2017</span>
                                                <span>41 comments</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
                                            </li>
                                            <li>
                                                <h4><a href="blog-post.html">Mafia III Stones Unturned DLC Launch Trailer</a></h4>
                                                <span>June 17, 2017</span>
                                                <span>7 comments</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="recent">
                                    <div class="widget-post">
                                        <ul class="widget-list">
                                            <li>
                                                <img src="https://i1.ytimg.com/vi/ckUrcdnWZ2g/mqdefault.jpg" alt="">
                                                <h4><a href="blog-post.html">Free Mass Effect: Andromeda Trial Now Available On All Platforms</a></h4>
                                                <span><i class="fa fa-clock-o"></i> July 12, 2017</span>
                                                <span>76 comments</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
                                            </li>
                                            <li>
                                                <h4><a href="blog-post.html">GTA 5 Online Players Find Secret Alien Mission</a></h4>
                                                <span>June 23, 2017</span>
                                                <span>34 comments</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
                                            </li>
                                            <li>
                                                <h4><a href="blog-post.html">Mafia III Stones Unturned DLC Launch Trailer</a></h4>
                                                <span>June 17, 2017</span>
                                                <span>7 comments</span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel neque sed anter.</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-secondary">
        <div class="container">
            <div class="video-play" data-src="https://www.youtube.com/embed/d1uvFsiz8X0?rel=0&amp;amp;autoplay=1&amp;amp;showinfo=0">
                <div class="embed-responsive embed-responsive-16by9">
                    <img class="embed-responsive-item" src="https://img.youtube.com/vi/5fIAPcVdZO8/maxresdefault.jpg">
                    <div class="video-caption">
                        <h5>ARK: Survival Evolved Official Launch Trailer!</h5>
                        <span class="length">5:32</span>
                    </div>
                    <div class="video-play-icon">
                        <i class="fa fa-play"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-t-35 p-b-10">
        <div class="container">
            <h6 class="subtitle">Recommended Posts</h6>
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="card card-widget">
                        <div class="card-img">
                            <a href="blog-post-carousel.html"><img src="img/blog/blog-related-1.jpg" alt="Injustice 2 Story Mode Superman Ending"></a>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title"><a href="blog-post-carousel.html">Injustice 2 Story Mode Clark Ending Scene</a></h4>
                            <div class="card-meta"><span><i class="fa fa-clock-o"></i> July 21, 2017</span></div>
                            <p>Injustice 2's Story Mode features hours of cinematic cutscenes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card card-widget">
                        <div class="card-img">
                            <a href="blog-post-video.html"><img src="img/blog/blog-related-2.jpg" alt="New Injustice 2 Video Explains The Gear System"></a>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title"><a href="blog-post-video.html">New Injustice 2 Video Explains The Gear System</a></h4>
                            <div class="card-meta"><span><i class="fa fa-clock-o"></i> June 19, 2017</span></div>
                            <p>Following the new trailer dedicated to The Flash.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card card-widget">
                        <div class="card-img">
                            <a href="blog-post-disqus.html"><img src="img/blog/blog-related-3.jpg" alt="An Extra Week Of Double Rewards In GTA V"></a>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title"><a href="blog-post-disqus.html">An Extra Week Of Double Rewards In GTA V</a></h4>
                            <div class="card-meta"><span><i class="fa fa-clock-o"></i> June 18, 2017</span></div>
                            <p>Grand Theft Auto V players are getting an extra week to earn.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-widget">
                        <div class="card-img">
                            <a href="blog-post-hero.html"><img src="img/blog/blog-related-4.jpg" alt="BioShock: The Collection PC System Requirements Revealed"></a>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title"><a href="blog-post-hero.html">BioShock: The Collection PC System Requirements Revealed</a></h4>
                            <div class="card-meta"><span><i class="fa fa-clock-o"></i> June 09, 2017</span></div>
                            <p>2K revealed the PC system requirements for BioShock.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /main -->
@endsection