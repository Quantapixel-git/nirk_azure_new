<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-0"
            data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">

        <div></div>

        <div class="d-flex justify-content-around align-items-center align-items-stretch">

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">

                    <a class="dropdown-toggle no-arrow text-dark"
                        data-toggle="dropdown"
                        href="javascript:void(0);">

                        <span class="d-flex align-items-center">

                            <span class="avatar avatar-sm mr-md-2">
                                <img src="<?php echo e(uploaded_asset(Auth::user()->avatar_original)); ?>"
                                     onerror="this.src='<?php echo e(static_asset('assets/img/avatar-place.png')); ?>';">
                            </span>

                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">
                                    <?php echo e(Auth::user()->name); ?>

                                </span>

                                <span class="d-block small opacity-60">
                                    Agent
                                </span>
                            </span>

                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">

                        <a href="<?php echo e(route('agent.profile')); ?>" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>Profile</span>
                        </a>

                        <a href="<?php echo e(route('logout')); ?>" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>

                    </div>

                </div>
            </div>

        </div>

    </div>
</div><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/inc/agent_nav.blade.php ENDPATH**/ ?>