<div class="container">
    <?php
        $cart_count = count($carts);
        $active_carts = $cart_count > 0 ? $carts->toQuery()->active()->get() : [];
    ?>
    <?php if( $cart_count > 0 ): ?>
        <div class="row">
            <div class="col-lg-8">
                <?php if(auth()->check()): ?>
                    <?php
                        $welcomeCoupon = ifUserHasWelcomeCouponAndNotUsed();
                    ?>
                    <?php if($welcomeCoupon): ?>
                        <div class="alert alert-primary align-items-center border d-flex flex-wrap justify-content-between rounded-0" style="border-color: #3490F3 !important;">
                            <?php
                                $discount = $welcomeCoupon->discount_type == 'amount' ? single_price($welcomeCoupon->discount) : $welcomeCoupon->discount.'%';
                            ?>
                            <div class="fw-400 fs-14" style="color: #3490F3 !important;">
                                <?php echo e(translate('Welcome Coupon')); ?> <strong><?php echo e($discount); ?></strong> <?php echo e(translate('Discount on your Purchase Within')); ?> <strong><?php echo e($welcomeCoupon->validation_days); ?></strong> <?php echo e(translate('days of Registration')); ?>

                            </div>
                            <button class="btn btn-sm mt-3 mt-lg-0 rounded-4" onclick="copyCouponCode('<?php echo e($welcomeCoupon->coupon_code); ?>')" style="background-color: #3490F3; color: white;" ><?php echo e(translate('Copy coupon Code')); ?></button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="bg-white p-3 p-lg-4 text-left">
                    <div class="mb-4">
                        <div class="form-group mb-2 border-bottom">
                            <div class="aiz-checkbox-inline mb-3">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" class="check-all" <?php if(count($active_carts) == $cart_count): ?> checked <?php endif; ?>>
                                    <span class="fs-14 text-secondary ml-3"><?php echo e(translate('Select All')); ?> (<?php echo e($cart_count); ?>)</span>
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                        </div>
                        <!-- Cart Items -->
                        <ul class="list-group list-group-flush">
                        <?php
                            $total = 0;
                            $admin_products = array();
                            $seller_products = array();
                            $admin_product_variation = array();
                            $seller_product_variation = array();
                            foreach ($carts as $key => $cartItem){
                                $product = get_single_product($cartItem['product_id']);

                                if($product->added_by == 'admin'){
                                    array_push($admin_products, $cartItem['product_id']);
                                    $admin_product_variation[] = $cartItem['variation'];
                                }
                                else{
                                    $product_ids = array();
                                    if(isset($seller_products[$product->user_id])){
                                        $product_ids = $seller_products[$product->user_id];
                                    }
                                    array_push($product_ids, $cartItem['product_id']);
                                    $seller_products[$product->user_id] = $product_ids;
                                    $seller_product_variation[$product->user_id][] = $cartItem['variation'];
                                }
                            }
                        ?>

                            <!-- Inhouse Products -->
                            <?php if(!empty($admin_products)): ?>
                                <?php
                                    $all_admin_products = true;
                                    if(count($admin_products) != count($carts->toQuery()->active()->whereIn('product_id', $admin_products)->get())){
                                        $all_admin_products = false;
                                    }
                                ?>
                                <div class="pt-3 px-0">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox d-block">
                                            <input type="checkbox" class="check-one check-seller" value="admin" <?php if($all_admin_products): ?> checked <?php endif; ?>>
                                            <span class="fs-16 fw-700 text-dark ml-3 pb-3 d-block border-left-0 border-top-0 border-right-0 border-bottom border-dashed">
                                                <?php echo e(translate('Inhouse Products')); ?> (<?php echo e(count($admin_products)); ?>)
                                            </span>
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                                <?php $__currentLoopData = $admin_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $product = get_single_product($product_id);
                                        $cartItem = $carts->toQuery()->where('product_id', $product_id)->where('variation', $admin_product_variation[$key])->first();
                                        $product_stock = $product->stocks->where('variant', $cartItem->variation)->first();
                                        $total = $total + cart_product_price($cartItem, $product, false) * $cartItem->quantity;
                                    ?>
                                    <li class="list-group-item px-0 border-md-0">
                                        <div class="row gutters-5 align-items-center">
                                            <!-- select -->
                                            <div class="col-auto">
                                                <div class="aiz-checkbox pl-0">
                                                    <label class="aiz-checkbox">
                                                        <input type="checkbox" class="check-one check-one-admin" name="id[]" value="<?php echo e($product_id); ?>" <?php if($cartItem->status == 1): ?> checked <?php endif; ?>>
                                                        <span class="aiz-square-check"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Product Image & name -->
                                            <div class="col-md-5 col-10 d-flex align-items-center mb-2 mb-md-0">
                                                <span class="mr-2 ml-0">
                                                    <img src="<?php echo e(uploaded_asset($product->thumbnail_img)); ?>"
                                                        class="img-fit size-64px"
                                                        alt="<?php echo e($product->getTranslation('name')); ?>"
                                                        onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">
                                                </span>
                                                <span>
                                                    <span class="fs-14 fw-400 text-dark text-truncate-2 mb-2"><?php echo e($product->getTranslation('name')); ?></span>
                                                    <?php if($admin_product_variation[$key] != ''): ?>
                                                        <span class="fs-12 text-secondary"><?php echo e(translate('Variation')); ?>: <?php echo e($admin_product_variation[$key]); ?></span>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                            <!-- Price & Tax -->
                                            <div class="col-md col-4 ml-4 ml-sm-0 my-3 my-md-0 d-flex flex-column ml-sm-5 ml-md-0">
                                                <span class="fs-12 text-secondary"><?php echo e(translate('Price')); ?></span>
                                                <span class="fw-700 fs-14 mb-2"><?php echo e(cart_product_price($cartItem, $product, true, false)); ?></span>
                                                 <?php if(addon_is_activated('gst_system')  && $product->gst_rate > 0 && $product->hsn_code != ''): ?>
                                                <span>
                                                    <span class="opacity-90 fs-12"><?php echo e(translate('GST')); ?>: <?php echo e(cart_product_gst($cartItem, $product)); ?></span>
                                                </span>
                                                <?php else: ?>
                                                <span>
                                                    <span class="opacity-90 fs-12"><?php echo e(translate('Tax')); ?>: <?php echo e(cart_product_tax($cartItem, $product)); ?></span>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                            <!-- Quantity & Total -->
                                            <div class="col-xl-4 col-md-3 col d-flex flex-column flex-xl-row justify-content-xl-between align-items-xl-center">
                                                <!-- Quantity -->
                                                <div>
                                                    <?php if($product->digital != 1 && $product->auction_product == 0): ?>
                                                        <div class="d-flex flex-xl-column flex-xxl-row align-items-center aiz-plus-minus mr-0 ml-0" style="width: max-content !important;">
                                                            <button
                                                                class="btn col-auto btn-icon btn-sm btn-light rounded-0"
                                                                type="button" data-type="plus"
                                                                data-field="quantity[<?php echo e($cartItem->id); ?>]">
                                                                <i class="las la-plus"></i>
                                                            </button>
                                                            <input type="number" name="quantity[<?php echo e($cartItem->id); ?>]"
                                                                class="col border-0 text-center px-0 fs-14 input-number"
                                                                placeholder="1" value="<?php echo e($cartItem['quantity']); ?>"
                                                                min="<?php echo e($product->min_qty); ?>"
                                                                max="<?php echo e($product_stock->qty); ?>"
                                                                onchange="updateQuantity(<?php echo e($cartItem->id); ?>, this)" style="min-width: 45px;">
                                                            <button
                                                                class="btn col-auto btn-icon btn-sm btn-light rounded-0"
                                                                type="button" data-type="minus"
                                                                data-field="quantity[<?php echo e($cartItem->id); ?>]">
                                                                <i class="las la-minus"></i>
                                                            </button>
                                                        </div>
                                                    <?php elseif($product->auction_product == 1): ?>
                                                        <span class="fw-700 fs-14">1</span>
                                                    <?php endif; ?>
                                                </div>
                                                <!-- Total -->
                                                <div class="mr-2 mt-2 mt-xl-0">
                                                    <span class="fw-700 fs-14 text-primary"><?php echo e(single_price(cart_product_price($cartItem, $product, false) * $cartItem->quantity)); ?></span>
                                                </div>
                                            </div>
                                            <!-- Remove From Cart -->
                                            <div class="col-auto text-right">
                                                <a href="javascript:void(0)" onclick="removeFromCartView(event, <?php echo e($cartItem->id); ?>)" class="btn btn-icon btn-sm bg-white hov-svg-danger" title="<?php echo e(translate('Remove')); ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.27" height="16" viewBox="0 0 12.27 16">
                                                        <g id="Group_23970" data-name="Group 23970" transform="translate(-1332 -420)">
                                                          <path id="Path_28714" data-name="Path 28714" d="M17.9,9.037l-.258,7.8a2.569,2.569,0,0,1-2.577,2.485h-4.9A2.569,2.569,0,0,1,7.587,16.84l-.258-7.8a.645.645,0,0,1,1.289-.043l.258,7.8a1.289,1.289,0,0,0,1.289,1.239h4.9a1.289,1.289,0,0,0,1.289-1.241l.258-7.8a.645.645,0,0,1,1.289.043Zm.852-2.6a.644.644,0,0,1-.644.644H7.122a.644.644,0,1,1,0-1.289h2a.822.822,0,0,0,.82-.74,1.927,1.927,0,0,1,1.922-1.736h1.5a1.927,1.927,0,0,1,1.922,1.736.822.822,0,0,0,.82.74h2a.644.644,0,0,1,.644.644ZM11.058,5.8h3.11A2.126,2.126,0,0,1,14,5.189a.644.644,0,0,0-.64-.58h-1.5a.644.644,0,0,0-.64.58,2.126,2.126,0,0,1-.165.608Zm.649,9.761V10.072a.644.644,0,0,0-1.289,0v5.488a.644.644,0,0,0,1.289,0Zm3.1,0V10.072a.644.644,0,1,0-1.289,0v5.488a.644.644,0,1,0,1.289,0Z" transform="translate(1325.522 416.678)" fill="#9d9da6"/>
                                                        </g>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <!-- Seller Products -->
                            <?php if(!empty($seller_products)): ?>
                                <?php $__currentLoopData = $seller_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seller_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $all_seller_products = true;
                                        if(count($seller_product) != count($carts->toQuery()->active()->whereIn('product_id', $seller_product)->get())){
                                            $all_seller_products = false;
                                        }
                                    ?>
                                    <div class="pt-3 px-0">
                                        <div class="aiz-checkbox-inline">
                                            <label class="aiz-checkbox d-block">
                                                <input type="checkbox" class="check-one check-seller" value="seller-<?php echo e($key); ?>"  <?php if($all_seller_products): ?> checked <?php endif; ?>>
                                                <span class="fs-16 fw-700 text-dark ml-3 pb-3 d-block border-left-0 border-top-0 border-right-0 border-bottom border-dashed">
                                                    <?php echo e(get_shop_by_user_id($key)->name); ?> <?php echo e(translate('Products')); ?> (<?php echo e(count($seller_product)); ?>)
                                                </span>
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <?php $__currentLoopData = $seller_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $product_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $product = get_single_product($product_id);
                                            $cartItem = $carts->toQuery()->where('product_id', $product_id)->where('variation', $seller_product_variation[$key][$key2])->first();
                                            $product_stock = $product->stocks->where('variant', $cartItem->variation)->first();
                                            $total = $total + cart_product_price($cartItem, $product, false) * $cartItem->quantity;
                                        ?>
                                        <li class="list-group-item px-0 border-md-0">
                                            <div class="row gutters-5 align-items-center">
                                                <!-- select -->
                                                <div class="col-auto">
                                                    <div class="aiz-checkbox pl-0">
                                                        <label class="aiz-checkbox">
                                                            <input type="checkbox" class="check-one check-one-seller-<?php echo e($key); ?>" name="id[]" value="<?php echo e($product_id); ?>" <?php if($cartItem->status == 1): ?> checked <?php endif; ?>>
                                                            <span class="aiz-square-check"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- Product Image & name -->
                                                <div class="col-md-5 col-10 d-flex align-items-center mb-2 mb-md-0">
                                                    <span class="mr-2 ml-0">
                                                        <img src="<?php echo e(uploaded_asset($product->thumbnail_img)); ?>"
                                                            class="img-fit size-64px"
                                                            alt="<?php echo e($product->getTranslation('name')); ?>"
                                                            onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">
                                                    </span>
                                                    <span>
                                                        <span class="fs-14 fw-400 text-dark text-truncate-2 mb-2"><?php echo e($product->getTranslation('name')); ?></span>
                                                        <?php if($seller_product_variation[$key][$key2] != ''): ?>
                                                            <span class="fs-12 text-secondary"><?php echo e(translate('Variation')); ?>: <?php echo e($seller_product_variation[$key][$key2]); ?></span>
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                                <!-- Price & Tax -->
                                                <div class="col-md col-4 ml-4 ml-sm-0 my-3 my-md-0 d-flex flex-column ml-sm-5 ml-md-0">
                                                    <span class="fs-12 text-secondary"><?php echo e(translate('Price')); ?></span>
                                                    <span class="fw-700 fs-14 mb-2"><?php echo e(cart_product_price($cartItem, $product, true, false)); ?></span>
                                                    <?php if(addon_is_activated('gst_system')): ?>
                                                    <span>
                                                        <span class="opacity-90 fs-12"><?php echo e(translate('GST')); ?>: <?php echo e(cart_product_gst($cartItem, $product)); ?></span>
                                                    </span>
                                                    <?php else: ?>
                                                    <span>
                                                        <span class="opacity-90 fs-12"><?php echo e(translate('Tax')); ?>: <?php echo e(cart_product_tax($cartItem, $product)); ?></span>
                                                    </span>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                                <!-- Quantity & Total -->
                                                <div class="col-xl-4 col-md-3 col d-flex flex-column flex-xl-row justify-content-xl-between align-items-xl-center">
                                                    <!-- Quantity -->
                                                    <div>
                                                        <?php if($product->digital != 1 && $product->auction_product == 0): ?>
                                                            <div class="d-flex flex-xl-column flex-xxl-row align-items-center aiz-plus-minus mr-0 ml-0" style="width: max-content !important;">
                                                                <button
                                                                    class="btn col-auto btn-icon btn-sm btn-light rounded-0"
                                                                    type="button" data-type="plus"
                                                                    data-field="quantity[<?php echo e($cartItem->id); ?>]">
                                                                    <i class="las la-plus"></i>
                                                                </button>
                                                                <input type="number" name="quantity[<?php echo e($cartItem->id); ?>]"
                                                                    class="col border-0 text-center px-0 fs-14 input-number"
                                                                    placeholder="1" value="<?php echo e($cartItem['quantity']); ?>"
                                                                    min="<?php echo e($product->min_qty); ?>"
                                                                    max="<?php echo e($product_stock->qty); ?>"
                                                                    onchange="updateQuantity(<?php echo e($cartItem->id); ?>, this)" style="min-width: 45px;">
                                                                <button
                                                                    class="btn col-auto btn-icon btn-sm btn-light rounded-0"
                                                                    type="button" data-type="minus"
                                                                    data-field="quantity[<?php echo e($cartItem->id); ?>]">
                                                                    <i class="las la-minus"></i>
                                                                </button>
                                                            </div>
                                                        <?php elseif($product->auction_product == 1): ?>
                                                            <span class="fw-700 fs-14">1</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!-- Total -->
                                                    <div class="mr-2 mt-2 mt-xl-0">
                                                        <span class="fw-700 fs-14 text-primary"><?php echo e(single_price(cart_product_price($cartItem, $product, false) * $cartItem->quantity)); ?></span>
                                                    </div>
                                                </div>
                                                <!-- Remove From Cart -->
                                                <div class="col-auto text-right">
                                                    <a href="javascript:void(0)" onclick="removeFromCartView(event, <?php echo e($cartItem->id); ?>)" class="btn btn-icon btn-sm bg-white hov-svg-danger" title="<?php echo e(translate('Remove')); ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12.27" height="16" viewBox="0 0 12.27 16">
                                                            <g id="Group_23970" data-name="Group 23970" transform="translate(-1332 -420)">
                                                              <path id="Path_28714" data-name="Path 28714" d="M17.9,9.037l-.258,7.8a2.569,2.569,0,0,1-2.577,2.485h-4.9A2.569,2.569,0,0,1,7.587,16.84l-.258-7.8a.645.645,0,0,1,1.289-.043l.258,7.8a1.289,1.289,0,0,0,1.289,1.239h4.9a1.289,1.289,0,0,0,1.289-1.241l.258-7.8a.645.645,0,0,1,1.289.043Zm.852-2.6a.644.644,0,0,1-.644.644H7.122a.644.644,0,1,1,0-1.289h2a.822.822,0,0,0,.82-.74,1.927,1.927,0,0,1,1.922-1.736h1.5a1.927,1.927,0,0,1,1.922,1.736.822.822,0,0,0,.82.74h2a.644.644,0,0,1,.644.644ZM11.058,5.8h3.11A2.126,2.126,0,0,1,14,5.189a.644.644,0,0,0-.64-.58h-1.5a.644.644,0,0,0-.64.58,2.126,2.126,0,0,1-.165.608Zm.649,9.761V10.072a.644.644,0,0,0-1.289,0v5.488a.644.644,0,0,0,1.289,0Zm3.1,0V10.072a.644.644,0,1,0-1.289,0v5.488a.644.644,0,1,0,1.289,0Z" transform="translate(1325.522 416.678)" fill="#9d9da6"/>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4 mt-lg-0 mt-4" id="cart_summary">
                <?php echo $__env->make('frontend.partials.cart.cart_summary', ['proceed' => 1, 'carts' => $active_carts], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="border bg-white p-4">
                    <!-- Empty cart -->
                    <div class="text-center p-3">
                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                        <h3 class="h4 fw-700"><?php echo e(translate('Your Cart is empty')); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/partials/cart/cart_details.blade.php ENDPATH**/ ?>