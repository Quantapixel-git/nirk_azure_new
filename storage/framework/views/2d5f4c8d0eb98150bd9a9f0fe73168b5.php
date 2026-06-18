





<div class="z-3 sticky-top-lg">
    <div class="card rounded-0 border">

        <?php
            $subtotal_for_min_order_amount = 0;
            $subtotal = 0;
            $tax = 0;
            $gst= 0;
            $product_shipping_cost = 0;
            $shipping = 0;
            $coupon_code = null;
            $coupon_discount = 0;
            $total_point = 0;
        ?>
        <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $product = get_single_product($cartItem['product_id']);
                $subtotal_for_min_order_amount += cart_product_price($cartItem, $cartItem->product, false, false) * $cartItem['quantity'];
                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                if (addon_is_activated('gst_system')) {
                $gst += cart_product_gst($cartItem, $product, false);
                }
                $product_shipping_cost = $cartItem['shipping_cost'];
                $shipping += $product_shipping_cost;
                if ((get_setting('coupon_system') == 1) && ($cartItem->coupon_applied == 1)) {
                    $coupon_code = $cartItem->coupon_code;
                    $coupon_discount = $carts->sum('discount');
                }
                if (addon_is_activated('club_point')) {
                    $total_point += $product->earn_point * $cartItem['quantity'];
                }
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="card-header pt-4 pb-1 border-bottom-0">
            <h3 class="fs-16 fw-700 mb-0"><?php echo e(translate('Order Summary')); ?></h3>
            <div class="text-right">
                <!-- Minimum Order Amount -->
                <?php if(get_setting('minimum_order_amount_check') == 1 && $subtotal_for_min_order_amount < get_setting('minimum_order_amount')): ?>
                    <span class="badge badge-inline badge-warning fs-12 rounded-0 px-2">
                        <?php echo e(translate('Minimum Order Amount') . ' ' . single_price(get_setting('minimum_order_amount'))); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body pt-2">

            <div class="row gutters-5">
                <!-- Total Products -->
                <div class="<?php if(addon_is_activated('club_point')): ?> col-6 <?php else: ?> col-12 <?php endif; ?>">
                    <div class="d-flex align-items-center justify-content-between bg-primary p-2">
                        <span class="fs-13 text-white"><?php echo e(translate('Total Products')); ?></span>
                        <span class="fs-13 fw-700 text-white"><?php echo e(sprintf("%02d", count($carts))); ?></span>
                    </div>
                </div>
                <?php if(addon_is_activated('club_point')): ?>
                    <!-- Total Clubpoint -->
                    <div class="col-6">
                        <div class="d-flex align-items-center justify-content-between bg-secondary-base p-2">
                            <span class="fs-13 text-white"><?php echo e(translate('Total Clubpoint')); ?></span>
                            <span class="fs-13 fw-700 text-white"><?php echo e(sprintf("%02d", $total_point)); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <input type="hidden" id="sub_total" value="<?php echo e($subtotal); ?>">

            <table class="table my-3">
                <tfoot>
                    <!-- Subtotal -->
                    <tr class="cart-subtotal">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0"><?php echo e(translate('Subtotal')); ?> (<?php echo e(sprintf("%02d", count($carts))); ?> <?php echo e(translate('Products')); ?>)</th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0"><?php echo e(single_price($subtotal)); ?></td>
                    </tr>
                    
                    <!-- Tax -->
                     <?php if(!addon_is_activated('gst_system')): ?>
                    <tr class="cart-tax">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0"><?php echo e(translate('Tax')); ?></th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0"><?php echo e(single_price($tax)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($proceed != 1): ?>
                    <!-- Total Shipping -->
                    <tr class="cart-shipping">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0"><?php echo e(translate('Total Shipping')); ?></th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0"><?php echo e(single_price($shipping)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <!-- Redeem point -->
                    <?php if(Session::has('club_point')): ?>
                        <tr class="cart-club-point">
                            <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0"><?php echo e(translate('Redeem point')); ?></th>
                            <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0"><?php echo e(single_price(Session::get('club_point'))); ?></td>
                        </tr>
                    <?php endif; ?>
                    <!-- Coupon Discount -->
                    <?php if($coupon_discount > 0): ?>
                        <tr class="cart-coupon-discount">
                            <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0"><?php echo e(translate('Coupon Discount')); ?></th>
                            <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0"><?php echo e(single_price($coupon_discount)); ?></td>
                        </tr>
                    <?php endif; ?>

                    <?php if(addon_is_activated('gst_system')): ?>
                    <!-- Gst -->
                    <tr class="cart-gst">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0"><?php echo e(translate('GST')); ?></th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0"><?php echo e(single_price($gst)); ?></td>
                    </tr>
                    <?php endif; ?>

                   <?php
    $total = $subtotal + $tax + $shipping + $gst;

    if (Session::has('club_point')) {
        $total -= Session::get('club_point');
    }

    if ($coupon_discount > 0) {
        $total -= $coupon_discount;
    }

    // MLM Wallet Deduction
   $walletUsed = $walletUsed ?? session('mlm_wallet_used', 0);

   $displayTotal = max(0, $total - $walletUsed);
?>


<?php

$mlmAvailable = 0;

$mlmEarning = 0;
$mlmWithdrawn = 0;
$mlmAvailable = 0;

if(auth()->check()){

    $earning = DB::table('mlm_wallet')
        ->where('user_id', auth()->id())
        ->where('wallet_status', 1)
        ->sum('pt_value');

    $withdrawn = DB::table('mlm_withdraw_requests')
        ->where('user_id', auth()->id())
        ->where('status', 'approved')
        ->sum('amount');

    $walletUsedInOrders = DB::table('orders')
        ->where('user_id', auth()->id())
        ->sum('mlm_wallet_used');

    // Refunded MLM amount stored in users table
    $refundedAmount = auth()->user()->mlm_wallet ?? 0;

    $mlmAvailable = max(
        $earning
        - $withdrawn
        - $walletUsedInOrders
        + $refundedAmount,
        0
    );
}

?>
        

<?php

$userMlmBlocked = false;

if(auth()->check()){
    $userMlmBlocked = auth()->user()->mlm_status == 'blocked';
}

?>
                    
                   <?php if(!$userMlmBlocked): ?>

<tr>
    <th class="pl-0 fs-14 fw-400">
        My Wallet Balance
    </th>

    <td class="text-right">
        <strong class="text-success">
            <?php echo e(single_price($mlmAvailable)); ?>

        </strong>
    </td>
</tr>

<?php else: ?>

<tr>
    <th colspan="2">
        <div class="alert alert-danger mb-0">
            My Wallet is blocked.
            Please contact admin to reactivate your MLM account.
        </div>
    </th>
</tr>

<?php endif; ?>

<?php if($proceed == 0): ?>

   <?php if(!$userMlmBlocked && $walletUsed > 0): ?>
    <tr>
        <th class="pl-0 fs-14 text-success">
            My Wallet Applied
        </th>
        <td class="text-right text-success">
            ✓ Yes
        </td>
    </tr>
    <?php endif; ?>

<?php else: ?>

  <?php if(
    auth()->check()
    && auth()->user()->mlm_status == 'active'
    && ($mlmAvailable > 0 || $walletUsed > 0)
): ?>
    <tr>
        <th colspan="2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox"
                       id="use_mlm_wallet"
                       class="custom-control-input"
                       <?php echo e($walletUsed > 0 ? 'checked' : ''); ?>>
                <label class="custom-control-label"
                       for="use_mlm_wallet">
                    Use My Wallet Balance
                </label>
            </div>
        </th>
    </tr>
    <?php endif; ?>

<?php endif; ?>

<?php if(!$userMlmBlocked): ?>

<tr id="wallet_discount_row"
    style="<?php echo e(($walletUsed ?? 0) > 0 ? '' : 'display:none;'); ?>">

    <th class="pl-0 fs-14 text-success">
        My Wallet Used
    </th>

    <td class="text-right text-success">

        - ₹ <span id="wallet_used_amount">
    <?php echo e(number_format($walletUsed ?? 0,2)); ?>

</span>

    </td>

</tr>
<?php endif; ?>


                    <!-- Total -->
                    <tr class="cart-total">
                        <th class="pl-0 fs-14 text-dark fw-700 border-top-0 pt-3 text-uppercase"><?php echo e(translate('Total')); ?></th>
                       <td class="text-right pr-0 fs-16 fw-700 text-primary border-top-0 pt-3">

   <span id="final_total"
      data-total="<?php echo e($total); ?>">
    <?php echo e(single_price($displayTotal)); ?>

</span>

</td>
                    </tr>
                </tfoot>
            </table>
            
            <input type="hidden"
       name="use_mlm_wallet"
       id="use_mlm_wallet_input"
       value="0">

<input type="hidden"
       name="mlm_wallet_used"
       id="mlm_wallet_used"
       value="0">

            <!-- Coupon System -->
            <?php if(get_setting('coupon_system') == 1): ?>
                <?php if($coupon_discount > 0 && $coupon_code): ?>
                    <div class="mt-3">
                        <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="proceed" value="<?php echo e($proceed); ?>">
                            <div class="input-group">
                                <div class="form-control"><?php echo e($coupon_code); ?></div>
                                <div class="input-group-append">
                                    <button type="button" id="coupon-remove"
                                        class="btn btn-primary"><?php echo e(translate('Change Coupon')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="mt-3">
                        <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="proceed" value="<?php echo e($proceed); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-0" name="code"
                                    onkeydown="return event.key != 'Enter';"
                                    placeholder="<?php echo e(translate('Have coupon code? Apply here')); ?>" required>
                                <div class="input-group-append">
                                    <button type="button" id="coupon-apply"
                                        class="btn btn-primary rounded-0"><?php echo e(translate('Apply')); ?></button>
                                </div>
                            </div>
                            <?php if(!auth()->check()): ?>
                                <small><?php echo e(translate('You must Login as customer to apply coupon')); ?></small>
                            <?php endif; ?>

                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if($proceed == 1): ?>
    <?php
        $user = auth()->user();
        $kyc = \App\Models\Userkyc::firstOrCreate(
            ['user_id' => $user->id],
            ['is_bank' => 2, 'is_aadhar' => 2, 'is_pan' => 2]
        );

        // Determine next incomplete KYC step
        $nextKycStep = 1;
        if ($kyc->is_bank != 1) {
            $nextKycStep = 1;
        } elseif ($kyc->is_aadhar != 1) {
            $nextKycStep = 2;
        } elseif ($kyc->is_pan != 1) {
            $nextKycStep = 3;
        }
    ?>

    <div class="mt-4">
        <a href="<?php echo e(route('checkout')); ?>"
           id="proceed-to-checkout"
           class="btn btn-primary btn-block fs-14 fw-700 rounded-0 px-4"
           data-kyc="<?php echo e($user->is_kyc); ?>"
           data-kyc-step="<?php echo e($nextKycStep); ?>">
           <?php echo e(translate('Proceed to Checkout')); ?> (<?php echo e(sprintf("%02d", count($carts))); ?>)
        </a>
    </div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkoutBtn = document.getElementById('proceed-to-checkout');

        checkoutBtn.addEventListener('click', function(e) {
            const isKyc = parseInt(this.dataset.kyc);
            const nextStep = this.dataset.kycStep;

            if (isKyc !== 1) {
                e.preventDefault(); // prevent normal navigation
                Swal.fire({
                    icon: 'warning',
                    title: 'KYC Pending',
                    text: 'Your KYC is still pending. Please complete first.',
                    confirmButtonText: 'Go to KYC'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to user KYC page with the next incomplete step
                        window.location.href = `/user/kyc/${nextStep}`;
                    }
                });
            }
        });
    });
