<!-- ======= Header ======= -->
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="/" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('img/logo(bg).png') }}" alt="logo">
        </a>
        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="/service">{{__('How it works')}}</a></li>
                <li><a href="/contact">{{__('Contact')}}</a></li>
                <li><a href="/about">{{__('About US')}}</a></li>
                <li class="dropdown">
                    <a href="#">
              <span>
                @guest
                      {{__("My account")}}
                  @else
                      {{ Auth::user()->name }}
                  @endguest
              </span>
                        <i class="bi bi-chevron-down dropdown-indicator"></i>
                    </a>
                    <ul>
                        @guest
                            <li><a class="account-link" href="/whosignup">{{__('Open Account')}}</a></li>
                            <li><a class="account-link" href="/login">{{__('Log In')}}</a></li>
                        @else
                            <li>
                                @if(auth()->user()->type == 'user')
                                    <a class="account-link" href="{{url('dashboard')}}">{{__('Dashboard')}}</a>
                                @elseif(auth()->user()->type == 'admin')
                                    <a class="account-link" href="{{url('admin/adminDashboard')}}">{{__('Dashboard')}}</a>
                                @elseif(auth()->user()->type == 'company')
                                    <a class="account-link" href="{{url('company/companyDashboard')}}">{{__('Dashboard')}}</a>
                                @endif
                            </li>
                            <li>
                                <a class="account-link nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </li>
<style>
    /* Responsive Styles */
    @media (max-width: 768px) {
        ul.dropdown-menu {
            position: static !important;
            width: 100%;
        }

        ul.dropdown-menu li {
            display: block;
            width: 100%;
            text-align: left;
        }
    }

</style>
                <li class="dropdown">

                    <a href="#">
              <span>

                  <img src="{{asset(getFlag())}}" width="30px" height="30px">

              </span>
                        <i class="bi bi-chevron-down dropdown-indicator"></i>
                    </a>
                    <ul class="dropdown-menu drp">
                    <style>
                           .drp{
                           left:-90px !important;
                           }
                      </style>
                        <a href="{{route('change-language', 'en')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;"><img
                                    src="{{asset('img/flags/usa.png')}}" width="30px" height="30px">{{__('English ')}}<i
                                    class="{{session('locale') == 'en' || session('locale') == null  ? 'fa fa-check' : ""}}"></i></li>
                        </a>
                        <a href="{{route('change-language', 'de')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;"><img
                                    src="{{asset('img/flags/germany.png')}}">{{__(' Deutsch')}}<i class="{{session('locale') == 'de' ? 'fa fa-check' : ""}}"></i></li>
                        </a>
                        <a href="{{route('change-language', 'it')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;"><img
                                    src="{{asset('img/flags/italy.png')}}">{{__('Italiano')}}<i class="{{session('locale') == 'it' ? 'fa fa-check' : ""}}"></i></li>
                        </a>
                        <a href="{{route('change-language', 'fr')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;"><img
                                    src="{{asset('img/flags/france.png')}}">{{__('Français')}}<i class="{{session('locale') == 'fr' ? 'fa fa-check' : ""}}"></i></li>
                        </a>
                        <a href="{{route('change-language', 'es')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;">
                                <img src="{{asset('img/flags/spain.png')}}">{{__(' Español')}}<i class="{{session('locale') == 'es' ? 'fa fa-check' : ""}}"></i></li>
                        </a>
                        <a href="{{route('change-language', 'pt')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;">
                                <img src="{{asset('img/flags/portugal.png')}}">{{__(' Portugal')}}<i class="{{session('locale') == 'pt' ? 'fa fa-check' : ""}}"></i>
                            </li>
                        </a>
                        <a href="{{route('change-language', 'pl')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;">
                                <img src="{{asset('img/flags/poland.png')}}">{{__('Polish')}}<i class="{{session('locale') == 'pl' ? 'fa fa-check' : ""}}"></i>
                            </li>
                        </a>
                        <a href="{{route('change-language', 'ro')}}">
                            <li style="display: flex;align-items: center;justify-content: space-between;">
                                <img src="{{asset('img/flags/romania.png')}}">{{__(' Romanian')}}<i
                                    class="{{session('locale') == 'ro' ? 'fa fa-check' : ""}}"></i></li>
                        </a>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
<!-- End Header -->
