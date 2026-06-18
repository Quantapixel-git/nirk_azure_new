

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0"><?php echo e(translate('Order Details')); ?></h1>
        </div>
        <div class="card-body">
            <div class="col-12 col-xl-10 ml-auto px-0">
                <div class="row gutters-5 justify-content-end">
                    <?php
                        $delivery_status = $order->delivery_status;
                        $payment_status = $order->payment_status;
                        $admin_user_id = get_admin()->id;
                        $first_order = $order->orderDetails->first();
                        $shipping_method = $order->shipping_method ?? null;
                    ?>
                    <?php if($order->seller_id == $admin_user_id || get_setting('product_manage_by_admin') == 1): ?>

                        <!--Assign Delivery Boy-->
                        <?php if(addon_is_activated('delivery_boy')): ?>
                            <?php if($shipping_method != 'shiprocket' && $shipping_method != 'steadfast' && $shipping_method != 'pathao'): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label for="assign_deliver_boy"><?php echo e(translate('Assign Deliver Boy')); ?></label>
                                    <?php if(($delivery_status == 'pending' || $delivery_status == 'confirmed' || $delivery_status == 'picked_up') && auth()->user()->can('assign_delivery_boy_for_orders')): ?>
                                        <select class="form-control aiz-selectpicker" data-live-search="true"
                                            data-minimum-results-for-search="Infinity" id="assign_deliver_boy">
                                            <option value=""><?php echo e(translate('Select Delivery Boy')); ?></option>
                                            <?php $__currentLoopData = $delivery_boys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery_boy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($delivery_boy->id); ?>"
                                                    <?php if($order->assign_delivery_boy == $delivery_boy->id): ?> selected <?php endif; ?>>
                                                    <?php echo e($delivery_boy->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php else: ?>
                                        <input type="text" class="form-control" value="<?php echo e(optional($order->delivery_boy)->name); ?>"
                                            disabled>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                            <label for="update_payment_status"><?php echo e(translate('Payment Status')); ?></label>
                            <?php if(auth()->user()->can('update_order_payment_status') && $payment_status == 'unpaid'): ?>
                                
                                <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity" id="update_payment_status" onchange="confirm_payment_status()">
                                    <option value="unpaid" <?php if($payment_status == 'unpaid'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('Unpaid')); ?>

                                    </option>
                                    <option value="paid" <?php if($payment_status == 'paid'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('Paid')); ?>

                                    </option>
                                </select>
                            <?php else: ?>
                                <input type="text" class="form-control" value="<?php echo e(ucfirst($payment_status)); ?>" disabled>
                            <?php endif; ?>
                        </div>
                        <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                            <label for="update_delivery_status"><?php echo e(translate('Delivery Status')); ?></label>
                            <?php if($order->shipping_method == 'shiprocket' || $order->shipping_method == 'steadfast' || $order->shipping_method == 'pathao'): ?>
                                <input type="text" class="form-control" value="<?php echo e(ucfirst(str_replace('_', ' ', $delivery_status))); ?>" disabled>
                            <?php elseif(auth()->user()->can('update_order_delivery_status') && $delivery_status != 'delivered' && $delivery_status != 'cancelled'): ?>
                                <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                    id="update_delivery_status">
                                    <option value="pending" <?php if($delivery_status == 'pending'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('Pending')); ?>

                                    </option>
                                    <option value="confirmed" <?php if($delivery_status == 'confirmed'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('Confirmed')); ?>

                                    </option>
                                    <option value="picked_up" <?php if($delivery_status == 'picked_up'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('Picked Up')); ?>

                                    </option>
                                    <option value="on_the_way" <?php if($delivery_status == 'on_the_way'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('On The Way')); ?>

                                    </option>
                                    <option value="delivered" <?php if($delivery_status == 'delivered'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('Delivered')); ?>

                                    </option>
                                    <option value="cancelled" <?php if($delivery_status == 'cancelled'): ?> selected <?php endif; ?>>
                                        <?php echo e(translate('Cancel')); ?>

                                    </option>
                                </select>
                            <?php else: ?>
                                <input type="text" class="form-control" value="<?php echo e($delivery_status); ?>" disabled>
                            <?php endif; ?>
                        </div>
                        <?php if(addon_is_activated('shiprocket') || addon_is_activated('steadfast') || addon_is_activated('pathao')): ?>
                            <?php
                                $addons = [];
                                if (addon_is_activated('shiprocket')) {
                                    $addons[] = 'shiprocket';
                                }
                                if (addon_is_activated('steadfast')) {
                                    $addons[] = 'steadfast';
                                }
                                if (addon_is_activated('pathao')) {
                                    $addons[] = 'pathao';
                                }
                                $shipping_systems = App\Models\ShippingSystem::where('active', 1)
                                    ->whereIn('name', $addons)
                                    ->get();
                            ?>
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                <label for="select_shipping_info"><?php echo e(translate('Shipping System')); ?></label>
                                <?php if($order->delivery_status == 'pending' || $order->delivery_status == 'confirmed'): ?>
                                    <?php if($shipping_method): ?>
                                        <input type="text" class="form-control" value="<?php echo e(ucfirst(translate($shipping_method))); ?>" disabled>
                                    <?php else: ?>
                                        <select class="form-control aiz-selectpicker" id="select_shipping_info" name="shipping_system">
                                            <option value="">
                                                <?php echo e(translate('Select Shipping System')); ?>

                                            </option>
                                            <?php $__currentLoopData = $shipping_systems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping_system): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                            <option value="<?php echo e($shipping_system->name); ?>">
                                                <?php echo e(ucfirst($shipping_system->name)); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <input type="text" class="form-control" value="<?php echo e(ucfirst(translate($shipping_method))); ?>" disabled>    
                                <?php endif; ?>
                            </div>
                            <?php if($order->shipping_method == 'shiprocket'): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label for=""><?php echo e(translate('Shiprocket Order Status')); ?></label>
                                    <input type="text" class="form-control" value="<?php echo e(ucfirst(str_replace('_', ' ', $order->shiprocket_order_status))); ?>" disabled>
                                </div>
                                <?php if($order->shiprocket_awb != null): ?>
                                    <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                        <label for=""><?php echo e(translate('Shiprocket Delivery Status')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e(ucfirst(str_replace('_', ' ', $order->shiprocket_status))); ?>" disabled>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($order->shipping_method == 'steadfast'): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label for=""><?php echo e(translate('Steadfast Status')); ?></label>
                                    <input type="text" class="form-control" value="<?php echo e(ucfirst(str_replace('_', ' ', $order->steadfast_status))); ?>" disabled>
                                </div>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label for=""><?php echo e(translate('Steadfast Consignment Id')); ?></label>
                                    <input type="text" class="form-control" value="<?php echo e(ucfirst(str_replace('_', ' ', $order->steadfast_consignment_id))); ?>" disabled>
                                </div>
                            <?php endif; ?>
                            <?php if($order->shipping_method == 'pathao'): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label for=""><?php echo e(translate('Pathao Status')); ?></label>
                                    <input type="text" class="form-control" value="<?php echo e(ucfirst(str_replace('_', ' ', $order->pathao_status))); ?>" disabled>
                                </div>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label for=""><?php echo e(translate('Pathao Consignment Id')); ?></label>
                                    <input type="text" class="form-control" value="<?php echo e(ucfirst(str_replace('_', ' ', $order->pathao_consignment_id))); ?>" disabled>
                                </div>
                            <?php endif; ?>
                            <?php if($order->shipping_method == 'shiprocket' && $order->shiprocket_shipment_id): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label><?php echo e(translate('Courier')); ?></label>

                                    <?php if($order->shiprocket_courier_id): ?>
                                        <input type="text" class="form-control" value="<?php echo e($order->shiprocket_courier_name); ?>" disabled>
                                    <?php else: ?>
                                        <select
                                            class="form-control aiz-selectpicker"
                                            id="shiprocket_courier"
                                            data-live-search="true">
                                            <option value=""><?php echo e(translate('Loading...')); ?></option>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if($order->shiprocket_awb && !$order->pickup_scheduled_at): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label class="d-none d-md-block mb-2"></label>
                                    <button
                                        class="btn btn-warning form-control d-block"
                                        id="request-pickup-btn">
                                        <?php echo e(translate('Request Pickup')); ?>

                                    </button>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                        <?php if($shipping_method === 'shiprocket'): ?>
                            <?php if($order->pickup_scheduled_at): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label><?php echo e(translate('Pickup Scheduled')); ?></label>
                                    <input type="text" class="form-control"
                                        value="<?php echo e($order->pickup_scheduled_at); ?>"
                                        disabled>
                                </div>
                            <?php endif; ?>
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                <label >
                                    <?php echo e(translate('AWB Code')); ?>

                                </label>
                                <input type="text" class="form-control"
                                    value="<?php echo e($order->shiprocket_awb); ?>" disabled>
                            </div>
                        <?php elseif($shipping_method === 'steadfast'): ?>
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                <label>
                                    <?php echo e(translate('Steadfast Tracking Code')); ?>

                                </label>
                                <input type="text" class="form-control"
                                    value="<?php echo e($order->steadfast_tracking_code); ?>" disabled>
                            </div>
                        <?php elseif($shipping_method === 'pathao'): ?>
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                <label>
                                    <?php echo e(translate('Pathao Delivery Fee')); ?>

                                </label>
                                <input type="text" class="form-control"
                                    value="<?php echo e($order->pathao_delivery_fee); ?> TK" disabled>
                            </div>
                        <?php else: ?>
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                <label for="update_tracking_code">
                                    <?php echo e(translate('Tracking Code (optional)')); ?>

                                </label>
                                <input type="text" class="form-control" id="update_tracking_code"
                                    value="<?php echo e($order->tracking_code); ?>">
                            </div>
                        <?php endif; ?>    
                        <?php if($order->shipping_method === 'shiprocket' && $order->shiprocket_awb): ?> 
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                <label>
                                    <?php echo e(translate('Download Label')); ?>

                                </label>
                                    <a href="<?php echo e(route('shiprocket.download.label', $order->id)); ?>"
                                class="btn btn-sm btn-install w-auto h-auto d-block " title="Download Label">
                                <i class="las la-2x la-download"></i>
                                </a>
                            </div>
                            <?php if($delivery_status != 'cancelled'): ?>
                                <div class="col-12 col-md-4 col-xl-4 col-xxl-2 mb-2">
                                    <label>
                                        <?php echo e(translate('Download Manifest')); ?>

                                    </label>
                                    <a href="<?php echo e(route('shiprocket.download.manifest', $order->id)); ?>"
                                    class="btn btn-sm btn-install w-auto h-auto d-block" title="Download Manifest">
                                        <i class="las la-2x la-download"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>
            <div class="mb-3 mt-3">
                <?php
                    $removedXML = '<?xml version="1.0" encoding="UTF-8"?>';
                ?>
                <?php echo str_replace($removedXML, '', QrCode::size(100)->generate($order->code)); ?>

            </div>
            <div class="row gutters-5">
                <div class="col text-md-left text-center">
                    <?php if(json_decode($order->shipping_address)): ?>
                        <address>
                            <strong class="text-main">
                                <?php echo e(json_decode($order->shipping_address)->name); ?>

                            </strong><br>
                            <?php echo e(json_decode($order->shipping_address)->email); ?><br>
                            <?php echo e(json_decode($order->shipping_address)->phone); ?><br>
                            <?php echo e(json_decode($order->shipping_address)->address); ?>, <?php echo e(json_decode($order->shipping_address)->city); ?>, <?php if(isset(json_decode($order->shipping_address)->state)): ?> <?php echo e(json_decode($order->shipping_address)->state); ?> - <?php endif; ?> <?php echo e(json_decode($order->shipping_address)->postal_code); ?><br>
                            <?php echo e(json_decode($order->shipping_address)->country); ?>

                        </address>
                    <?php else: ?>
                        <address>
                            <strong class="text-main">
                                <?php echo e($order->user->name); ?>

                            </strong><br>
                            <?php echo e($order->user->email); ?><br>
                            <?php echo e($order->user->phone); ?><br>
                        </address>
                    <?php endif; ?>
                    <?php if($order->manual_payment && is_array(json_decode($order->manual_payment_data, true))): ?>
                        <br>
                        <strong class="text-main"><?php echo e(translate('Payment Information')); ?></strong><br>
                        <?php echo e(translate('Name')); ?>: <?php echo e(json_decode($order->manual_payment_data)->name); ?>,
                        <?php echo e(translate('Amount')); ?>:
                        <?php echo e(single_price(json_decode($order->manual_payment_data)->amount)); ?>,
                        <?php echo e(translate('TRX ID')); ?>: <?php echo e(json_decode($order->manual_payment_data)->trx_id); ?>

                        <br>
                        <a href="<?php echo e(uploaded_asset(json_decode($order->manual_payment_data)->photo)); ?>" target="_blank">
                            <img src="<?php echo e(uploaded_asset(json_decode($order->manual_payment_data)->photo)); ?>" alt=""
                                height="100">
                        </a>
                        <br>
                    <?php endif; ?>

                     <!-- Sold BY -->
                    <strong class="text-main"><?php echo e(translate('Sold By')); ?>: </strong>
                    <br>
                    <?php echo e($order->shop->name ?? get_setting('site_name')); ?>


                    <?php if(!empty($order->seller->phone)): ?>
                        <br>
                        <strong class="text-main"><?php echo e($order->seller->phone); ?></strong>
                    <?php endif; ?>

                    <?php 
                        $gstin = get_seller_gstin($order);
                    ?>

                    <?php if($gstin && is_numeric($first_order->gst_amount)): ?>
                        <br>
                        <strong class="text-main"><?php echo e(translate('GSTIN')); ?>:</strong> <?php echo e($gstin); ?>

                    <?php endif; ?>

                    <br>
                    <strong class="text-main"> <?php echo e(get_seller_address($order)); ?> </strong>

                    
                </div>
                <div class="col-md-4">
                    <table class="ml-auto">
                        <tbody>
                            <tr>
                                <td class="text-main text-bold"><?php echo e(translate('Order #')); ?></td>
                                <td class="text-info text-bold text-right"> <?php echo e($order->code); ?></td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold"><?php echo e(translate('Order Status')); ?></td>
                                <td class="text-right">
                                    <?php if($delivery_status == 'delivered'): ?>
                                        <span class="badge badge-inline badge-success">
                                            <?php echo e(translate(ucfirst(str_replace('_', ' ', $delivery_status)))); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-inline badge-info">
                                            <?php echo e(translate(ucfirst(str_replace('_', ' ', $delivery_status)))); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold"><?php echo e(translate('Order Date')); ?> </td>
                                <td class="text-right"><?php echo e(date('d-m-Y h:i A', $order->date)); ?></td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">
                                    <?php echo e(translate('Total amount')); ?>

                                </td>
                                <td class="text-right">
                                    <?php echo e(single_price($order->grand_total)); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold"><?php echo e(translate('Payment method')); ?></td>
                                <td class="text-right">
                                    <?php echo e(translate(ucfirst(str_replace('_', ' ', $order->payment_type)))); ?></td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold"><?php echo e(translate('Additional Info')); ?></td>
                                <td class="text-right"><?php echo e($order->additional_info); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table-bordered aiz-table invoice-summary table">
                        <thead>
                            <tr class="bg-trans-dark">
                                <th data-breakpoints="lg" class="min-col">#</th>
                                <th width="10%"><?php echo e(translate('Photo')); ?></th>
                                <th class="text-uppercase"><?php echo e(translate('Description')); ?></th>
                                <th data-breakpoints="lg" class="text-uppercase"><?php echo e(translate('Delivery Type')); ?></th>
                                <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                                    <?php echo e(translate('Qty')); ?>

                                </th>

                                <?php if(is_numeric($first_order->gst_amount)): ?>
                                <th data-breakpoints="lg"><?php echo e(translate('Gross Amount')); ?></th>
                                <th data-breakpoints="lg"><?php echo e(translate('Discount/ Coupon')); ?></th>
                                <th data-breakpoints="lg"><?php echo e(translate('Taxable Value')); ?></th>

                                <?php if(same_state_shipping($order)): ?>
                                <th data-breakpoints="lg"><?php echo e(translate('CGST')); ?></th>
                                <th data-breakpoints="lg"><?php echo e(translate('SGST')); ?></th>
                                <?php else: ?>
                                <th data-breakpoints="lg"><?php echo e(translate('IGST')); ?></th>
                                <?php endif; ?>

                                <?php else: ?>
                                <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                                    <?php echo e(translate('Price')); ?></th>
                                <?php endif; ?>
                                
                                <th data-breakpoints="lg" class="min-col text-uppercase text-right">
                                    <?php echo e(translate('Total')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td>
                                        <?php if($orderDetail->product != null && $orderDetail->product->auction_product == 0): ?>
                                            <a href="<?php echo e(route('product', $orderDetail->product->slug)); ?>" target="_blank">
                                                <img height="50" src="<?php echo e(uploaded_asset($orderDetail->product->thumbnail_img)); ?>">
                                            </a>
                                        <?php elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1): ?>
                                            <a href="<?php echo e(route('auction-product', $orderDetail->product->slug)); ?>" target="_blank">
                                                <img height="50" src="<?php echo e(uploaded_asset($orderDetail->product->thumbnail_img)); ?>">
                                            </a>
                                        <?php else: ?>
                                            <strong><?php echo e(translate('N/A')); ?></strong>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($orderDetail->product != null && $orderDetail->product->auction_product == 0): ?>
                                            <strong>
                                                <a href="<?php echo e(route('product', $orderDetail->product->slug)); ?>" target="_blank"
                                                    class="text-muted">
                                                    <?php echo e($orderDetail->product->getTranslation('name')); ?>

                                                </a>
                                            </strong>
                                            <small>
                                                <?php echo e($orderDetail->variation); ?>

                                            </small>
                                            <br>
                                            <small>
                                                <?php
                                                    $product_stock = $orderDetail->product->stocks->where('variant', $orderDetail->variation)->first();
                                                ?>
                                                <?php echo e(translate('SKU')); ?>: <?php echo e($product_stock['sku'] ?? ''); ?>

                                            </small>
                                        <?php elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1): ?>
                                            <strong>
                                                <a href="<?php echo e(route('auction-product', $orderDetail->product->slug)); ?>" target="_blank"
                                                    class="text-muted">
                                                    <?php echo e($orderDetail->product->getTranslation('name')); ?>

                                                </a>
                                            </strong>
                                        <?php else: ?>
                                            <strong><?php echo e(translate('Product Unavailable')); ?></strong>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($order->shipping_type != null && $order->shipping_type == 'home_delivery'): ?>
                                            <?php echo e(translate('Home Delivery')); ?>

                                        <?php elseif($order->shipping_type == 'pickup_point'): ?>
                                            <?php if($order->pickup_point != null): ?>
                                                <?php echo e($order->pickup_point->getTranslation('name')); ?>

                                                (<?php echo e(translate('Pickup Point')); ?>)
                                            <?php else: ?>
                                                <?php echo e(translate('Pickup Point')); ?>

                                            <?php endif; ?>
                                        <?php elseif($order->shipping_type == 'carrier'): ?>
                                            <?php if($order->carrier != null): ?>
                                                <?php echo e($order->carrier->name); ?> (<?php echo e(translate('Carrier')); ?>)
                                                <br>
                                                <?php echo e(translate('Transit Time').' - '.$order->carrier->transit_time); ?>

                                            <?php else: ?>
                                                <?php echo e(translate('Carrier')); ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo e($orderDetail->quantity); ?>

                                    </td>
                                    <?php if(is_numeric($first_order->gst_amount)): ?>
                                    <td class="text-center">
                                        <?php echo e(single_price($orderDetail->price)); ?>

                                    </td>

                                    <td class="text-center">
                                        <?php echo e(single_price($orderDetail->coupon_discount)); ?>

                                    </td>

                                    <td class="text-center">
                                        <?php echo e(single_price($orderDetail->price - $orderDetail->coupon_discount)); ?>

                                    </td>
                                    
                                    <?php 
                                        $gst_amount = get_gst_by_price_and_rate($orderDetail->price - $orderDetail->coupon_discount , $orderDetail->gst_rate);
                                        $shipping_gst = get_gst_by_price_and_rate($orderDetail->shipping_cost, $orderDetail->gst_rate);
                                    ?>

                                    <?php if(same_state_shipping($order)): ?>
                                    <td class="text-center">
                                        <?php echo e(single_price($gst_amount/2)); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(single_price($gst_amount/2)); ?>

                                    </td>
                                    <?php else: ?>
                                    <td class="text-center">
                                        <?php echo e(single_price($gst_amount)); ?>

                                    </td>	
                                    <?php endif; ?>

                                    <?php else: ?>
                                    <td class="text-center">
                                        <?php echo e(single_price($orderDetail->price / $orderDetail->quantity)); ?>

                                    </td>
                                    <?php endif; ?>

                                    <?php if(is_numeric($first_order->gst_amount)): ?>
                                    <td class="text-center"><?php echo e(single_price($orderDetail->price - $orderDetail->coupon_discount + $gst_amount)); ?></td>
                                    <?php else: ?>
                                    <td class="text-center">
                                        <?php echo e(single_price($orderDetail->price)); ?>

                                    </td>
                                    <?php endif; ?>
                                </tr>

                                <?php if(is_numeric($first_order->gst_amount)): ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">
                                        <?php echo e(translate('Shipping')); ?>

                                    </td>
                                    <td></td>
                                    <td class="text-center">
                                        1
                                    </td>
                                    <td class="text-center">
                                        <?php echo e(single_price($orderDetail->shipping_cost)); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(single_price(0)); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(single_price($orderDetail->shipping_cost)); ?>

                                    </td>
                                    <?php if(same_state_shipping($order)): ?>
                                    <td class="text-center">
                                        <?php echo e(single_price($shipping_gst/2)); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(single_price($shipping_gst/2)); ?>

                                    </td>
                                    <?php else: ?>
                                    <td class="text-center">
                                        <?php echo e(single_price($shipping_gst)); ?>

                                    </td>
                                    <?php endif; ?>
                                    <td class="text-center"><?php echo e(single_price($orderDetail->shipping_cost + (($orderDetail->shipping_cost* $orderDetail->gst_rate)/100))); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix float-right">
                <table class="table">
                    <tbody>

                        <?php if(is_numeric($first_order->gst_amount)): ?>

                        <tr>
                            <td>
                                <strong class="text-muted"><?php echo e(translate('Sub Total')); ?> :</strong>
                            </td>
                            <td>
                                <?php echo e(single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('shipping_cost') - $order->orderDetails->sum('coupon_discount'))); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted"><?php echo e(translate('Total GST')); ?> :</strong>
                            </td>
                            <td>
                                <?php echo e(single_price($order->orderDetails->sum('gst_amount'))); ?>

                            </td>
                        </tr>
                        
                        <?php else: ?>
                        <tr>
                            <td>
                                <strong class="text-muted"><?php echo e(translate('Sub Total')); ?> :</strong>
                            </td>
                            <td>
                                <?php echo e(single_price($order->orderDetails->sum('price'))); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted"><?php echo e(translate('Tax')); ?> :</strong>
                            </td>
                            <td>
                                <?php echo e(single_price($order->orderDetails->sum('tax'))); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted"><?php echo e(translate('Shipping')); ?> :</strong>
                            </td>
                            <td>
                                <?php echo e(single_price($order->orderDetails->sum('shipping_cost'))); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted"><?php echo e(translate('Coupon')); ?> :</strong>
                            </td>
                            <td>
                                <?php echo e(single_price($order->coupon_discount)); ?>

                            </td>
                        </tr>
                        <?php if(($order->mlm_wallet_used ?? 0) > 0): ?>
