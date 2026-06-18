<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Nav Tabs Start -->
    <div class="mb-1 mb-md-3">
        <ul class="nav nav-tabs border-0" id="shippingTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active border-0 fs-14 fw-bold text-gray hov-text-dark has-transition px-0 py-1 mr-4 mr-xl-5"
                    id="home-tab" data-toggle="tab" href="#shipping-address" role="tab"
                    aria-controls="ShippingAddress" aria-selected="true"><?php echo e(translate('Shipping Address')); ?></a>
            </li>
            <?php if(get_setting('billing_address_required')): ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link border-0 fs-14 fw-bold text-gray hov-text-dark has-transition px-0 py-1"
                    id="profile-tab" data-toggle="tab" href="#billing-address" role="tab"
                    aria-controls="BillingAddress" aria-selected="false"><?php echo e(translate('Billing Address')); ?></a>
            </li>
            <?php endif; ?>
        </ul>

        
    </div>
    <!-- Nav Tabs End -->

<?php if(Auth::check()): ?>

    <div class="tab-content" id="shippingTabContent">
        <!--Shipping Address-->
        <div class="tab-pane fade show active" id="shipping-address" role="tabpanel"
            aria-labelledby="shipping-address-tab">
            <div class="d-flex justify-content-end choose-address">
                <button type="button" class="px-0 py-1 border-0 bg-white fs-12 fw-bold text-blue" data-toggle="modal"
                    data-target="#choose-address-modal"><?php echo e(translate('Choose Another
                    Address')); ?></button>
            </div>
            <!-- Single Start -->
            <div class="mb-2 mt-2 mt-md-3">
                <?php
                $address = Auth::user()->addresses()->where('id', $address_id)->first();
                if($address){
                $city = optional($address->city);
                $area_id = $address->area_id;

                $has_area_id = !is_null($area_id);
                $city_status = $city->status;
                $active_area_exists = $city->areas()->where('status', 1)->exists(); 
                $area_status = $has_area_id ? optional($address->area)->status : 1;
                $is_disabled =
                    $city_status === 0 ||
                    ($has_area_id && $area_status === 0) ||
                    ($active_area_exists && !$has_area_id) ||
                    ($address->state_id == null && get_setting('has_state') == 1);
                }
                ?>

                <?php if($address): ?>
                <div class="border <?php echo e($is_disabled ? ' border-danger' : ''); ?> mb-3" id="default-address-box">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="aiz-megabox d-block bg-white mb-0">
                                <input type="radio" name="single_address_id" value="<?php echo e($address->id); ?>" <?php echo e($address->id == $address_id && !$is_disabled ? 'checked' : ''); ?>

                                             <?php echo e($is_disabled ? 'disabled' : ''); ?>>
                                <span class="d-flex p-3 aiz-megabox-elem border-0">
                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                    <span class="pl-3 text-left w-xl-300px"  id="choose-default">
                                        <?php echo e($address->address); ?>, <?php echo e($address->area ? $address->area->name . ',' : ''); ?> <?php echo e($address->postal_code); ?>-<?php echo e($address->city->name); ?>,<?php echo e($address->state && $address->state->status == 1 ? $address->state->name . ',' : ''); ?> <?php echo e(optional($address->country)->name); ?>

                                        <br>  <?php echo e($address->phone); ?>

                                    </span>
                                </span>
                            </label>
                        </div>
                        <!-- Always show Change button -->
                        <div class="col-md-4 p-3 text-right">
                            <a id="default-address-change-btn" class="btn btn-sm btn-secondary-base text-white mr-3 rounded-pill px-4"
                                onclick="edit_address('<?php echo e($address->id); ?>')">
                                <?php echo e(translate('Change')); ?>

                            </a>
                        </div>

                        <?php if($is_disabled): ?>
                        <div class="col-md-12" id="hide-no-longer-div">
                            <div class="text-center text-danger">
                                <span><?php echo e(translate('We no longer deliver in this area.')); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <input type="hidden" name="checkout_type" value="logged">

                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <?php if($address): ?>
                    <div class="form-group form-check px-0 py-1 m-0">
                        <label class="aiz-checkbox m-0">
                            <input type="radio" data-type="shipping" name="billing_address_id" value="" required>
                            <span class="fs-14 fw-300 text-reset"><?php echo e(translate('Use this as billing address')); ?></span>
                            <span class="aiz-square-check"></span>
                        </label>
                    </div>
                    <?php endif; ?>
                    <!-- Add New Address -->
                    <div class="py-1">
                        <div class="border c-pointer text-center py-2 px-3 bg-soft-blue has-transition d-flex justify-content-center rounded-pill"
                            onclick="add_new_address()">
                            <i class="las la-plus fs-20 fw-bold text-blue"></i>
                            <div class="alpha-7 fs-14 text-blue fw-700 ml-2"><?php echo e(translate('Add New Address')); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single End -->
        </div>
        <!--Shipping End-->

        <?php if(get_setting('billing_address_required')): ?>
        <!--Billing Address Start-->
        <div class="tab-pane fade" id="billing-address" role="tabpanel" aria-labelledby="billing-address-tab">
             <div class="d-flex justify-content-end choose-address">
                <button type="button" class="px-0 py-1 border-0 bg-white fs-12 fw-bold text-blue" data-toggle="modal"
                    data-target="#choose-billing-address-modal"><?php echo e(translate('Choose Another Billing Address')); ?></button>
            </div>
            <div class="mb-2 mt-2 mt-md-3">
                <?php
                $address = Auth::user()->addresses()->where('set_billing', 1)->first();
                
                if($address){
                $city = optional($address->city);
                $area_id = $address->area_id;

                $has_area_id = !is_null($area_id);
                $city_status = $city->status;
                $active_area_exists = $city->areas()->where('status', 1)->exists(); 
                $area_status = $has_area_id ? optional($address->area)->status : 1;
                
                $is_disabled =
                    $city_status === 0 ||
                    ($has_area_id && $area_status === 0) ||
                    ($active_area_exists && !$has_area_id) ||
                    ($address->state_id == null && get_setting('has_state') == 1);
                }
                ?>
                <?php if($address): ?>
                <div class="border <?php echo e($is_disabled ? ' border-danger' : ''); ?> mb-3" id="default-billing-address-box">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="aiz-megabox d-block bg-white mb-0">
                                <input type="radio" name="single_billing_address_id" data-type="billing" value="<?php echo e($address->id); ?>" checked <?php echo e($is_disabled ? 'disabled' : ''); ?> required >
                                <span class="d-flex p-3 aiz-megabox-elem border-0">
                                    <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                    <span class="pl-3 text-left w-xl-300px" id="choose-default-billing">
                                        <?php echo e($address->address); ?>, <?php echo e($address->area ? $address->area->name . ',' : ''); ?> <?php echo e($address->postal_code); ?>-<?php echo e($address->city->name); ?>,<?php echo e($address->state && $address->state->status == 1 ? $address->state->name . ',' : ''); ?> <?php echo e(optional($address->country)->name); ?>

                                        <br>  <?php echo e($address->phone); ?>

                                    </span>
                                </span>
                            </label>
                        </div>
                        <!-- Always show Change button -->
                        <div class="col-md-4 p-3 text-right">
                            <a id="billing-address-change-btn" class="btn btn-sm btn-secondary-base text-white mr-3 rounded-pill px-4"
                                onclick="edit_billing_address('<?php echo e($address->id); ?>')">
                                <?php echo e(translate('Change')); ?>

                            </a>
                        </div>

                        <?php if($is_disabled): ?>
                        <div class="col-md-12" id="hide-no-valid-div">
                            <div class="text-center text-danger">
                                <span><?php echo e(translate('Address Not Valid, Choose Another')); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <!-- Add New Address -->
                    <div class="py-1">
                        <div class="border c-pointer text-center py-2 px-3 bg-soft-blue has-transition d-flex justify-content-center rounded-pill"
                            onclick="add_new_billing_address()">
                            <i class="las la-plus fs-20 fw-bold text-blue"></i>
                            <div class="alpha-7 fs-14 text-blue fw-700 ml-2"><?php echo e(translate('Add New Billing Address')); ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!--Billing Address End-->
        <?php endif; ?>
    </div>


    <!--Modal Start -->
    <div class="modal fade" id="choose-address-modal" tabindex="-1" aria-labelledby="chooseAddressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chooseAddressModalLabel">Choose Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Single Start -->
                    <div>
                        <?php $__currentLoopData = Auth::user()->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $city = optional($address->city);
                            $area_id = $address->area_id;

                            $has_area_id = !is_null($area_id);
                            $city_status = $city->status;
                            $active_area_exists = $city->areas()->where('status', 1)->exists(); // new line
                            $area_status = $has_area_id ? optional($address->area)->status : 1;
                            $is_disabled =
                                $city_status === 0 ||
                                ($has_area_id && $area_status === 0) ||
                                ($active_area_exists && !$has_area_id) ||
                                ($address->state_id == null && get_setting('has_state') == 1);
                        ?>
                        <div class="border <?php echo e($is_disabled ? 'border-danger' : ''); ?> mb-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="aiz-megabox d-block bg-white mb-0">
                                        <input type="radio" name="address_id" value="<?php echo e($address->id); ?>" <?php echo e($address->id == $address_id && !$is_disabled ? 'checked' : ''); ?>

                                             <?php echo e($is_disabled ? 'disabled' : ''); ?> required>
                                        <span class="d-flex p-3 aiz-megabox-elem border-0">
                                            <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                            <span class="pl-3 text-left w-xl-300px address-text">
                                                <?php echo e($address->address); ?>, <?php echo e($address->area ? $address->area->name . ',' : ''); ?> <?php echo e($address->postal_code); ?>-<?php echo e($address->city->name); ?>,<?php echo e($address->state && $address->state->status == 1 ? $address->state->name . ',' : ''); ?> <?php echo e(optional($address->country)->name); ?>

                                              <br>  <?php echo e($address->phone); ?>

                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <!-- Always show Change button -->
                                <div class="col-md-4 p-3 text-right">
                                    <a class="btn btn-sm btn-secondary-base text-white mr-4 rounded-pill px-4"
                                        onclick="edit_address('<?php echo e($address->id); ?>')">
                                        <?php echo e(translate('Change')); ?>

                                    </a>
                                </div>
                                <?php if($is_disabled): ?>
                                <div class="col-md-12">
                                    <div class="text-center text-danger">
                                        <span><?php echo e(translate('We no longer deliver in this area.')); ?></span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="checkout_type" value="logged">

                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            
                            <!-- Add New Address Button -->
                            <div class="py-1">
                                <div class="border c-pointer text-center py-2 px-3 bg-soft-blue has-transition d-flex justify-content-center rounded-pill"
                                    onclick="add_new_address()">
                                    <i class="las la-plus fs-20 fw-bold text-blue"></i>
                                    <div class="alpha-7 fs-14 text-blue fw-700 ml-2"><?php echo e(translate('Add New Address')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary rounded-0" onclick="changeShippingAddress()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="choose-billing-address-modal" tabindex="-1" aria-labelledby="chooseAddressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chooseAddressModalLabel"><?php echo e(translate('Choose Billing Address')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Single Start -->
                    <div>
                        <?php $__currentLoopData = Auth::user()->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $city = optional($address->city);
                            $area_id = $address->area_id;

                            $has_area_id = !is_null($area_id);
                            $city_status = $city->status;
                            $active_area_exists = $city->areas()->where('status', 1)->exists(); // new line
                            $area_status = $has_area_id ? optional($address->area)->status : 1;
                            $is_disabled =
                                $city_status === 0 ||
                                ($has_area_id && $area_status === 0) ||
                                ($active_area_exists && !$has_area_id) ||
                                ($address->state_id == null && get_setting('has_state') == 1);
                        ?>
                        <div class="border <?php echo e($is_disabled ? 'border-danger' : ''); ?> mb-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="aiz-megabox d-block bg-white mb-0">
                                        <input type="radio" name="billing_address_id" data-type="billing" value="<?php echo e($address->id); ?>" <?php echo e($address->set_billing == 1 ? 'checked' : ''); ?>

                                                <?php echo e($is_disabled ? 'disabled' : ''); ?> required>
                                        <span class="d-flex p-3 aiz-megabox-elem border-0">
                                            <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                            <span class="pl-3 text-left w-xl-300px address-text">
                                                <?php echo e($address->address); ?>, <?php echo e($address->area ? $address->area->name . ',' : ''); ?> <?php echo e($address->postal_code); ?>-<?php echo e($address->city->name); ?>,<?php echo e($address->state && $address->state->status == 1 ? $address->state->name . ',' : ''); ?> <?php echo e(optional($address->country)->name); ?>

                                                <br>  <?php echo e($address->phone); ?>

                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <!-- Always show Change button -->
                                <div class="col-md-4 p-3 text-right">
                                    <a class="btn btn-sm btn-secondary-base text-white mr-4 rounded-pill px-4"
                                        onclick="edit_billing_address('<?php echo e($address->id); ?>')">
                                        <?php echo e(translate('Change')); ?>

                                    </a>
                                </div>
                                <?php if($is_disabled): ?>
                                <div class="col-md-12">
                                    <div class="text-center text-danger">
                                        <span><?php echo e(translate('Address is not Valid')); ?></span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="checkout_type" value="logged">

                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            
                            <!-- Add New Address Button -->
                            <div class="py-1">
                                <div class="border c-pointer text-center py-2 px-3 bg-soft-blue has-transition d-flex justify-content-center rounded-pill"
                                    onclick="add_new_address()">
                                    <i class="las la-plus fs-20 fw-bold text-blue"></i>
                                    <div class="alpha-7 fs-14 text-blue fw-700 ml-2"><?php echo e(translate('Add New Address')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary rounded-0 close" data-dismiss="modal" aria-label="Close">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    
    
    <!--Modal End -->
<?php else: ?>
    <!-- Guest Shipping a address -->
    <?php echo $__env->make('frontend.partials.cart.guest_shipping_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/partials/cart/shipping_info.blade.php ENDPATH**/ ?>