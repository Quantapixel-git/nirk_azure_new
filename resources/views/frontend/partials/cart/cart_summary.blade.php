





<div class="z-3 sticky-top-lg">
    <div class="card rounded-0 border">

        @php
            $subtotal_for_min_order_amount = 0;
            $subtotal = 0;
            $tax = 0;
            $gst= 0;
            $product_shipping_cost = 0;
            $shipping = 0;
            $coupon_code = null;
            $coupon_discount = 0;
            $total_point = 0;
        @endphp
        @foreach ($carts as $key => $cartItem)
            @php
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
            @endphp
        @endforeach

        <div class="card-header pt-4 pb-1 border-bottom-0">
            <h3 class="fs-16 fw-700 mb-0">{{ translate('Order Summary') }}</h3>
            <div class="text-right">
                <!-- Minimum Order Amount -->
                @if (get_setting('minimum_order_amount_check') == 1 && $subtotal_for_min_order_amount < get_setting('minimum_order_amount'))
                    <span class="badge badge-inline badge-warning fs-12 rounded-0 px-2">
                        {{ translate('Minimum Order Amount') . ' ' . single_price(get_setting('minimum_order_amount')) }}
                    </span>
                @endif
            </div>
        </div>

        <div class="card-body pt-2">

            <div class="row gutters-5">
                <!-- Total Products -->
                <div class="@if (addon_is_activated('club_point')) col-6 @else col-12 @endif">
                    <div class="d-flex align-items-center justify-content-between bg-primary p-2">
                        <span class="fs-13 text-white">{{ translate('Total Products') }}</span>
                        <span class="fs-13 fw-700 text-white">{{ sprintf("%02d", count($carts)) }}</span>
                    </div>
                </div>
                @if (addon_is_activated('club_point'))
                    <!-- Total Clubpoint -->
                    <div class="col-6">
                        <div class="d-flex align-items-center justify-content-between bg-secondary-base p-2">
                            <span class="fs-13 text-white">{{ translate('Total Clubpoint') }}</span>
                            <span class="fs-13 fw-700 text-white">{{ sprintf("%02d", $total_point) }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <input type="hidden" id="sub_total" value="{{ $subtotal }}">

            <table class="table my-3">
                <tfoot>
                    <!-- Subtotal -->
                    <tr class="cart-subtotal">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Subtotal') }} ({{ sprintf("%02d", count($carts)) }} {{ translate('Products') }})</th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($subtotal) }}</td>
                    </tr>
                    
                    <!-- Tax -->
                     @if(!addon_is_activated('gst_system'))
                    <tr class="cart-tax">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Tax') }}</th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($tax) }}</td>
                    </tr>
                    @endif
                    @if ($proceed != 1)
                    <!-- Total Shipping -->
                    <tr class="cart-shipping">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Total Shipping') }}</th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($shipping) }}</td>
                    </tr>
                    @endif
                    <!-- Redeem point -->
                    @if (Session::has('club_point'))
                        <tr class="cart-club-point">
                            <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Redeem point') }}</th>
                            <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price(Session::get('club_point')) }}</td>
                        </tr>
                    @endif
                    <!-- Coupon Discount -->
                    @if ($coupon_discount > 0)
                        <tr class="cart-coupon-discount">
                            <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Coupon Discount') }}</th>
                            <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($coupon_discount) }}</td>
                        </tr>
                    @endif

                    @if(addon_is_activated('gst_system'))
                    <!-- Gst -->
                    <tr class="cart-gst">
                        <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('GST') }}</th>
                        <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($gst) }}</td>
                    </tr>
                    @endif

                   @php
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
@endphp


@php

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

@endphp
        

@php

$userMlmBlocked = false;

if(auth()->check()){
    $userMlmBlocked = auth()->user()->mlm_status == 'blocked';
}

@endphp
                    
                   @if(!$userMlmBlocked)

<tr>
    <th class="pl-0 fs-14 fw-400">
        My Wallet Balance
    </th>

    <td class="text-right">
        <strong class="text-success">
            {{ single_price($mlmAvailable) }}
        </strong>
    </td>
</tr>

@else

<tr>
    <th colspan="2">
        <div class="alert alert-danger mb-0">
            My Wallet is blocked.
            Please contact admin to reactivate your MLM account.
        </div>
    </th>
</tr>

@endif

