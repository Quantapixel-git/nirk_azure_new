

<?php $__env->startSection('panel_content'); ?>

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">
                Order Details
            </h1>
        </div>

        <div class="col-auto">
            <a href="<?php echo e(url()->previous()); ?>"
               class="btn btn-light">
                Back
            </a>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Customer Information</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">
                <strong>Name</strong>
                <p><?php echo e($customer->name); ?></p>
            </div>

            <div class="col-md-4">
                <strong>Email</strong>
                <p><?php echo e($customer->email); ?></p>
            </div>

            <div class="col-md-4">
                <strong>Phone</strong>
                <p><?php echo e($customer->phone); ?></p>
            </div>

        </div>

    </div>
</div>

<div class="card mt-4">

    <div class="card-header">
        <h5 class="mb-0">Order Information</h5>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Order Code</th>
                <td><?php echo e($order->code); ?></td>
            </tr>

            <tr>
                <th>Grand Total</th>
                <td><?php echo e(single_price($order->grand_total)); ?></td>
            </tr>

            <tr>
                <th>Payment Status</th>
                <td><?php echo e(ucfirst($order->payment_status)); ?></td>
            </tr>

            <tr>
                <th>Delivery Status</th>
                <td><?php echo e(ucfirst($order->delivery_status)); ?></td>
            </tr>

            <tr>
                <th>Order Date</th>
                <td><?php echo e($order->created_at); ?></td>
            </tr>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('agent.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/orders/details.blade.php ENDPATH**/ ?>