<tr>
    <td>
        <strong class="text-success"><?php echo e(translate('MLM Wallet Used')); ?> :</strong>
    </td>
    <td class="text-success">
        - <?php echo e(single_price($order->mlm_wallet_used)); ?>

    </td>
</tr>
<?php endif; ?>
                        <?php endif; ?>
                        <tr>
                            <td>
                                <strong class="text-muted"><?php echo e(translate('TOTAL')); ?> :</strong>
                            </td>
                            <td class="text-muted h5">
                                <?php echo e(single_price($order->grand_total)); ?>

                            </td>
                        </tr>
                        
                    </tbody>
                </table>
                <div class="no-print text-right">
                    <a href="<?php echo e(route('invoice.download', $order->id)); ?>" type="button" class="btn btn-icon btn-light"><i
                            class="las la-print"></i></a>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

    <!-- confirm payment Status Modal -->
    <div id="confirm-payment-status" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered" style="max-width: 540px;">
            <div class="modal-content p-2rem">
                <div class="modal-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="64" viewBox="0 0 72 64">
                        <g id="Octicons" transform="translate(-0.14 -1.02)">
                          <g id="alert" transform="translate(0.14 1.02)">
                            <path id="Shape" d="M40.159,3.309a4.623,4.623,0,0,0-7.981,0L.759,58.153a4.54,4.54,0,0,0,0,4.578A4.718,4.718,0,0,0,4.75,65.02H67.587a4.476,4.476,0,0,0,3.945-2.289,4.773,4.773,0,0,0,.046-4.578Zm.6,52.555H31.582V46.708h9.173Zm0-13.734H31.582V23.818h9.173Z" transform="translate(-0.14 -1.02)" fill="#ffc700" fill-rule="evenodd"/>
                          </g>
                        </g>
                    </svg>
                    <p class="mt-3 mb-3 fs-16 fw-700"><?php echo e(translate('Are you sure you want to change the payment status?')); ?></p>
                    <button type="button" class="btn btn-light rounded-2 mt-2 fs-13 fw-700 w-150px" data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                    <button type="button" onclick="update_payment_status()" class="btn btn-success rounded-2 mt-2 fs-13 fw-700 w-150px"><?php echo e(translate('Confirm')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div id="shipping-info" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header bord-btm">
                    <h4 class="modal-title h6"><?php echo e(translate('Shipping Info')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="shipping_info">
                    <div class="modal-body" id="shipping_info">
                        <div id="address-list"></div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal" id="close-button"><?php echo e(translate('Close')); ?></button>
                    <button type="button" class="btn btn-primary btn-styled btn-base-1" id="confirm-address" data-dismiss="modal"><?php echo e(translate('Confirm')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div id="confirm-awb-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="64" viewBox="0 0 72 64">
                        <g id="Octicons" transform="translate(-0.14 -1.02)">
                        <g id="alert" transform="translate(0.14 1.02)">
                            <path id="Shape" d="M40.159,3.309a4.623,4.623,0,0,0-7.981,0L.759,58.153a4.54,4.54,0,0,0,0,4.578A4.718,4.718,0,0,0,4.75,65.02H67.587a4.476,4.476,0,0,0,3.945-2.289,4.773,4.773,0,0,0,.046-4.578Zm.6,52.555H31.582V46.708h9.173Zm0-13.734H31.582V23.818h9.173Z" transform="translate(-0.14 -1.02)" fill="#ffc700" fill-rule="evenodd"/>
                        </g>
                        </g>
                    </svg>
                    <p class="mt-3 mb-3 fs-16 fw-700"><?php echo e(translate('Would you like to assign a courier and generate the AWB code for this order?')); ?></p>
                    <button type="button" class="btn btn-light rounded-2 mt-2 fs-13 fw-700 w-150px" data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                    <button type="button" id="confirm-awb-btn" class="btn btn-success rounded-2 mt-2 fs-13 fw-700 w-150px"><?php echo e(translate('Confirm')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div id="confirm-pickup-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="64" viewBox="0 0 72 64">
                        <g id="Octicons" transform="translate(-0.14 -1.02)">
                          <g id="alert" transform="translate(0.14 1.02)">
                            <path id="Shape" d="M40.159,3.309a4.623,4.623,0,0,0-7.981,0L.759,58.153a4.54,4.54,0,0,0,0,4.578A4.718,4.718,0,0,0,4.75,65.02H67.587a4.476,4.476,0,0,0,3.945-2.289,4.773,4.773,0,0,0,.046-4.578Zm.6,52.555H31.582V46.708h9.173Zm0-13.734H31.582V23.818h9.173Z" transform="translate(-0.14 -1.02)" fill="#ffc700" fill-rule="evenodd"/>
                          </g>
                        </g>
                    </svg>

                    <p class="mt-3 mb-3 fs-16 fw-700">
                        <?php echo e(translate('Would you like to request a pickup for this order? The courier will be notified upon confirmation.')); ?>

                    </p>

                    <button type="button"
                            class="btn btn-light rounded-2 mt-2 fs-13 fw-700 w-150px"
                            data-dismiss="modal">
                        <?php echo e(translate('Cancel')); ?>

                    </button>

                    <button type="button"
                            id="confirm-pickup-btn"
                            class="btn btn-warning rounded-2 mt-2 fs-13 fw-700 w-150px">
                        <?php echo e(translate('Confirm Pickup')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="steadfastConfirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    <!-- Icon (warning style like your other modals) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="64" viewBox="0 0 72 64">
                        <g id="Octicons" transform="translate(-0.14 -1.02)">
                          <g id="alert" transform="translate(0.14 1.02)">
                            <path id="Shape" d="M40.159,3.309a4.623,4.623,0,0,0-7.981,0L.759,58.153a4.54,4.54,0,0,0,0,4.578A4.718,4.718,0,0,0,4.75,65.02H67.587a4.476,4.476,0,0,0,3.945-2.289,4.773,4.773,0,0,0,.046-4.578Zm.6,52.555H31.582V46.708h9.173Zm0-13.734H31.582V23.818h9.173Z" transform="translate(-0.14 -1.02)" fill="#ffc700" fill-rule="evenodd"/>
                          </g>
                        </g>
                    </svg>

                    <!-- Text -->
                    <p class="mt-3 mb-3 fs-16 fw-700">
                        <?php echo e(translate('Would you like to create this order in Steadfast Courier?')); ?>

                    </p>

                    <!-- Buttons -->
                    <button type="button"
                            class="btn btn-light rounded-2 mt-2 fs-13 fw-700 w-150px"
                            id="steadfastCancelBtn"
                            data-dismiss="modal">
                        <?php echo e(translate('Cancel')); ?>

                    </button>

                    <button type="button"
                            class="btn btn-success rounded-2 mt-2 fs-13 fw-700 w-150px"
                            id="steadfastConfirmBtn">
                        <?php echo e(translate('Confirm')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="pathao-info" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header bord-btm">
                    <h4 class="modal-title h6"><?php echo e(translate('Select Store Name')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="pathao_info">
                    <div class="modal-body" id="pathao_info">
                        <div id="store-list"></div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal" id="close-button"><?php echo e(translate('Close')); ?></button>
                    <button type="button" class="btn btn-primary btn-styled btn-base-1" id="confirm-store" data-dismiss="modal"><?php echo e(translate('Confirm')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function() {
            var order_id = <?php echo e($order->id); ?>;
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('<?php echo e(route('orders.delivery-boy-assign')); ?>', {
                _token: '<?php echo e(@csrf_token()); ?>',
                order_id: order_id,
                delivery_boy: delivery_boy
            }, function(data) {
                AIZ.plugins.notify('success', '<?php echo e(translate('Delivery boy has been assigned')); ?>');
            });
        });
        $('#update_delivery_status').on('change', function() {
            var order_id = <?php echo e($order->id); ?>;
            var status = $('#update_delivery_status').val();
            $.post('<?php echo e(route('orders.update_delivery_status')); ?>', {
                _token: '<?php echo e(@csrf_token()); ?>',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success', '<?php echo e(translate('Delivery status has been updated')); ?>');
                location.reload();
            });
        });

        // Payment Status Update
        function confirm_payment_status(value){
            $('#confirm-payment-status').modal('show');
        }

        function update_payment_status(){
            $('#confirm-payment-status').modal('hide');
            var order_id = <?php echo e($order->id); ?>;
            $.post('<?php echo e(route('orders.update_payment_status')); ?>', {
                _token: '<?php echo e(@csrf_token()); ?>',
                order_id: order_id,
                status: 'paid'
            }, function(data) {
                $('#update_payment_status').prop('disabled', true);
                AIZ.plugins.bootstrapSelect('refresh');
                AIZ.plugins.notify('success', '<?php echo e(translate('Payment status has been updated')); ?>');
                location.reload();
            });
        }

        $('#update_tracking_code').on('change', function() {
            var order_id = <?php echo e($order->id); ?>;
            var tracking_code = $('#update_tracking_code').val();
            $.post('<?php echo e(route('orders.update_tracking_code')); ?>', {
                _token: '<?php echo e(@csrf_token()); ?>',
                order_id: order_id,
                tracking_code: tracking_code
            }, function(data) {
                AIZ.plugins.notify('success', '<?php echo e(translate('Order tracking code has been updated')); ?>');
            });
        });
    </script>

    <?php if(addon_is_activated('shiprocket')): ?>
    <script type="text/javascript">

        function loadShippingInfoForShiprocket(sellerId) {
            $('#address-list').html('<p class="text-muted"><?php echo e(translate("Loading...")); ?></p>');

            $.when(
                $.ajax({
                    url: "<?php echo e(route('pickup.addresses.list')); ?>",
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': AIZ.data.csrf },
                    data: { user_id: sellerId, shipping_system: 'shiprocket' }
                }),
                $.ajax({
                    url: "<?php echo e(route('box.sizes.list')); ?>",
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': AIZ.data.csrf },
                    data: { user_id: sellerId, shipping_system: 'shiprocket' }
                })
            ).done(function(pickupResponse, boxResponse) {
                let html = '';

                const pickupAddresses = pickupResponse[0] || [];
                html += `<label class="fw-700 d-block mb-2"><?php echo e(translate('Address Nickname')); ?></label>`;
                if (pickupAddresses.length > 0) {
                    pickupAddresses.forEach(addr => {
                        html += `
                            <div class="border p-3 mb-3 rounded">
                                <div class="form-check">
                                    <input class="magic-radio" type="radio" name="pickup_address_id" value="${addr.id}" id="addr_${addr.id}">
                                    <label class="form-check-label" for="addr_${addr.id}">
                                        ${addr.address_nickname || '<?php echo e(translate('No location')); ?>'}
                                    </label>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html += `<p class="text-muted mb-4"><?php echo e(translate('No pickup address found.')); ?></p>`;
                }

                const boxSizes = boxResponse[0] || [];
                html += `<label class="fw-700 d-block mb-2"><?php echo e(translate('Box Size (Length × Breadth × Height)')); ?></label>`;
                if (boxSizes.length > 0) {
                    boxSizes.forEach(box => {
                        const dims = `${box.length} × ${box.breadth} × ${box.height} cm`;
                        html += `
                            <div class="border p-3 mb-3 rounded">
                                <div class="form-check">
                                    <input class="magic-radio" type="radio" name="box_size_id" value="${box.id}" id="box_${box.id}">
                                    <label class="form-check-label" for="box_${box.id}">
                                        ${dims}
                                    </label>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html += `<p class="text-muted"><?php echo e(translate('No box sizes found.')); ?></p>`;
                }

                $('#address-list').html(html);
            }).fail(function() {
                $('#address-list').html('<p class="text-danger"><?php echo e(translate("Failed to load shipping information.")); ?></p>');
            });
        }

        $(document).ready(function () {

            const $select = $('#select_shipping_info');

            if ($select.length) {
                $select.on('change', function () {
                    if ($(this).val() === 'shiprocket') {
                        loadShippingInfoForShiprocket(<?php echo e(Auth::id()); ?>);
                        $('#shipping-info').modal('show');
                    }
                });
            }

            $('#confirm-address').on('click', function () {
                const pickupId = $('input[name="pickup_address_id"]:checked').val();
                const boxId = $('input[name="box_size_id"]:checked').val();

                if (!pickupId || !boxId) {
                    AIZ.plugins.notify('warning', '<?php echo e(translate("Please select pickup address and box size.")); ?>');
                    return;
                }

                $.post("<?php echo e(route('orders.confirm_shiprocket_info')); ?>", {
                    _token: AIZ.data.csrf,
                    order_id: <?php echo e($order->id); ?>,
                    pickup_address_id: pickupId,
                    shipping_box_size_id: boxId
                }, function (response) {
                    if (response.success) {
                        AIZ.plugins.notify('success', response.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', response.message);
                    }
                });
            });
        });

        $(document).ready(function () {
        
            const orderId = <?php echo e($order->id); ?>;
            const shipmentId = "<?php echo e($order->shiprocket_shipment_id); ?>";
            const courierAssigned = <?php echo e($order->shiprocket_courier_id ? 'true' : 'false'); ?>;
        
            if (!shipmentId || courierAssigned) return;
        
            $.post("<?php echo e(route('shiprocket.couriers')); ?>", {
                _token: AIZ.data.csrf,
                order_id: orderId
            }).done(function (res) {
        
                if (!res.success) {
                    AIZ.plugins.notify('danger', res.message);
                    return;
                }
        
                let html = '<option value=""><?php echo e(translate("Select Courier")); ?></option>';
        
                res.couriers.forEach(c => {
                    html += `<option value="${c.id}">${c.name}</option>`;
                });
        
                $('#shiprocket_courier')
                    .html(html)
                    .selectpicker('refresh');
            });
        
            $('#shiprocket_courier').on('change', function () {
                if ($(this).val()) {
                    $('#confirm-awb-modal').modal('show');
                }
            });
        
        $('#confirm-awb-btn').on('click', function () {
        
            const selectedCourierId = $('#shiprocket_courier').val();
        
            if (!selectedCourierId) {
                AIZ.plugins.notify('warning', '<?php echo e(translate("Please select a courier first.")); ?>');
                return;
            }
        
            $('#confirm-awb-modal').modal('hide');
        
            $.post("<?php echo e(route('shiprocket.assign.awb')); ?>", {
                _token: AIZ.data.csrf,
                order_id: orderId,
                courier_id: selectedCourierId
            }).done(function (res) {
                if (res.success) {
                    AIZ.plugins.notify('success', res.message);
                    location.reload();
                } else {
                    AIZ.plugins.notify('danger', res.message);
                }
            });
        });
        
        
        $('#confirm-awb-modal').on('hidden.bs.modal', function () {
            $('#shiprocket_courier').selectpicker('val', '');
        });
        
        });


        $(document).ready(function () {

            let pickupOrderId = <?php echo e($order->id); ?>;

            $('#request-pickup-btn').on('click', function () {
                $('#confirm-pickup-modal').modal('show');
            });

            $('#confirm-pickup-btn').on('click', function () {

                $('#confirm-pickup-modal').modal('hide');

                $.post("<?php echo e(route('shiprocket.request.pickup')); ?>", {
                    _token: AIZ.data.csrf,
                    order_id: pickupOrderId
                }).done(function (res) {

                    if (res.success) {
                        AIZ.plugins.notify('success', res.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', res.message);
                    }
                });
            });

        });
    </script>
    <?php endif; ?>

    <?php if(addon_is_activated('steadfast')): ?>
        <script>
            let previousShippingSystem = null;
            let selectedOrderId = <?php echo e($order->id); ?>;

            $('#select_shipping_info').on('focus', function () {
                previousShippingSystem = $(this).val();
            });

            $('#select_shipping_info').on('change', function () {
                let shippingSystem = $(this).val();

                if (shippingSystem === 'steadfast') {
                    $('#steadfastConfirmModal').modal('show');
                }
            });

            // Cancel Button
            $('#steadfastCancelBtn').on('click', function () {
                $('#steadfastConfirmModal').modal('hide');
                $('#select_shipping_info')
                    .val(previousShippingSystem)
                    .selectpicker('refresh');
            });

            // Confirm Button
            $('#steadfastConfirmBtn').on('click', function () {

                $('#steadfastConfirmBtn').prop('disabled', true).text('Processing...');

                $.ajax({
                    url: "<?php echo e(route('steadfast.create.order')); ?>",
                    method: "POST",
                    data: {
                        _token: AIZ.data.csrf,
                        order_id: selectedOrderId
                    },
                    success: function (res) {
                        if (res.success) {
                            AIZ.plugins.notify('success', res.message);
                            location.reload();
                        } else {
                            AIZ.plugins.notify('danger', res.message);
                        }
                    },
                    error: function () {
                        AIZ.plugins.notify('danger', 'Something went wrong');
                    },
                    complete: function () {
                        $('#steadfastConfirmBtn')
                            .prop('disabled', false)
                            .text('Confirm');
                        $('#steadfastConfirmModal').modal('hide');
                    }
                });

            });
        </script>
    <?php endif; ?>

    <?php if(addon_is_activated('pathao')): ?>
        <script type="text/javascript">

            function loadStoreInfoForPathao() {
                $('#store-list').html('<p class="text-muted"><?php echo e(translate("Loading...")); ?></p>');

                $.ajax({
                    url: "<?php echo e(route('pathao.all.store')); ?>",
                    type: 'GET',
                    headers: { 'X-CSRF-TOKEN': AIZ.data.csrf },
                    success: function (res) {

                        if (!res.success) {
                            $('#store-list').html('<p class="text-danger">'+res.message+'</p>');
                            return;
                        }

                        let html = '';
                        const stores = res.stores || [];

                        html += `<label class="fw-700 d-block mb-2"><?php echo e(translate('Store Name')); ?></label>`;

                        if (stores.length > 0) {
                            stores.forEach(store => {
                                html += `
                                    <div class="border p-3 mb-2 rounded">
                                        <div class="form-check">
                                            <input class="magic-radio" type="radio"
                                                name="store_id"
                                                value="${store.store_id}"
                                                id="store_${store.store_id}">
                                            <label class="form-check-label" for="store_${store.store_id}">
                                                ${store.store_name}
                                            </label>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            html += `<p class="text-muted"><?php echo e(translate('No store found.')); ?></p>`;
                        }

                        $('#store-list').html(html);
                    },
                    error: function () {
                        $('#store-list').html('<p class="text-danger">API Error</p>');
                    }
                });
            }

            $(document).ready(function () {

                $('#select_shipping_info').on('change', function () {

                    if ($(this).val() === 'pathao') {
                        loadStoreInfoForPathao();
                        $('#pathao-info').modal('show');
                    }
                });

                $('#confirm-store').on('click', function () {

                    let storeId = $('input[name="store_id"]:checked').val();

                    if (!storeId) {
                        AIZ.plugins.notify('warning', '<?php echo e(translate("Please select store")); ?>');
                        return;
                    }

                    $.post("<?php echo e(route('pathao.create.order')); ?>", {
                        _token: AIZ.data.csrf,
                        order_id: <?php echo e($order->id); ?>,
                        store_id: storeId
                    }, function (res) {

                        if (res.success) {
                            AIZ.plugins.notify('success', res.message);
                            location.reload();
                        } else {
                            AIZ.plugins.notify('danger', res.message);
                        }
                    });
                });

            });

        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/sales/show.blade.php ENDPATH**/ ?>