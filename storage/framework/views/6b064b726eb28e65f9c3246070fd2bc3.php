

<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3">
                <?php echo e(translate('Blocked MLM Users')); ?>

            </h1>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <?php echo e(translate('Blocked MLM Users List')); ?>

        </h5>
    </div>

    <div class="card-body">

        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo e(translate('Name')); ?></th>
                    <th><?php echo e(translate('Email')); ?></th>
                    <th><?php echo e(translate('Total Referrals')); ?></th>
                    <th><?php echo e(translate('Joined On')); ?></th>
                    <th><?php echo e(translate('Blocked Date')); ?></th>
                    <th><?php echo e(translate('Last Activated')); ?></th>
                    <th><?php echo e(translate('Status')); ?></th>
                    <th width="250"><?php echo e(translate('Action')); ?></th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $inactiveUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td>
                        <?php echo e($key + 1); ?>

                    </td>

                    <td>
                        <strong><?php echo e($user->name); ?></strong>
                    </td>

                    <td>
                        <?php echo e($user->email); ?>

                    </td>

                    <td>
                        <span class="badge badge-info">
                            <?php echo e($user->total_referrals); ?>

                        </span>
                    </td>

                    <td>
                        <?php echo e(\Carbon\Carbon::parse($user->created_at)->format('d M Y')); ?>

                    </td>

                    <td>
                        <?php if($user->mlm_blocked_at): ?>
                            <span class="text-danger">
                                <?php echo e(\Carbon\Carbon::parse($user->mlm_blocked_at)->format('d M Y h:i A')); ?>

                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if($user->action_date): ?>
                            <span class="text-success">
                                <?php echo e(\Carbon\Carbon::parse($user->action_date)->format('d M Y h:i A')); ?>

                            </span>
                        <?php else: ?>
                            Never
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if($user->mlm_status == 'blocked'): ?>
                            <span class="badge badge-danger">
                                Blocked
                            </span>
                        <?php else: ?>
                            <span class="badge badge-success">
                                Active
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>

                        <div class="d-flex" style="gap:10px;">

                            
                            <form action="<?php echo e(route('mlm.activate.user',$user->id)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to activate MLM account?')">

                                <?php echo csrf_field(); ?>

                                <button type="submit"
                                        class="btn btn-success btn-sm">
                                    Activate MLM
                                </button>

                            </form>

                            
                            <!-- <form action="<?php echo e(route('mlm.reset.referrals',$user->id)); ?>"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to reset referrals?')">

                                <?php echo csrf_field(); ?>

                                <button type="submit"
                                        class="btn btn-warning btn-sm">
                                    Reset Referrals
                                </button>

                            </form> -->

                        </div>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="9" class="text-center">

                        <div class="py-4">

                            <h5 class="text-muted">
                                <?php echo e(translate('No blocked MLM users found')); ?>

                            </h5>

                        </div>

                    </td>
                </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/mlm/users.blade.php ENDPATH**/ ?>