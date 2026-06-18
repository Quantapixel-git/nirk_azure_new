<div class="aiz-sidebar-wrap">

    <div class="aiz-sidebar left c-scrollbar">

        <div class="aiz-side-nav-logo-wrap">

            <div class="d-block text-center my-3">

                <img class="mw-100 mb-3"
                     src="{{ uploaded_asset(get_setting('header_logo')) }}"
                     alt="Logo">

                <h3 class="fs-16 m-0 text-primary">
                    {{ Auth::user()->name }}
                </h3>

                <p class="text-primary">
                    {{ Auth::user()->email }}
                </p>

            </div>

        </div>

        <div class="aiz-side-nav-wrap">

            <ul class="aiz-side-nav-list" id="main-menu">

                {{-- Dashboard --}}
                <li class="aiz-side-nav-item">

                    <a href="{{ route('agent.dashboard') }}"
                       class="aiz-side-nav-link">

                        <i class="las la-home aiz-side-nav-icon"></i>

                        <span class="aiz-side-nav-text">
                            Dashboard
                        </span>

                    </a>

                </li>

                {{-- User Management --}}
                <li class="aiz-side-nav-item">

                    <li class="aiz-side-nav-item">

    <a href="{{ route('agent.users') }}"
       class="aiz-side-nav-link">

        <i class="las la-users aiz-side-nav-icon"></i>

        <span class="aiz-side-nav-text">
            User Management
        </span>

    </a>

</li>



                    <ul class="aiz-side-nav-list level-2">

                        <li class="aiz-side-nav-item">
                            <a href="{{ route('agent.users') }}"
                               class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">
                                    All Users
                                </span>
                            </a>
                        </li>

                    </ul>

                </li>

                {{-- Vendors --}}
                <li>
    <a href="{{ route('agent.vendors') }}"
       class="aiz-side-nav-link">

        <i class="las la-store aiz-side-nav-icon"></i>

        <span class="aiz-side-nav-text">
            Vendor Management
        </span>

    </a>
</li>
            </ul>

        </div>

    </div>

    <div class="aiz-sidebar-overlay"></div>

</div>