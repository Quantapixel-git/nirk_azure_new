<?php if(count($newest_products) > 0): ?>
<section class="py-0">
    <div class="container">
        <div class="row px-3" id="newest-products-list">
            <?php $__currentLoopData = $newest_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $new_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 col-lg-3 col-xl-2 col-sm-4 col-6 d-flex product-card hov-animate-outline-2 d-flex justify-content-center mx-auto">
                    <div class="carousel-box has-transition rounded-2">
                        <?php echo $__env->make('frontend.'.get_setting('homepage_select').'.partials.home_product_box', ['product' => $new_product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/thecore/partials/newest_products_section.blade.php ENDPATH**/ ?>