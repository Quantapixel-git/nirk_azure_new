

<?php $__env->startSection('content'); ?>


<div class="aiz-titlebar mt-2 mb-3">
    <h1 class="h3">MLM Wallet History</h1>
</div>



<div class="card">
    <div class="card-body">

        <table class="table aiz-table mb-0">

            <thead>
                <tr>
                    <th>S.No</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Total Coins</th>
                    <th>Total Value</th>
                    <th class="text-right">Transaction</th>
                </tr>
            </thead>

            <tbody>

                <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>

                    <td><?php echo e($key+1); ?></td>

                    <td><?php echo e($wallet->name); ?></td>

                    <td><?php echo e($wallet->email); ?></td>

                    <td><?php echo e($wallet->total_coins); ?></td>

                    <td>₹ <?php echo e($wallet->total_value); ?></td>

                    <td class="text-right">

                        <a href="<?php echo e(route('mlm.wallet.transactions',$wallet->user_id)); ?>"
                            class="btn btn-soft-primary btn-sm">

                            View Transaction

                        </a>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>

        </table>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/mlm_wallet/index.blade.php ENDPATH**/ ?>