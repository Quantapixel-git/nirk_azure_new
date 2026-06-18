

<?php $__env->startSection('content'); ?>
    <section class="pb-4 pt-5">
        <div class="container">
            <div class="row gutters-16">
                <!-- Contents -->
                <div class="col-xl-9 order-xl-1">
                    <!-- Breadcrumb -->
                    <div class="row gutters-16 mb-4">
                        <div class="col-5 col-xl-6">
                            <h1 class="fw-700 fs-20 fs-md-24 text-dark mb-0"><?php echo e(translate('Blogs')); ?></h1>
                        </div>
                        <div class="col-5 col-xl-6">
                            <ul class="breadcrumb bg-transparent p-0 justify-content-end">
                                <li class="breadcrumb-item has-transition opacity-60 hov-opacity-100">
                                    <a class="text-reset" href="<?php echo e(route('home')); ?>">
                                        <?php echo e(translate('Home')); ?>

                                    </a>
                                </li>
                                <li class="text-dark fw-600 breadcrumb-item">
                                    "<?php echo e(translate('Blog')); ?>"
                                </li>
                            </ul>
                        </div>
                        <div class="col d-xl-none mb-lg-3 text-right">
                            <button type="button" class="btn btn-icon p-0 active" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                <i class="la la-filter la-2x"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Blogs -->
                    <div class="blog card-columns">
                        <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-4 overflow-hidden shadow-none border rounded-0 hov-scale-img p-3">
                                <a href="<?php echo e(url("blog").'/'. $blog->slug); ?>" class="text-reset d-block overflow-hidden h-180px">
                                    <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                        data-src="<?php echo e(uploaded_asset($blog->banner)); ?>"
                                        alt="<?php echo e($blog->title); ?>"
                                        class="img-fit lazyload h-100 has-transition">
                                </a>
                                <div class="py-3">
                                    <h2 class="fs-16 fw-700 mb-3 h-35px text-truncate-2">
                                        <a href="<?php echo e(url("blog").'/'. $blog->slug); ?>" class="text-reset hov-text-primary" title="<?php echo e($blog->title); ?>">
                                            <?php echo e($blog->title); ?>

                                        </a>
                                    </h2>
                                    <p class="opacity-70 mb-3 h-60px text-truncate-3" title="<?php echo e($blog->short_description); ?>">
                                        <?php echo e($blog->short_description); ?>

                                    </p>
                                    <div>
                                        <small class="fs-12 fw-400 opacity-60"><?php echo e(date('M d, Y',strtotime($blog->created_at))); ?></small>
                                    </div>
                                    <?php if($blog->category != null): ?>
                                        <div>
                                            <small class="fs-12 fw-400 text-blue"><?php echo e($blog->category->category_name); ?></small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-3 text-primary">
                                        <a href="<?php echo e(url("blog").'/'. $blog->slug); ?>" class="fs-14 fw-700 text-primary has-transition d-flex align-items-center hov-column-gap-1">
                                            <?php echo e(translate('Read Full Blog')); ?>

                                            <i class="las las-2x la-arrow-right fs-24 ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                    <!-- Pagination -->
                    <div class="aiz-pagination mt-4">
                        <?php echo e($blogs->links()); ?>

                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-xl-3">
                    <!-- Filters -->
                    <form class="mb-4" id="search-form" action="" method="GET">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left" style="overflow-y: auto;">
                                <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                    <h3 class="h6 mb-0 fw-600"><?php echo e(translate('Filters')); ?></h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div>
                                <!-- Search -->
                                <div class="mb-4 mt-3 px-3 mt-xl-0 px-xl-0">
                                    <div class="input-group w-100">
                                        <input type="text" class="border border-right-0 rounded-0 fs-14 flex-grow-1" name="search" value="<?php echo e($search); ?>" placeholder="<?php echo e(translate('Search...')); ?>" autocomplete="off" style="padding: 14px;">
                                        <div class="input-group-append">
                                            <button class="btn bg-transparent hov-bg-light rounded-0 border border-left-0" type="submit" style="">
                                                <i class="la la-search la-flip-horizontal fs-18 text-gray"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Categories -->
                                <div class="bg-white border mb-3 mx-3 mx-xl-0">
                                    <div class="fs-16 fw-700 p-3"><?php echo e(translate('Categories')); ?></div>
                                    <div class="p-3 aiz-checkbox-list">
                                        <?php $__currentLoopData = get_all_blog_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="aiz-checkbox mb-3">
                                            <input
                                                type="checkbox"
                                                name="selected_categories[]"
                                                value="<?php echo e($category->slug); ?>" <?php if(in_array($category->slug, $selected_categories)): ?> checked <?php endif; ?>
                                                onchange="filter()"
                                            >
                                            <span class="aiz-square-check"></span>
                                            <span class="fs-14 fw-400 text-dark has-transition hov-text-primary"><?php echo e($category->category_name); ?></span>
                                        </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </form>

                    <!-- recent posts -->
                    <div class="p-3 border">
                        <h3 class="fs-16 fw-700 text-dark mb-3"><?php echo e(translate('Recent Posts')); ?></h3>
                        <div class="row">
                            <?php $__currentLoopData = $recent_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent_blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xl-12 col-lg-4 col-sm-6 mb-4 hov-scale-img">
                                <div class="d-flex">
                                    <div class="">
                                        <a href="<?php echo e(url("blog").'/'. $recent_blog->slug); ?>" class="text-reset d-block overflow-hidden size-80px size-xl-90px mr-2">
                                            <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                                                data-src="<?php echo e(uploaded_asset($recent_blog->banner)); ?>"
                                                alt="<?php echo e($recent_blog->title); ?>"
                                                class="img-fit lazyload h-100 has-transition">
                                        </a>
                                    </div>
                                    <div class="">
                                        <h2 class="fs-14 fw-700 mb-2 mb-xl-3 h-35px text-truncate-2">
                                            <a href="<?php echo e(url("blog").'/'. $recent_blog->slug); ?>" class="text-reset hov-text-primary" title="<?php echo e($recent_blog->title); ?>">
                                                <?php echo e($recent_blog->title); ?>

                                            </a>
                                        </h2>
                                        <div>
                                            <small class="fs-12 fw-400 opacity-60"><?php echo e(date('M d, Y',strtotime($recent_blog->created_at))); ?></small>
                                        </div>
                                        <?php if($recent_blog->category != null): ?>
                                            <div>
                                                <small class="fs-12 fw-400 text-blue"><?php echo e($recent_blog->category->category_name); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/blog/listing.blade.php ENDPATH**/ ?>