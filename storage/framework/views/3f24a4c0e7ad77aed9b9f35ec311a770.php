

<?php if(count($todays_deal_products) > 0): ?>
    <!-- Top Section -->
<div class="border border-2 border-dark rounded-2 h-100">
    <div class="d-flex m-3 align-items-baseline justify-content-between">
            <!-- Title -->
            <h3 class="fs-14 fs-md-16 fw-500 mb-2 mb-sm-0">
                <span class=""><?php echo e(translate('Todays Deal')); ?></span>
            </h3>
            <!-- Links -->
            <a type="button" class="arrow-next text-white bg-dark view-more-slide-btn d-flex align-items-center" href="<?php echo e(route('todays-deal')); ?>">
                <span><i class="las la-angle-right fs-20 fw-600"></i></span>
                <span class="fs-12 mr-2 text">View All</span>
            </a>
        </div>  
        
        <div class="aiz-carousel  arrow-inactive-transparent arrow-x-0 mt-2 carousel-arrow"
                data-rows="1" data-items="1" data-xxl-items="1" data-xl-items="1" data-lg-items="1"
                data-md-items="1" data-sm-items="1" data-xs-items="1" data-arrows="true" data-dots="false" data-autoplay="true" data-infinite="true">
            
            <?php $__currentLoopData = $todays_deal_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="carousel-box mt-3 mb-1">
                
                <div class="img h-120px w-120px h-md-180px w-md-180px rounded overflow-hidden mx-auto the-core-img position-relative image-hover-effect">
                    <a href="<?php echo e(route('product', $product->slug)); ?>" title="<?php echo e($product->getTranslation('name')); ?>">
                        <img class="lazyload img-fit m-auto has-transition product-main-image"
                        src="<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>"
                        data-src="<?php echo e(get_image($product->thumbnail)); ?>"
                        alt="<?php echo e($product->getTranslation('name')); ?>"
                        onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">

                        <img
                        class="lazyload img-fit m-auto has-transition product-main-image product-hover-image position-absolute"
                        src="<?php echo e(get_first_product_image($product->thumbnail, $product->photos)); ?>"
                        alt="<?php echo e($product->getTranslation('name')); ?>"
                        title="<?php echo e($product->getTranslation('name')); ?>"
                        onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">
                    </a>
                </div>

                <!-- Name -->
                <div class="fs-13 mr-1 mt-3 text-center mt-2 px-4" title="<?php echo e($product->getTranslation('name')); ?>">
                    <span
                        class="fw-300 text-truncate-1"> <?php echo e($product->getTranslation('name')); ?></span>
                </div>

                <!-- Price -->
                <div class="fs-14 mr-1 mt-3 text-center">
                    <span class="d-block fw-700"><?php echo e(home_discounted_base_price($product)); ?></span>
                    <?php if(home_base_price($product) != home_discounted_base_price($product)): ?>
                        <del
                            class="d-block text-secondary fs-12 fw-400"><?php echo e(home_base_price($product)); ?></del>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
</div>
    

<?php endif; ?>
<?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/thecore/partials/todays_deal.blade.php ENDPATH**/ ?>