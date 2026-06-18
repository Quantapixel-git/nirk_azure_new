

<?php $__env->startSection('panel_content'); ?>
    <div class="card shadow-none rounded-0 border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-20 fw-700 text-dark"><?php echo e(translate('Completed Delivery History')); ?></h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead class="text-gray fs-12">
                    <tr>
                        <th class="pl-0"><?php echo e(translate('Code')); ?></th>
                        <th><?php echo e(translate('Date')); ?></th>
                        <th><?php echo e(translate('Amount')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Delivery Status')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Payment Status')); ?></th>
                        <th class="text-right pr-0"><?php echo e(translate('Options')); ?></th>
                    </tr>
                </thead>
                <tbody class="fs-14">
                    <?php $__currentLoopData = $completed_deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(optional($delivery->order)->code): ?>
                            <tr>
                                <!-- Code -->
                                <td class="pl-0" style="vertical-align: middle;">
                                    <a href="<?php echo e(route('delivery-boy.order-detail', encrypt($delivery->order->id))); ?>"><?php echo e($delivery->order->code); ?></a>
                                </td>
                                <!-- Date -->
                                <td class="text-secondary" style="vertical-align: middle;">
                                    <?php echo e(date('d-m-Y h:i A', strtotime($delivery->created_at))); ?>

                                </td>
                                <!-- Amount -->
                                <td class="fw-700" style="vertical-align: middle;">
                                    <?php echo e(single_price($delivery->collection)); ?>

                                </td>
                                <!-- Delivery Status -->
                                <td class="fw-700" style="vertical-align: middle;">
                                    <?php echo e(translate(ucfirst(str_replace('_', ' ', $delivery->delivery_status)))); ?>

                                </td>
                                <!-- Payment Status -->
                                <td style="vertical-align: middle;">
                                    <?php if($delivery->order->payment_status == 'paid'): ?>
                                        <span class="badge badge-inline badge-success p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;"><?php echo e(translate('Paid')); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-inline badge-danger p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;"><?php echo e(translate('Unpaid')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <!-- Options -->
                                <td class="text-right pr-0" style="vertical-align: middle;">
                                    <a href="<?php echo e(route('delivery-boy.order-detail', encrypt($delivery->order->id))); ?>" class="btn btn-soft-info btn-icon btn-circle btn-sm hov-svg-white" title="<?php echo e(translate('Order Details')); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                            <g id="Group_24807" data-name="Group 24807" transform="translate(-1339 -422)">
                                                <rect id="Rectangle_18658" data-name="Rectangle 18658" width="12" height="1" transform="translate(1339 422)" fill="#3490f3"/>
                                                <rect id="Rectangle_18659" data-name="Rectangle 18659" width="12" height="1" transform="translate(1339 425)" fill="#3490f3"/>
                                                <rect id="Rectangle_18660" data-name="Rectangle 18660" width="12" height="1" transform="translate(1339 428)" fill="#3490f3"/>
                                                <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12" height="1" transform="translate(1339 431)" fill="#3490f3"/>
                                            </g>
                                        </svg>
                                    </a>
                                    <a class="btn btn-soft-warning btn-icon btn-circle btn-sm" href="<?php echo e(route('invoice.download', $delivery->order->id)); ?>" title="<?php echo e(translate('Download Invoice')); ?>">
                                        <i class="las la-download"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="aiz-pagination mt-2">
                <?php echo e($completed_deliveries->appends(request()->input())->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('delivery_boys.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/delivery_boys/completed_delivery.blade.php ENDPATH**/ ?>