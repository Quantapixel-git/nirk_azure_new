

<?php $__env->startSection('content'); ?>





<div class="card">
    <div class="card-body">

        <h4>User Details</h4>

        <p><b>Name :</b> <?php echo e($user->name); ?></p>
        <p><b>Email :</b> <?php echo e($user->email); ?></p>

        <hr>

        <h5>Wallet Summary</h5>

        <p><b>Confirmed Coins :</b> <?php echo e($confirmedCoins); ?></p>
        <!-- <p><b>Confirmed Value :</b> ₹ <?php echo e($confirmedValue); ?></p> -->

        <p><b>Hold Coins :</b> <?php echo e($holdCoins); ?></p>
        <!-- <p><b>Hold Value :</b> ₹ <?php echo e($holdValue); ?></p> -->

        <hr>

        <table class="table aiz-table">

           <thead>
    <tr>
        <th>#</th>
        <th>PT Coins</th>
        <th>PT Value</th>
        <th>Level</th>
        <th>View Orders</th>
        <th>Status</th>
    </tr>
</thead>

<tbody>

<?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


<tr>

    <td><?php echo e($key+1); ?></td>

    <td><?php echo e($trx->pt_coins); ?></td>

    <td>₹ <?php echo e($trx->pt_value); ?></td>

    <td>
        <p>
           <b><?php echo e($trx->level); ?></b>
</p>
    </td>

<td>

    <?php if($trx->order_id): ?>

        <a href="<?php echo e(route('all_orders.show', encrypt($trx->order_id))); ?>"
           class="btn btn-primary btn-sm"
           target="_blank">

            View Order

        </a>

    <?php else: ?>

        <span class="badge badge-danger">
            No Order
        </span>

    <?php endif; ?>

</td>
    <td>
        <?php if($trx->wallet_status == 1): ?>
            <button class="btn btn-success btn-sm">Confirmed</button>
        <?php else: ?>
            <button class="btn btn-danger btn-sm">Hold</button>
        <?php endif; ?>
    </td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

        </table>

    </div>
</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/mlm_wallet/show.blade.php ENDPATH**/ ?>