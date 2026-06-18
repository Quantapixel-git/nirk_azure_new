<div class="aiz-sidebar-wrap">

    <div class="aiz-sidebar left c-scrollbar">

        <div class="aiz-side-nav-logo-wrap">

            <div class="d-block text-center my-3">

                <img class="mw-100 mb-3"
                     src="<?php echo e(uploaded_asset(get_setting('header_logo'))); ?>"
                     alt="Logo">

                <h3 class="fs-16 m-0 text-primary">
                    <?php echo e(Auth::user()->name); ?>

                </h3>

                <p class="text-primary">
                    <?php echo e(Auth::user()->email); ?>

                </p>

            </div>

        </div>

        <div class="aiz-side-nav-wrap">

            <ul class="aiz-side-nav-list" id="main-menu">

                
                <li class="aiz-side-nav-item">

                    <a href="<?php echo e(route('agent.dashboard')); ?>"
                       class="aiz-side-nav-link">

                        <i class="las la-home aiz-side-nav-icon"></i>

                        <span class="aiz-side-nav-text">
                            Dashboard
                        </span>

                    </a>

                </li>

                
                <li class="aiz-side-nav-item">

                    <li class="aiz-side-nav-item">

    <a href="<?php echo e(route('agent.users')); ?>"
       class="aiz-side-nav-link">

        <i class="las la-users aiz-side-nav-icon"></i>

        <span class="aiz-side-nav-text">
            User Management
        </span>

    </a>

</li>



                    <ul class="aiz-side-nav-list level-2">

                        <li class="aiz-side-nav-item">
                            <a href="<?php echo e(route('agent.users')); ?>"
                               class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">
                                    All Users
                                </span>
                            </a>
                        </li>

                    </ul>

                </li>

                
                <li>
    <a href="<?php echo e(route('agent.vendors')); ?>"
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

</div><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/inc/agent_sidenav.blade.php ENDPATH**/ ?>