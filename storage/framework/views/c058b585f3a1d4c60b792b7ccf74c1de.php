

<?php $__env->startSection('panel_content'); ?>

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">
                Orders of <?php echo e($user->name); ?>

            </h1>
        </div>

        <div class="col-auto">
            <a href="<?php echo e(route('agent.users')); ?>"
               class="btn btn-light">
                Back
            </a>
        </div>

    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5 class="mb-0 h6">
            User Orders
        </h5>
    </div>

    <div class="card-body">

        <table class="table aiz-table">

            <thead>

                <tr>
                    <th>Order Code</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($order->code); ?></td>

                    <td>
                        ₹<?php echo e(single_price($order->grand_total)); ?>

                    </td>

                    <td>
                        <?php echo e(ucfirst($order->payment_status)); ?>

                    </td>

                    <td>
                        <?php echo e(ucfirst($order->delivery_status)); ?>

                    </td>

                    <td>
                        <?php echo e(date('d M Y', strtotime($order->created_at))); ?>

                    </td>

                    <td>

                       <a href="<?php echo e(route('agent.orders.details', encrypt($order->id))); ?>"
   class="btn btn-primary btn-sm">
    See Order Details
</a>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>

                    <td colspan="6" class="text-center">
                        No Orders Found
                    </td>

                </tr>

                <?php endif; ?>

            </tbody>

        </table>

        <div class="aiz-pagination">
            <?php echo e($orders->links()); ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('agent.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/users/orders.blade.php ENDPATH**/ ?>