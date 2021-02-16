<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="{{mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    <script src="{{mix('js/app.js') }}" type="text/javascript" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{!!asset('assets/images/icon.ico')!!}" type="image/x-icon">
</head>

<body data-app>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"><img src="{!!asset('assets/images/logo_crc-white.png')!!}" alt=""></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <div class="btn-group">
                        <button
                            type="button"
                            class="btn-icon btn-icon-only btn btn-success btn-sm btn-menu-user"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            id="dropdownMenuLink"
                        >
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>

                        <div
                            tabindex="-1"
                            role="menu"
                            aria-hidden="true"
                            class="dropdown-menu dropdown-menu-right"
                            aria-labelledby="dropdownMenuLink"
                        >
                            <h6 tabindex="-1" class="dropdown-header">{{auth()->user()->name}}</h6>
                            <a href="/update/user/{{auth()->user()->id}}" tabindex="0" class="dropdown-item">User Account</a>
                            <button id="logout" type="button" tabindex="0" class="dropdown-item logout">Sign Out</button>
                        </div>
                    </div>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            class="p-0 btn">
                                            <img width="42" class="rounded-circle"
                                                src="{!!asset('assets/user_avatar/'.auth()->user()->avatar)!!}" alt="">
                                            <span style="color: #fff"><i
                                                    class="fa fa-angle-down ml-2 opacity-8"></i></span>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu dropdown-menu-right">
                                            <h6 tabindex="-1" class="dropdown-header">{{auth()->user()->name}}</h6>
                                            <a href="/update/user/{{auth()->user()->id}}" tabindex="0" class="dropdown-item">User Account</a>
                                            <button id="logout" type="button" tabindex="0" class="dropdown-item logout">Sign Out</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        <strong>{{auth()->user()->name}}</strong>
                                    </div>
                                    <div class="widget-subheading">
                                        {{auth()->user()->role}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="App">
            <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                    data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button"
                                class="btn-icon btn-icon-only btn btn-success btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">Overview</li>
                                <li>
                                    <router-link exact to="/" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-browser"></i>
                                        Dashboard
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/overview/stat/radar-chart" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-graph3"></i>
                                        Radar chart
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/overview/stat/normal-distribution" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-graph2"></i>
                                        Normal distribution
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/overview/stat/ranking-scatter" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-graph1"></i>
                                        Ranking scatter plot
                                    </router-link>
                                </li>
                                @if(auth()->user()->role=='admin')
                                <li>
                                    <router-link to="/overview/stat/pie-chart" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-graph"></i>
                                        Pie chart
                                    </a>
                                </li>
                                @endif
                                <li class="app-sidebar__heading">App</li>
                                @if(auth()->user()->role=='admin')
                                <li>
                                    <router-link to="/user-managements" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-users"></i>
                                        User management
                                    </router-link>
                                </li>
                                @endif
                                <li>
                                    <router-link to="/new-file" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-note"></i>
                                        Create new file
                                    </a>
                                </li>
                                <li>
                                    <router-link to="/chemicals" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-drop"></i>
                                        Chemical data list
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/data-results" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-folder"></i>
                                        Results
                                    </a>
                                </li>
                                <li>
                                    <router-link to="/user-guides" active-class="mm-active">
                                        <i class="metismenu-icon pe-7s-bookmarks"></i>
                                        User guide
                                    </router-link>
                                </li>
                                <div class="footer-nav">
                                    <a href="https://www.industry.gov.au/"><img
                                            src="{{asset('assets/images/DISER_CRC-Business-stacked-RGB.png')}}"></a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <router-view></router-view>
                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <?php $y=date('Y') ?>
                                            <a href="https://crccare.com"
                                                style="color: #000 !important; text-decoration: none;">&copy; Copyright
                                                {{$y}} &#8211; CRC CARE</a>
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    </script>
    <script type="text/javascript">
      const logoutButtons = document.getElementsByClassName('logout');
      for (let i = 0; i < logoutButtons.length; i++) {
        logoutButtons[i].addEventListener('click', async () => {
          const willOut = await swal({
            title: 'Sign out',
            text: 'Are you sure you want to sign out?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
          });
          if (willOut) {
            window.location.href = '/sign-out';
          }
        });
      }

    </script>
</body>

</html>
