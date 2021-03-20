<div class="tw-top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">
                <div class="top-contact-info top-bar-link">
                    <ul class="d-flex flex-row navbar-nav justify-content-end">
                        @hasanyrole('super-admin|annonceur')
                        <li class="nav-item dropdown tw-megamenu-wrapper px-4">
                            <a href="{{route('user.create_announcement')}}"  class="nav-link"> Ajouter une annonce classée <i class="fa fa-bullhorn"></i></a>
                        </li>
                        <li class="nav-item dropdown tw-megamenu-wrapper px-4">
                            <a href="{{route('user.create_event')}}" class="nav-link" > Ajouter un évènement <i class="fa fa-calendar"></i></a>
                        </li>
                        @endrole
                        <li class="nav-item dropdown tw-megamenu-wrapper">
                            <a class="nav-link" href="#" data-toggle="dropdown">
                                Événements
                                <span class="tw-indicator"> <i class="fa fa-angle-down"></i> </span>
                            </a>
                            <div id="tw-megamenu" class="dropdown-menu tw-mega-menu">
                                <div class="row">
                                    <div class="col-md-12 col-lg-3 no-padding">
                                        <ul>
                                            <li class="tw-megamenu-title">
                                                <h3>Événements par régions</h3>
                                            </li>
                                            @foreach(\App\Models\Region::skip(0)->take(6)->get() as $region)
                                                <li><a href="{{route('event_region',$region)}}">{{ $region->name }}</a></li>
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
                                                <li><a href="{{route('event_region',$region)}}">{{ $region->name }}</a></li>
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
                                                <li><a href="{{route('event_region',$region)}}">{{ $region->name }}</a></li>
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
                                            @foreach(\App\Models\Category::where('type','annonce')->skip(0)->take(6)->get() as $category)
                                            <li><a href="{{route('announcement_page',$category)}}">{{ $category->name }}</a></li>
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
                                            @foreach(\App\Models\Category::where('type','annonce')->skip(6)->take(6)->get() as $category)
                                                <li><a href="{{route('announcement_page',$category)}}">{{ $category->name }}</a></li>
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
                                            @foreach(\App\Models\Category::where('type','annonce')->skip(12)->take(6)->get() as $category)
                                                <li><a href="{{route('announcement_page',$category)}}">{{ $category->name }}</a></li>
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
                                                <li><a href="{{route('announcement_page',$category)}}">{{ $category->name }}</a></li>
                                            @endforeach
                                           <!--  <li>
                                                <a href="#" class="text-primary">
                                                    Toutes les catégories d'annonces
                                                    <i class="ml-2 fa fa-arrow-right"></i>
                                                </a>
                                            </li> -->
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
                </div>
            </div>
            <!-- <div class="col-md-6 ml-auto text-right">
                <div class="top-contact-info">
                    <span>
                        <a href="{{ url('/pages/bien-debuter') }}"><i class="icon icon-chat"></i>Bien Débuter</a>
                    </span>
                    <span>
                        <a href="{{ url('/pages/comment') }}"><i class="icon icon-chat"></i>Comment ?</a>
                    </span>
                    <span>
                        <a href="{{ route('contact') }}"><i class="icon icon-chat"></i>Nous Contacter</a>
                    </span>
                    < !-- <span><i class="icon icon-chat"></i>Assistance en Ligne</span> -- >
                </div>
            </div> -->
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div>
<!-- Top Bar end -->
