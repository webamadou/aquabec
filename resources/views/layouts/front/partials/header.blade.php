@inject('credit', 'App\Models\Credit')

<!-- header======================-->
<header>
    <div class="tw-head">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <a class="navbar-brand tw-nav-brand" href="{{ route('welcome') }}">
                    <img src="{{asset('images/logo/logo.png')}}" alt="{{ config('app.name') }}">
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
                    <!-- End Navbar Nav -->
                </div>
                <!-- End of navbar collapse -->
                @if(Route::has("login"))
                    @auth
                      <div class="dropdown">
                        <a class="btn btn-sm btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i class="fa fa-user-circle-o mr-2"></i> {{ Auth::user()->name }}</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
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
                            @hasanyrole('vendeur|super-admin|annonceur')
                            <a class="dropdown-item" href="{{route('user.my_events')}}"><i class="fas fa-calendar-check"></i>  Mes évènements</a>
                            <a class="dropdown-item" href="{{route('user.my_announcements')}}"><i class="fa fa-bullhorn"></i> Mes Annonces</a>
                            @endrole
                            <hr>
                            <a class="dropdown-item" href="{{route('user.infosperso')}}/infos-perso"><i class="fa fa-user"></i> Infos personelles</a>
                            <a class="dropdown-item link-success" href="{{route('user.infosperso')}}/transactions" title="Lsite de mes transactions"><i class="fas fa-exchange-alt" aria-hidden="true"></i> Mes Transactions</a>
                            <a class="dropdown-item link-primary" href="{{route('user.infosperso')}}/wallet" title="Mon Portefeuille"><i class="fa fa-wallet" aria-hidden="true"></i> Mon Portefeuille </a>
                            <a class="dropdown-item" href="{{route('logout')}}"><i class="fa fa-power-off"></i> Se déconnecter</a>
                        </div>
                      </div>
                    @else
                      <a href="{{ route('login') }}" class="btn btn-primary" id="client-area">
                          <i class="fa fa-user-circle-o mr-2"></i> Se connecter
                      </a>
                    @endauth
                @endif
                <!-- End off canvas menu -->
            </nav>
            <!-- End of Nav -->
        </div>
        <!-- End of Container -->
    </div>
    <!-- End tw head -->
</header>
<!-- End of Header area=-->
