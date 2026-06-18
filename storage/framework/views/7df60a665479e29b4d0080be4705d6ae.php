<div class="row gutters-16">
    <?php
    $physical = false;
    $col_val = 'col-12';
    foreach ($products as $key => $cartItem){
    $product = get_single_product($cartItem);
    if ($product->digital == 0) {
    $physical = true;
    $col_val = 'col-md-6';
    }
    }
    ?>
    <!-- Product List -->
    <div class="<?php echo e($col_val); ?>">
        <ul class="list-group list-group-flush mb-3">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $product = get_single_product($cartItem);
            ?>
            <li class="list-group-item pl-0 py-3 border-0">
                <div class="d-flex align-items-center">
                    <span class="mr-2 mr-md-3">
                        <img src="<?php echo e(get_image($product->thumbnail)); ?>"
                            class="img-fit size-60px"
                            alt="<?php echo e($product->getTranslation('name')); ?>"
                            onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">
                    </span>
                    <span class="fs-14 fw-400 text-dark">
                        <span class="text-truncate-2"><?php echo e($product->getTranslation('name')); ?></span>
                        <?php if($product_variation[$key] != ''): ?>
                        <span class="fs-12 text-secondary"><?php echo e(translate('Variation')); ?>: <?php echo e($product_variation[$key]); ?></span>
                        <?php endif; ?>
                    </span>
                </div>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <?php if($physical): ?>
    <!-- Choose Delivery Type -->
    <div class="col-md-6 mb-2">
        <h6 class="fs-14 fw-700 mt-3"><?php echo e(translate('Choose Delivery Type')); ?></h6>
        <div class="row gutters-16">
            <!-- Home Delivery -->
            <?php if(get_setting('shipping_type') != 'carrier_wise_shipping'): ?>
            <div class="col-6">
                <label class="aiz-megabox d-block bg-white mb-0">
                    <input
                        type="radio"
                        name="shipping_type_<?php echo e($owner_id); ?>"
                        value="home_delivery"
                        onchange="show_pickup_point(this, <?php echo e($owner_id); ?>)"
                        data-target=".pickup_point_id_<?php echo e($owner_id); ?>"
                        checked required>
                    <span class="d-flex aiz-megabox-elem rounded-0" style="padding: 0.75rem 1.2rem;">
                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                        <span class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Home Delivery')); ?></span>
                    </span>
                </label>
            </div>
            <!-- Carrier -->
            <?php else: ?>
            <div class="col-6">
                <label class="aiz-megabox d-block bg-white mb-0">
                    <input
                        type="radio"
                        name="shipping_type_<?php echo e($owner_id); ?>"
                        value="carrier"
                        class="shipping-type-radio"
                        data-owner="<?php echo e($owner_id); ?>"
                        onchange="show_pickup_point(this, <?php echo e($owner_id); ?>)"
                        data-target=".pickup_point_id_<?php echo e($owner_id); ?>"
                        checked required>
                    <span class="d-flex aiz-megabox-elem rounded-0" style="padding: 0.75rem 1.2rem;">
                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                        <span class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Carrier')); ?></span>
                    </span>
                </label>
            </div>
            <?php endif; ?>
            <!-- Local Pickup -->
            <?php if($pickup_point_list): ?>
            <div class="col-6">
                <label class="aiz-megabox d-block bg-white mb-0">
                    <input
                        type="radio"
                        name="shipping_type_<?php echo e($owner_id); ?>"
                        value="pickup_point"
                        class="shipping-type-radio"
                        data-owner="<?php echo e($owner_id); ?>"
                        onchange="show_pickup_point(this, <?php echo e($owner_id); ?>)"
                        data-target=".pickup_point_id_<?php echo e($owner_id); ?>"
                        required>
                    <span class="d-flex aiz-megabox-elem rounded-0" style="padding: 0.75rem 1.2rem;">
                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                        <span class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Local Pickup')); ?></span>
                    </span>
                </label>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pickup Point List -->
        <?php if($pickup_point_list): ?>
        <div class="mt-3 pickup_point_id_<?php echo e($owner_id); ?> d-none">
            <select
                class="form-control aiz-selectpicker rounded-0"
                name="pickup_point_id_<?php echo e($owner_id); ?>"
                data-live-search="true"
                onchange="updateDeliveryInfo('pickup_point', this.value, <?php echo e($owner_id); ?>)">
                <option value=""><?php echo e(translate('Select your nearest pickup point')); ?></option>
                <?php $__currentLoopData = $pickup_point_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pick_up_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option
                    value="<?php echo e($pick_up_point->id); ?>"
                    data-content="<span class='d-block'>
                                                <span class='d-block fs-16 fw-600 mb-2'><?php echo e($pick_up_point->getTranslation('name')); ?></span>
                                                <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> <?php echo e($pick_up_point->getTranslation('address')); ?></span>
                                                <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i><?php echo e($pick_up_point->phone); ?></span>
                                            </span>">
                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php endif; ?>

        <!-- Carrier Wise Shipping -->
        <?php if(get_setting('shipping_type') == 'carrier_wise_shipping'): ?>

        <div class="row pt-3 carrier_id_<?php echo e($owner_id); ?>">
            <?php if($carrier_list->isEmpty()): ?>

            <div class="col-md-12">
                <div class="alert alert-danger col-md-12 mb-2">
                    <strong><?php echo e(translate('Shipping is not available to your selected address.')); ?></strong><br>
                    <?php echo e(translate('Please choose a different address.')); ?>

                </div>
                <span class="shipping-unavailable-flag" style="display: none;"></span>
            </div>


            <?php else: ?>
            <?php $__currentLoopData = $carrier_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carrier_key => $carrier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 mb-2">
                <label class="aiz-megabox d-block bg-white mb-0">
                    <input
                        type="radio"
                        name="carrier_id_<?php echo e($owner_id); ?>"
                        value="<?php echo e($carrier->id); ?>"
                        <?php if($carrier_key==0): ?> checked <?php endif; ?>
                        onchange="updateDeliveryInfo('carrier', <?php echo e($carrier->id); ?>, <?php echo e($owner_id); ?>)">
                    <span class="d-flex flex-wrap p-3 aiz-megabox-elem rounded-0">
                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                        <span class="flex-grow-1 pl-3 fw-600">
                            <img src="<?php echo e(uploaded_asset($carrier->logo)); ?>" alt="Image" class="w-50px img-fit">
                        </span>
                        <span class="flex-grow-1 pl-3 fw-700"><?php echo e($carrier->name); ?></span>
                        <span class="flex-grow-1 pl-3 fw-600"><?php echo e(translate('Transit in').' '.$carrier->transit_time); ?></span>
                        <span class="flex-grow-1 pl-4 pl-sm-3 fw-600 mt-2 mt-sm-0 text-sm-right"><?php echo e(single_price(carrier_base_price($carts, $carrier->id, $owner_id, $shipping_info))); ?></span>
                    </span>
                </label>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        <?php endif; ?>
    </div>
    <?php endif; ?>
</div><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/partials/cart/delivery_info_details.blade.php ENDPATH**/ ?>