

<?php $__env->startSection('meta_title'); ?><?php echo e($blog->meta_title); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta_description'); ?><?php echo e($blog->meta_description); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta_keywords'); ?><?php echo e($blog->meta_keywords); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?php echo e($blog->meta_title); ?>">
    <meta itemprop="description" content="<?php echo e($blog->meta_description); ?>">
    <meta itemprop="image" content="<?php echo e(uploaded_asset($blog->meta_img)); ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="<?php echo e($blog->meta_title); ?>">
    <meta name="twitter:description" content="<?php echo e($blog->meta_description); ?>">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="<?php echo e(uploaded_asset($blog->meta_img)); ?>">

    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo e($blog->meta_title); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo e(route('blog.details', $blog->slug)); ?>" />
    <meta property="og:image" content="<?php echo e(uploaded_asset($blog->meta_img)); ?>" />
    <meta property="og:description" content="<?php echo e($blog->meta_description); ?>" />
    <meta property="og:site_name" content="<?php echo e(env('APP_NAME')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="py-4">
    <div class="container">
        <div class="row gutters-16 justify-content-center">

            <!-- Blog Details -->
            <div class="col-xxl-7 col-lg-8">
                <div class="mb-4">
                    <!-- Title -->
                    <h2 class="fs-20 fs-md-24 fw-700 mb-3">
                        <a href="<?php echo e(url("blog").'/'. $blog->slug); ?>" class="text-reset hov-text-primary" title="<?php echo e($blog->title); ?>">
                            <?php echo e($blog->title); ?>

                        </a>
                    </h2>
                    <div class="row">
                        <div class="col-4">
                            <!-- Date -->
                            <div>
                                <small class="fs-12 fw-400 opacity-60"><?php echo e(date('M d, Y',strtotime($blog->created_at))); ?></small>
                            </div>
                            <!-- Caregory -->
                            <?php if($blog->category != null): ?>
                                <div>
                                    <small class="fs-12 fw-400 text-blue"><?php echo e($blog->category->category_name); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Share -->
                        <div class="col-8 text-right">
                            <div class="aiz-share"></div>
                        </div>
                    </div>
                    <!-- Image -->
                    <img src="<?php echo e(static_asset('assets/img/placeholder-rect.jpg')); ?>"
                        data-src="<?php echo e(uploaded_asset($blog->banner)); ?>"
                        alt="<?php echo e($blog->title); ?>"
                        class="img-fluid lazyload w-100 mt-3 mb-4">
                    <!-- Description -->
                    <div class="mb-4 overflow-hidden">
                        <?php echo $blog->description; ?>

                    </div>
                    <!-- Facebook Comment -->
                    <?php if(get_setting('facebook_comment') == 1): ?>
                    <div class="mb-4">
                        <div class="fb-comments" data-href="<?php echo e(route("blog",$blog->slug)); ?>" data-width="" data-numposts="5"></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <!-- recent posts -->
            <div class="col-xxl-3 col-lg-4">
                <div class="p-3 border">
                    <h3 class="fs-16 fw-700 text-dark mb-3"><?php echo e(translate('Recent Posts')); ?></h3>
                    <div class="row">
                        <?php $__currentLoopData = $recent_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent_blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-12 col-sm-6 mb-4 hov-scale-img">
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
    <?php if(get_setting('facebook_comment') == 1): ?>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId=<?php echo e(env('FACEBOOK_APP_ID')); ?>&autoLogAppEvents=1" nonce="ji6tXwgZ"></script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/blog/details.blade.php ENDPATH**/ ?>