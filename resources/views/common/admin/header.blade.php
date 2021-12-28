<header class="admin-header">
    <a href="#" class="sidebar-toggle" data-toggleclass="sidebar-open" data-target="body"> </a>

    <nav class=" ml-auto">
        <ul class="nav align-items-center">
            <li class="nav-item">
                <div class="text-center">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn  btn-dark ">
                            <i class="mdi mdi-coins"></i>
                            <input type="radio" name="radio2" id="option1" checked>
                            Balance: {{ auth()->user()->wallet ? roundPrice(auth()->user()->wallet->total_balance):'0,00' }}
                            {{auth()->user()->country ? auth()->user()->country->currency : ''}}
                        </label>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <div class="dropdown">
                    <a href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                class="mdi mdi-24px mdi-bell-outline"></i>
                        <span class="notification-counter"></span>
                    </a>
                    <div class="dropdown-menu notification-container dropdown-menu-right">
                        <div class="d-flex p-all-15 bg-white justify-content-between border-bottom ">
                            <a href="#!" class="mdi mdi-18px mdi-settings text-muted"></a>
                            <span class="h5 m-0">Notifications</span>
                            <a href="#!" class="mdi mdi-18px mdi-notification-clear-all text-muted"></a>
                        </div>
                        <div class="notification-events bg-gray-300">
                            <div class="text-overline m-b-5">today</div>
                            <a href="#" class="d-block m-b-10">
                                <div class="card">
                                    <div class="card-body"><i class="mdi mdi-circle text-success"></i> All systems
                                        operational.
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false"> <i class="{{'flag-icon flag-icon-'.app()->getLocale()}}"></i> </a>
                <div class="dropdown-menu dropdown-menu-right p-0" style="left: inherit; right: 0px;">
                    <!-- <a href="{{ route('lang.change', ['locale' => app()->getLocale()=='pl'?'en':'pl']) }}" class="dropdown-item"> <i class="{{'mr-2 flag-icon flag-icon-'.(app()->getLocale()=='pl'?'en':'pl')}}"></i> {{app()->getLocale()=='pl'?'English':'Polish'}} </a> -->
                    <a href="{{ route('lang.change', ['locale' => 'en']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-en"></i> English </a>
                    <a href="{{ route('lang.change', ['locale' => 'pl']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-pl"></i> Polish </a>
                    <a href="{{ route('lang.change', ['locale' => 'se']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-se"></i> Svenska </a>
                    <a href="{{ route('lang.change', ['locale' => 'de']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-de"></i> Deutsch </a>
                    <a href="{{ route('lang.change', ['locale' => 'dk']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-dk"></i> Dansk </a>
                    <a href="{{ route('lang.change', ['locale' => 'cz']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-cz"></i> Czech </a>
                    <a href="{{ route('lang.change', ['locale' => 'es']) }}" class="dropdown-item"> <i class="mr-2 flag-icon flag-icon-es"></i> Espanol </a>
                </div>
            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-sm avatar-online">
                        @if(Auth::user()->avatar)
                            <img src="{{asset(Auth::user()->avatar)}}" class="avatar-title rounded-circle"
                                 alt="{{ substr(Auth::user()->name, 0, 1)}}">
                        @else
                            <span class="avatar-title rounded-circle bg-dark" id="user_name">V</span>
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu  dropdown-menu-right">
                    <a class="dropdown-item">#ID {{ auth()->user()->getPublicId() }}</a>
                    <a class="dropdown-item" href="{{ route('settings') }}">Setting's</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>

    </nav>
</header>