 <!-- Featured Products -->

<?php if(count(get_featured_products()) > 0): ?>
<section class="mb-2 mb-md-2 mt-2 mt-xl-4 pr-0 pr-lg-2">
    <div class="container p-3 rounded-75" style="background: <?php echo e(get_setting('featured_section_bg_color') != null ?  get_setting('featured_section_bg_color') : '#ffffff'); ?>">
        <!-- Top Section -->
        <div class="d-flex mb-1 align-items-baseline justify-content-between">
            <!-- Title -->
            <h3 class="fs-16 fw-700 mb-2 mb-sm-0">
                <span class=""><?php echo e(translate('Featured Products')); ?></span>
            </h3>
            <!-- Links -->
            <a type="button" class="arrow-next text-white bg-dark view-more-slide-btn d-flex align-items-center" href="<?php echo e(route('featured-products')); ?>">
                <span><i class="las la-angle-right fs-20 fw-600"></i></span>
                <span class="fs-12 mr-2 text">View All</span>
            </a>
        </div>
        
        <div class="aiz-carousel  arrow-inactive-transparent arrow-x-0 mt-2 carousel-arrow"
            data-rows="1" data-items="3" data-xxl-items="3" data-xl-items="3" data-lg-items="3"
            data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows="false" data-dots="false" data-autoplay="false" data-infinite="true">
        
            <?php $__currentLoopData = get_featured_products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-box mt-1 mb-1">
                    <div class="d-flex align-items-center rounded-2">
                        <!-- Image -->
                        <div class="me-3">
                            <div class="img h-70px w-70px h-sm-80px w-sm-80px overflow-hidden the-core-img position-relative image-hover-effect">
                                <a href="<?php echo e(route('product', $product->slug)); ?>" title="<?php echo e($product->getTranslation('name')); ?>">
                                    <img class="lazyload img-fit rounded-2 m-auto has-transition product-main-image"
                                        src="<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>"
                                        data-src="<?php echo e(get_image($product->thumbnail)); ?>"
                                        alt="<?php echo e($product->getTranslation('name')); ?>"
                                        onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">

                                    <img class="lazyload img-fit m-auto rounded-2 has-transition product-main-image product-hover-image position-absolute"
                                        src="<?php echo e(get_first_product_image($product->thumbnail, $product->photos)); ?>"
                                        alt="<?php echo e($product->getTranslation('name')); ?>"
                                        title="<?php echo e($product->getTranslation('name')); ?>"
                                        onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">
                                </a>
                            </div>
                        </div>

                        <!-- Text (Name + Price) -->
                        <div class="flex-grow-1 h-80px">
                            
                            <!-- Name -->
                            <a href="<?php echo e(route('product', $product->slug)); ?>" class="text-reset ">
                                <div class="fs-13 text-start px-2" title="<?php echo e($product->getTranslation('name')); ?>">
                                    <span class="fw-400 text-truncate-2 hov-text-primary lh-1-4 h-35px">
                                        <?php echo e($product->getTranslation('name')); ?>

                                    </span>
                                </div>

                                <!-- Price -->
                                <div class="fs-14 mt-1 text-start px-2">
                                    <span class="d-block fw-700"><?php echo e(home_discounted_base_price($product)); ?></span>
                                    <?php if(home_base_price($product) != home_discounted_base_price($product)): ?>
                                        <del class="d-block text-secondary fs-12 fw-400"><?php echo e(home_base_price($product)); ?></del>
                                    <?php endif; ?>
                                </div>
                            </a>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/thecore/partials/featured_products.blade.php ENDPATH**/ ?>