@inject('credit', 'App\Models\Credit')

<!-- header======================-->
<header>
    <div class="tw-head">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container-fluid">
                    <a class="navbar-brand tw-nav-brand" href="{{ route('welcome') }}">
                        <img src="{{asset('images/logo/logo.png')}}" alt="{{ config('app.name') }}">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                            @hasanyrole('super-admin|admin|annonceur|vendeur')
                                <li class="nav-item dropdown tw-megamenu-wrapper">
                                    <a href="{{route('user.create_announcement')}}"  class="nav-link"> Ajouter une annonce <i class="fa fa-bullhorn"></i></a>
                                </li>
                                <li class="nav-item dropdown tw-megamenu-wrapper">
                                    <a href="{{route('user.create_event')}}" class="nav-link" > Ajouter un évènement <i class="fa fa-calendar"></i></a>
                                </li>
                            @endrole
                            @if(Route::has("login"))
                                @auth
                                    <li class="nav-item dropdown"">
                                        <a class="" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Tableau de bord <i class="fa fa-user-shield"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            @hasanyrole('super-admin')
                                                @include('layouts.front.partials.su-admin')
                                            @endrole
                                            @hasanyrole('banquier')
                                                @include('layouts.front.partials.banker')
                                            @endrole
                                            @hasanyrole('chef-vendeur')
                                                @include('layouts.front.partials.cvendeur')
                                            @endrole
                                            @hasanyrole('vendeur')
                                                @include('layouts.front.partials.cvendeur')
                                            @endrole
                                            @hasanyrole('admin')
                                                @include('layouts.front.partials.admin')
                                            @endrole
                                            <hr>
                                            @hasanyrole('vendeur|super-admin|annonceur|admin')
                                                <a class="dropdown-item" href="{{route('user.my_events')}}"><i class="fas fa-calendar-check"></i>  Mes événements</a>
                                                <a class="dropdown-item" href="{{route('user.my_announcements')}}"><i class="fa fa-bullhorn"></i> Mes Annonces</a>
                                            @endrole
                                            <hr>
                                            <a class="dropdown-item" href="{{route('user.infosperso')}}/infos-perso"><i class="fa fa-user"></i> Infos personelles</a>
                                            <a class="dropdown-item link-success" href="{{route('user.infosperso')}}/transactions" title="Lsite de mes transactions"><i class="fas fa-exchange-alt" aria-hidden="true"></i> Mes Transactions</a>
                                            <a class="dropdown-item link-primary" href="{{route('user.infosperso')}}/wallet" title="Mon Portefeuille"><i class="fa fa-wallet" aria-hidden="true"></i> Mon Portefeuille </a>
                                            <a class="dropdown-item" href="{{route('logout')}}"><i class="fa fa-power-off"></i> Se déconnecter</a>
                                        </ul>
                                        </li>
                                @else
                                
                                <li class="nav-item dropdown tw-megamenu-wrapper">
                                    <a href="{{ route('login') }}" class="" id="">
                                        <i class="fa fa-user-circle-o mr-2"></i> Se connecter
                                    </a>
                                </li>
                                @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End of Nav -->
        </div>
        <!-- End of Container -->
    </div>
    <!-- End tw head -->
</header>
<!-- End of Header area=-->