@if($proceed == 0)

   @if(!$userMlmBlocked && $walletUsed > 0)
    <tr>
        <th class="pl-0 fs-14 text-success">
            My Wallet Applied
        </th>
        <td class="text-right text-success">
            ✓ Yes
        </td>
    </tr>
    @endif

@else

  @if(
    auth()->check()
    && auth()->user()->mlm_status == 'active'
    && ($mlmAvailable > 0 || $walletUsed > 0)
)
    <tr>
        <th colspan="2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox"
                       id="use_mlm_wallet"
                       class="custom-control-input"
                       {{ $walletUsed > 0 ? 'checked' : '' }}>
                <label class="custom-control-label"
                       for="use_mlm_wallet">
                    Use My Wallet Balance
                </label>
            </div>
        </th>
    </tr>
    @endif

@endif

@if(!$userMlmBlocked)

<tr id="wallet_discount_row"
    style="{{ ($walletUsed ?? 0) > 0 ? '' : 'display:none;' }}">

    <th class="pl-0 fs-14 text-success">
        My Wallet Used
    </th>

    <td class="text-right text-success">

        - ₹ <span id="wallet_used_amount">
    {{ number_format($walletUsed ?? 0,2) }}
</span>

    </td>

</tr>
@endif


                    <!-- Total -->
                    <tr class="cart-total">
                        <th class="pl-0 fs-14 text-dark fw-700 border-top-0 pt-3 text-uppercase">{{ translate('Total') }}</th>
                       <td class="text-right pr-0 fs-16 fw-700 text-primary border-top-0 pt-3">

   <span id="final_total"
      data-total="{{ $total }}">
    {{ single_price($displayTotal) }}
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
            @if (get_setting('coupon_system') == 1)
                @if ($coupon_discount > 0 && $coupon_code)
                    <div class="mt-3">
                        <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="proceed" value="{{ $proceed }}">
                            <div class="input-group">
                                <div class="form-control">{{ $coupon_code }}</div>
                                <div class="input-group-append">
                                    <button type="button" id="coupon-remove"
                                        class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="mt-3">
                        <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="proceed" value="{{ $proceed }}">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-0" name="code"
                                    onkeydown="return event.key != 'Enter';"
                                    placeholder="{{ translate('Have coupon code? Apply here') }}" required>
                                <div class="input-group-append">
                                    <button type="button" id="coupon-apply"
                                        class="btn btn-primary rounded-0">{{ translate('Apply') }}</button>
                                </div>
                            </div>
                            @if (!auth()->check())
                                <small>{{ translate('You must Login as customer to apply coupon') }}</small>
                            @endif

                        </form>
                    </div>
                @endif
            @endif

            @if ($proceed == 1)
    @php
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
    @endphp

    <div class="mt-4">
        <a href="{{ route('checkout') }}"
           id="proceed-to-checkout"
           class="btn btn-primary btn-block fs-14 fw-700 rounded-0 px-4"
           data-kyc="{{ $user->is_kyc }}"
           data-kyc-step="{{ $nextKycStep }}">
           {{ translate('Proceed to Checkout') }} ({{ sprintf("%02d", count($carts)) }})
        </a>
    </div>
@endif

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
@php
$originalTotal = $subtotal + $tax + $shipping + $gst;

if (Session::has('club_point')) {
    $originalTotal -= Session::get('club_point');
}

if ($coupon_discount > 0) {
    $originalTotal -= $coupon_discount;
}
@endphp



<script>

    @if(auth()->check() && auth()->user()->mlm_status == 'active')
$(document).on('change', '#use_mlm_wallet', function(){

    let total = parseFloat("{{ $originalTotal }}");
    let wallet = parseFloat("{{ $mlmAvailable }}");

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
            url: "{{ route('store.mlm.wallet') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
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
            url: "{{ route('store.mlm.wallet') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                wallet_used: 0
            }
        });
    }
});

@endif
</script>



<!-- ADD THIS BELOW THE ABOVE SCRIPT -->
<script>
$(function(){

    let walletUsed = parseFloat("{{ $walletUsed ?? 0 }}");

    if(walletUsed > 0)
    {
        $('#use_mlm_wallet').prop('checked', true);

        $('#wallet_discount_row').show();

        let total = parseFloat("{{ $originalTotal }}");

        $('#wallet_used_amount').html(walletUsed.toFixed(2));

        $('#final_total').html(
            '₹ ' + (total - walletUsed).toFixed(2)
        );

        $('#use_mlm_wallet_input').val(1);

        $('#mlm_wallet_used').val(walletUsed);
    }

});
</script>
