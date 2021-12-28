<style>
    .sub-menu.show {
        display: block !important;
    }
</style>
<aside class="admin-sidebar show sidebar-show">
    <div class="admin-sidebar-brand">
        <!-- begin sidebar branding-->
        <img class="admin-brand-logo" src="{{asset('assets/img/logo-white.png')}}" width="75%" alt="makeContent Logo">
        <div class="ml-auto">
            <!-- sidebar pin-->
            <a href="#" class="admin-pin-sidebar btn-ghost btn btn-rounded-circle"></a>
            <!-- sidebar close for mobile device-->
            <a href="#" class="admin-close-sidebar"></a>
        </div>
    </div>
    </div>
    <div class="admin-sidebar-wrapper js-scrollbar">
        <ul class="menu">
            <li class="menu-item {{$menu=='dashboard'?'active':''}}">
                <a href="{{url('home')}}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Dashboard</span>
                    </span>
                    <span class="menu-icon">
                        <span class="icon-badge badge-success badge badge-pill">4</span>
                            <i class="icon-placeholder mdi mdi-shape-outline "></i>
                    </span>
                </a>
            </li>
            
            @if(in_array("Marketplace",auth()->user()->menuRole()))
            <li class="menu-item{{ request()->routeIs('marketplace*') ? ' active' : ''}}">
                    <a href="#" class="open-dropdown menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Marketplace<span class="menu-arrow"></span>
                            </span>
                        </span>
                        <span class="menu-icon">
                            <i class="icon-placeholder mdi mdi-polymer"></i>
                        </span>
                    </a>
                <!--submenu-->
                <ul class="sub-menu{{ request()->routeIs('marketplace*') ? ' show' : ''}}">
                    <li class="menu-item{{ request()->routeIs('marketplace') ? ' active' : ''}}">
                        <a href="{{ route('marketplace') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Browse Marketplace</span>
                    </span>
                            <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-polymer "></i>
                    </span>
                        </a>
                        <!--submenu-->
                    </li>

                    @if(auth()->user()->role() === \App\User::TYPE_CLIENT)
                        <li class="menu-item{{ request()->routeIs('marketplace.bought_text*') ? ' active' : ''}}">
                            <a href="{{ route('marketplace.bought_text') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Buyed text</span>
                    </span>
                                <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-polymer "></i>
                    </span>
                            </a>
                            <!--submenu-->
                        </li>
                    @endif
                </ul>
            </li>
            @endif

            @if(in_array("BrowseJobs",auth()->user()->menuRole()))
            <li class="menu-item {{$menu=='projects'?'active':''}}">
                    <a href="#" class="open-dropdown menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Browse Jobs<span class="menu-arrow"></span>
                            </span>
                        </span>
                        <span class="menu-icon">
                            <i class="icon-placeholder mdi mdi-lead-pencil "></i>
                        </span>
                    </a>
                <!--submenu-->
                <ul class="sub-menu {{$menu=='projects'?'show':''}}">
                    <li class="menu-item {{$menu=='projects' && $submenu=='open' ? 'active':''}}">
                        <a href="{{ route('projects.browse') }}" class=" menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Browse Projects</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-checkbook "></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item {{$menu=='projects' && $submenu=='actual' ? 'active':''}}">
                        <a href="{{ route('projects.actual') }}" class=" menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Acctual Projects
                                </span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-checkbox-multiple-marked-circle "></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item {{$menu=='projects' && $submenu=='history' ? 'active':''}}">
                        <a href="{{ route('projects.history') }} " class=" menu-link">
                            <span class="menu-label">
                                <span class="menu-name">History Projects
                                </span>
                            </span>
                            <span class="menu-icon"><i class="icon-placeholder mdi mdi-calendar-edit "></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(in_array("Order",auth()->user()->menuRole()))
            <li class="menu-item {{$menu=='projects'?'active':''}}">
                    <a href="#" class="open-dropdown menu-link">
                        <span class="menu-label">
                            <span class="menu-name">My Orders<span class="menu-arrow"></span>
                            </span>
                        </span>
                        <span class="menu-icon">
                            <i class="icon-placeholder mdi mdi-lead-pencil "></i>
                        </span>
                    </a>
                <!--submenu-->
                <ul class="sub-menu {{$menu=='projects'?'show':''}}">
                    <li class="menu-item {{$menu=='projects' && $submenu=='open' ? 'active':''}}">
                        <a href="{{ route('projects.open') }}" class=" menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Open Projects</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-checkbook "></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item {{$menu=='projects' && $submenu=='sketch' ? 'active':''}}">
                        <a href="{{ route('projects.sketch') }}" class=" menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Sketchs Projects
                                </span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-checkbox-multiple-marked-circle "></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item {{$menu=='projects' && $submenu=='history' ? 'active':''}}">
                        <a href="{{ route('projects.history') }} " class=" menu-link">
                            <span class="menu-label">
                                <span class="menu-name">History Projects
                                </span>
                            </span>
                            <span class="menu-icon"><i class="icon-placeholder mdi mdi-calendar-edit "></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            
            @if(in_array("BrowseCopywriter",auth()->user()->menuRole()))
            <li class="menu-item {{$menu=='copywriter' ? 'active':''}}">
                    <a href="{{ route('copylist') }}" class="menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Browser Copywriters</span>
                        </span>
                        <span class="menu-icon">
                            <i class="icon-placeholder mdi mdi-cursor-default-outline "></i>
                        </span>
                    </a>
            </li>
            @endif

            @if(in_array("Financial",auth()->user()->menuRole()))
            <li class="menu-item {{$menu=='financial' ? 'active':''}}">
                <a href="#" class="open-dropdown menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Financial
                                <span class="menu-arrow"></span>
                            </span>
                        </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-coins"></i>
                    </span>
                </a>
                <!--submenu-->
                <ul class="sub-menu {{$menu=='financial' ? 'show':''}}">
                    <li class="menu-item {{$menu=='financial' && $submenu=='payments' ? 'active':''}}">
                        <a href="{{ route('payments') }}" class=" menu-link">
                             <span class="menu-label">
                                 <span class="menu-name">Payments</span>
                             </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-credit-card-plus"></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item {{$menu=='financial' && $submenu=='invoice' ? 'active':''}}">
                        <a href="{{ route('invoice') }}" class=" menu-link">
                            <span class="menu-label">
                                 <span class="menu-name">Invoices</span>
                            </span>
                            <span class="menu-icon">
                                 <i class="icon-placeholder mdi mdi-file-pdf"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(in_array("Messanges",auth()->user()->menuRole()))
            <li class="menu-item {{$menu=='chat' ? 'active':''}}">
                    <a href="{{ route('chat') }}" class="menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Messanges</span>
                        </span>
                        <span class="menu-icon">
                            <i class="icon-placeholder mdi mdi-chat "></i>
                        </span>
                    </a>
            </li>
            @endif

            @if(in_array("Affiliate",auth()->user()->menuRole()))
            <!-- <li class="menu-item {{$menu=='affilate' ? 'active':''}}">
                <a href="{{ route('affilate') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Affilate</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-teach"></i>
                    </span>
                </a>
            </li> -->
            <li class="menu-item {{$menu=='affilate' ? 'active':''}}">
                <a href="#" class="open-dropdown menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Affilate
                                <span class="menu-arrow"></span>
                            </span>
                        </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-coins"></i>
                    </span>
                </a>
                <!--submenu-->
                <ul class="sub-menu {{$menu=='affilate' ? 'show':''}}">
                    <li class="menu-item {{$menu=='affilate' && $submenu=='affilate' ? 'active':''}}">
                        <a href="{{ route('affilate') }}" class=" menu-link">
                             <span class="menu-label">
                                 <span class="menu-name">Dashboard</span>
                             </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-credit-card-plus"></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item {{$menu=='affilate' && $submenu=='affilate-all' ? 'active':''}}">
                        <a href="{{ route('affilate_all') }}" class=" menu-link">
                            <span class="menu-label">
                                 <span class="menu-name">Renewals List</span>
                            </span>
                            <span class="menu-icon">
                                 <i class="icon-placeholder mdi mdi-file-pdf"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            
            <li class="menu-item {{$menu=='settings' ? 'active':''}}">
                <a href="{{ route('settings') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Settings</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-settings"></i>
                    </span>
                </a>
            </li>
            <li class="menu-item {{$menu=='support' ? 'active':''}}">
                <a href="{{ route('support') }}" class="menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Support</span>
                    </span>
                    <span class="menu-icon">
                        <i class="icon-placeholder mdi mdi-account-star"></i>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</aside>
