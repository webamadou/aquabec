<!-- header======================-->
<header>
    <div class="tw-head">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <a class="navbar-brand tw-nav-brand" href="{{ route('welcome') }}">
                    <img src="images/logo/logo.png" alt="seobin">
                </a>
                <!-- End of Navbar Brand -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- End of Navbar toggler -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown tw-megamenu-wrapper">
                            <a class="nav-link" href="#" data-toggle="dropdown">
                                Événements
                                <span class="tw-indicator">
                              <i class="fa fa-angle-down"></i>
                           </span>
                            </a>
                            <div id="tw-megamenu" class="dropdown-menu tw-mega-menu">
                                <div class="row">
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>Evenements par régions</h3>
                                            </li>
                                            @foreach(\App\Models\Region::skip(0)->take(6)->get() as $region)
                                                <li><a href="#">{{ $region->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- End UL -->
                                    </div>
                                    <!-- End Col -->
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>&nbsp;</h3>
                                            </li>
                                            @foreach(\App\Models\Region::skip(6)->take(6)->get() as $region)
                                                <li><a href="#">{{ $region->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- End UL -->
                                    </div>
                                    <!-- End Col -->
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>&nbsp;</h3>
                                            </li>
                                            @foreach(\App\Models\Region::skip(12)->take(6)->get() as $region)
                                                <li><a href="#">{{ $region->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- End Ul -->
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Row -->
                            </div>
                            <!-- End of Mega menu -->
                        </li>
                        <!-- End MegaMenu -->
                        <li class="nav-item dropdown tw-megamenu-wrapper">
                            <a class="nav-link" href="#" data-toggle="dropdown">
                                Annonces
                                <span class="tw-indicator">
                                <i class="fa fa-angle-down"></i>
                           </span>
                            </a>
                            <div id="tw-megamenu" class="dropdown-menu tw-mega-menu">
                                <div class="row">
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>Annonces Classées</h3>
                                            </li>
                                            @foreach(\App\Models\Category::where('type','announcement')->skip(0)->take(6)->get() as $category)
                                            <li><a href="#">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- End UL -->
                                    </div>
                                    <!-- End Col -->
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>&nbsp;</h3>
                                            </li>
                                            @foreach(\App\Models\Category::where('type','announcement')->skip(6)->take(6)->get() as $category)
                                                <li><a href="#">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- End UL -->
                                    </div>
                                    <!-- End Col -->
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>&nbsp;</h3>
                                            </li>
                                            @foreach(\App\Models\Category::where('type','announcement')->skip(12)->take(6)->get() as $category)
                                                <li><a href="#">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- End Ul -->
                                    </div>
                                    <!-- End Col -->
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>&nbsp;</h3>
                                            </li>
                                            @foreach(\App\Models\Category::where('type','announcement')->skip(18)->take(5)->get() as $category)
                                                <li><a href="#">{{ $category->name }}</a></li>
                                            @endforeach
                                            <li>
                                                <a href="#" class="text-primary">
                                                    Toutes les catégories d'annonces
                                                    <i class="ml-2 fa fa-arrow-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- End Ul -->
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Row -->
                            </div>
                            <!-- End of Mega menu -->
                        </li>
                        <!-- End MegaMenu -->
                    </ul>
                    <!-- End Navbar Nav -->
                </div>
                <!-- End of navbar collapse -->

                <a href="{{ route('user.dashboard') }}" class="btn btn-primary" id="client-area">
                    <i class="fa fa-user-circle-o mr-2"></i>
                    Espace Client
                </a>
                <!-- End off canvas menu -->
            </nav>
            <!-- End of Nav -->
        </div>
        <!-- End of Container -->
    </div>
    <!-- End tw head -->
</header>
<!-- End of Header area=-->