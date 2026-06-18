<div class="card-body">
    <table class="table mb-0" id="aiz-data-table">
        <thead>
            <tr>

                <th>
                    <div class="form-group">
                        <div class="aiz-checkbox-inline">
                            <label class="aiz-checkbox pt-5px d-block">
                                <input type="checkbox" class="check-all">
                                <span class="aiz-square-check"></span>
                            </label>
                        </div>
                    </div>
                </th>
                <th class="text-uppercase fs-10 fs-md-12 fw-700 text-secondary"><?php echo e(translate('Order Code')); ?></th>
                <th class="text-uppercase fs-10 fs-md-12 fw-700 text-secondary ml-1 ml-lg-0"><?php echo e(translate('Products')); ?></th>
                <th class="hide-xs text-uppercase fs-10 fs-md-12 fw-700 text-secondary"><?php echo e(translate('Customer')); ?></th>
                <th class="hide-sm text-uppercase fs-12 fw-700 text-secondary"><?php echo e(translate('Seller')); ?></th>
                <th class="hide-md text-uppercase fs-12 fw-700 text-secondary"> <?php echo e(translate('Amount')); ?></th>
                <th class="hide-xl text-uppercase fs-12 fw-700 text-secondary"><?php echo e(translate('Delivery Status')); ?></th>
                <th class="hide-xxl text-uppercase fs-12 fw-700 text-secondary"><?php echo e(translate('Payment method')); ?></th>
                <th class="hide-xxl text-uppercase fs-12 fw-700 text-secondary"><?php echo e(translate('Payment Status')); ?></th>
                <th class="text-right text-uppercase fs-10 fs-md-12 fw-700 text-secondary"><?php echo e(translate('Options')); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="data-row">
                <td class="align-middle w-40px">
                    <div>
                        <button type="button"
                            class="toggle-plus-minus-btn border-0 bg-blue fs-14 fw-500 text-white p-0 align-items-center justify-content-center">+</button>
                    </div>

                    <div class="form-group d-inline-block">
                        <label class="aiz-checkbox">
                            <input type="checkbox" class="check-one" name="id[]" value="<?php echo e($order->id); ?>">
                            <span class="aiz-square-check mt-1"></span>
                        </label>
                    </div>
                </td>

                <td data-label="Order-Code" class="align-middle">
                    <a class="text-blue fw-600" href="<?php echo e(route('seller.orders.show', encrypt($order->id))); ?>"><?php echo e($order->code); ?></a>
                    <?php if($order->shipping_method == 'shiprocket'): ?>
                    <br><span class="fw-bold"><?php echo e(translate('Shiprocket Order Id')); ?>:</span> <?php echo e($order->shiprocket_order_id); ?>

                    <?php endif; ?>
                    <?php if($order->shipping_method == 'steadfast'): ?>
                    <br><span class="fw-bold"><?php echo e(translate('Steadfast Consignment Id')); ?>:</span> <?php echo e($order->steadfast_consignment_id); ?>

                    <?php endif; ?>
                    <?php if($order->shipping_method == 'pathao'): ?>
                    <br><span class="fw-bold"><?php echo e(translate('Pathao Consignment Id')); ?>:</span> <?php echo e($order->pathao_consignment_id); ?>

                    <?php endif; ?>
                    <?php if($order->viewed == 0): ?>
                    <span class="badge badge-inline badge-info"><?php echo e(translate('New')); ?></span>
                    <?php endif; ?>
                    <?php if(addon_is_activated('pos_system') && $order->order_from == 'pos'): ?>
                    <span class="badge badge-inline badge-danger"><?php echo e(translate('POS')); ?></span>
                    <?php endif; ?>
                </td>

                <td class="align-middle" data-label="OrderCount">
                    <?php echo e(count($order->orderDetails)); ?>

                </td>

                <td class="hide-xs align-middle" data-label="Customer">
                    <span class="fs-12 fw-200 text-secondary d-block pt-1">
                        <?php if($order->user != null): ?>
                        <?php echo e($order->user->name); ?>

                        <?php else: ?>
                        Guest (<?php echo e($order->guest_id); ?>)
                        <?php endif; ?>
                    </span>
                </td>

                <td class="hide-sm align-middle" data-label="Owner">
                    <?php $shop = optional($order->shop); ?>
                    <a href="<?php echo e($shop->id ? route('sellers.profile', encrypt($shop->id)) : '#'); ?>" class="fs-12 fs-md-14 fw-700 d-block text-blue">
                         <?php echo e(Str::limit($shop->name, 20)?? ''); ?>

                    </a>
                </td>

                <td class="hide-md align-middle" data-label="Price Details">
                    <div class="border-width-3 border-left border-blue px-2 py-0 mb-1">
                        <p class="fs-16 fw-700 m-0"><?php echo e(single_price($order->grand_total)); ?></p>
                    </div>
                </td>

                <td class="hide-xl align-middle" data-label="Delivery Status">
                    <p class="fs-16 fw-700 m-0 <?php if( $order->delivery_status == 'delivered' ): ?> text-success <?php endif; ?>"><?php echo e(translate(ucfirst(str_replace('_', ' ', $order->delivery_status)))); ?></p>

                    <?php if($order->shipping_method == 'shiprocket'): ?>
                    <span class="fw-bold pt-10px"><?php echo e(translate('Shiprocket Status')); ?>:</span> <?php echo e(ucfirst(translate(str_replace('_', ' ', $order->shiprocket_status)))); ?>

                    <?php elseif($order->shipping_method == 'steadfast'): ?>
                    <span class="fw-bold  pt-10px "><?php echo e(translate('Steadfast Status')); ?>:</span> <?php echo e(ucfirst(translate(str_replace('_', ' ', $order->steadfast_status)))); ?>

                    <?php elseif($order->shipping_method == 'pathao'): ?>
                    <span class="fw-bold pt-10px "><?php echo e(translate('Pathao Status')); ?>:</span> <?php echo e(ucfirst(translate(str_replace('_', ' ', $order->pathao_status)))); ?>

                    <?php endif; ?>
                </td>

                <td class="hide-xxl align-middle" data-label="Payment method">
                    <?php echo e(translate(ucfirst(str_replace('_', ' ', $order->payment_type)))); ?>

                </td>

                <td class="hide-xxl align-middle" data-label="Payment Status">
                    <?php if($order->payment_status == 'paid'): ?>
                    <span class="badge badge-inline badge-success"><?php echo e(translate('Paid')); ?></span>
                    <?php else: ?>
                    <span class="badge badge-inline badge-danger"><?php echo e(translate('Unpaid')); ?></span>
                    <?php endif; ?>
                </td>


                <td class="text-right align-middle">
                    <div class="dropdown float-right">
                        <button class="btn btn-light w-30px h-30px w-sm-35px h-sm-35px d-flex align-items-center justify-content-center action-toggle p-0" type="button"
                            data-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="3" height="16" viewBox="0 0 3 16">
                                <circle cx="1.5" cy="1.5" r="1.5" transform="translate(0 6.5)" />
                                <circle cx="1.5" cy="1.5" r="1.5" transform="translate(0 0)" />
                                <circle cx="1.5" cy="1.5" r="1.5" transform="translate(0 13)" />
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <?php if(addon_is_activated('pos_system') && $order->order_from == 'pos'): ?>
                            <a class="dropdown-item" href="<?php echo e(route('seller.invoice.thermal_printer', $order->id)); ?>" target="_blank">
                                <i class="las la-print mr-2"></i> <?php echo e(translate('Print')); ?>

                            </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('seller.orders.show', encrypt($order->id))); ?>" class="dropdown-item">
                                <i class="las la-eye mr-2"></i> <?php echo e(translate('View Order')); ?>

                            </a>
                            <a class="dropdown-item" href="<?php echo e(route('seller.invoice.download', $order->id)); ?>">
                                <i class="las la-download mr-2"></i> <?php echo e(translate('Download')); ?>

                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="11" class="text-center py-5">
                    <div class="w-100">
                        <h5 class="fs-16 fw-bold text-gray"><?php echo e(translate('No Orders found!')); ?></h5>
                        <i class="las la-frown fs-48 text-soft-white"></i>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($orders->hasPages()): ?>
    <div class="aiz-pagination mt-3" id="pagination">
        <?php echo e($orders->links()); ?>

    </div>
    <?php endif; ?>
</div><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/seller/orders/orders_table.blade.php ENDPATH**/ ?>