</script>

        </div>
    </div>
</div>
<?php
$originalTotal = $subtotal + $tax + $shipping + $gst;

if (Session::has('club_point')) {
    $originalTotal -= Session::get('club_point');
}

if ($coupon_discount > 0) {
    $originalTotal -= $coupon_discount;
}
?>



<script>

    <?php if(auth()->check() && auth()->user()->mlm_status == 'active'): ?>
$(document).on('change', '#use_mlm_wallet', function(){

    let total = parseFloat("<?php echo e($originalTotal); ?>");
    let wallet = parseFloat("<?php echo e($mlmAvailable); ?>");

    if($(this).is(':checked'))
    {
        let walletUsed = Math.min(wallet, total);
        let finalAmount = total - walletUsed;

        $('#wallet_discount_row').show();

        $('#wallet_used_amount').html(walletUsed.toFixed(2));

        $('#final_total').html('₹ ' + finalAmount.toFixed(2));

        $('#use_mlm_wallet_input').val(1);
        $('#mlm_wallet_used').val(walletUsed);

        $.ajax({
            url: "<?php echo e(route('store.mlm.wallet')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                wallet_used: walletUsed
            }
        });
    }
    else
    {
        $('#wallet_discount_row').hide();

        $('#final_total').html('₹ ' + total.toFixed(2));

        $('#use_mlm_wallet_input').val(0);
        $('#mlm_wallet_used').val(0);

        $.ajax({
            url: "<?php echo e(route('store.mlm.wallet')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                wallet_used: 0
            }
        });
    }
});

<?php endif; ?>
</script>



<!-- ADD THIS BELOW THE ABOVE SCRIPT -->
<script>
$(function(){

    let walletUsed = parseFloat("<?php echo e($walletUsed ?? 0); ?>");

    if(walletUsed > 0)
    {
        $('#use_mlm_wallet').prop('checked', true);

        $('#wallet_discount_row').show();

        let total = parseFloat("<?php echo e($originalTotal); ?>");

        $('#wallet_used_amount').html(walletUsed.toFixed(2));

        $('#final_total').html(
            '₹ ' + (total - walletUsed).toFixed(2)
        );

        $('#use_mlm_wallet_input').val(1);

        $('#mlm_wallet_used').val(walletUsed);
    }

});
</script>
<?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/partials/cart/cart_summary.blade.php ENDPATH**/ ?>