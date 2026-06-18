

<?php $__env->startSection('panel_content'); ?>



<div class="aiz-titlebar mt-2 mb-4">

    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">User Management</h1>
        </div>

        <div class="col-auto">

            <a href="<?php echo e(route('agent.users.create')); ?>"
               class="btn btn-primary">

                <i class="las la-plus"></i>

                Create User Account

            </a>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">
        <h5 class="mb-0 h6">Users Created By Me</h5>
    </div>

    <div class="card-body">
<div class="mb-4">
    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a class="nav-link <?php echo e($status == 'active' ? 'active' : ''); ?>"
               href="<?php echo e(route('agent.users',['status'=>'active'])); ?>">
                <i class="las la-user-check"></i>
                Active Users
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e($status == 'inactive' ? 'active' : ''); ?>"
               href="<?php echo e(route('agent.users',['status'=>'inactive'])); ?>">
                <i class="las la-user-clock"></i>
                Inactive Users
            </a>
        </li>

    </ul>
</div>
        <table class="table aiz-table mb-0">

            <thead>

                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Referral Code</th>
           <?php if($status == 'active'): ?>
    <th>View Orders</th>
<?php endif; ?>
                     <th>Status</th>
                    <th>Created At</th>
                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($key + 1); ?></td>

                    <td><?php echo e($user->name); ?></td>

                    <td><?php echo e($user->email); ?></td>

                    <td><?php echo e($user->phone); ?></td>

                    <td><?php echo e($user->referral_code); ?></td>
                   <?php if($status == 'active'): ?>
<td>
    <a href="<?php echo e(route('agent.users.orders', encrypt($user->id))); ?>"
       class="btn btn-primary btn-sm">
        <i class="las la-shopping-bag"></i>
        View Orders
    </a>
</td>
<?php endif; ?>

    <td>
    <?php if($user->is_active == 1): ?>
        <span class="p-2 badge-success">Active</span>
    <?php else: ?>
        <span class="p-2 badge-warning">Inactive</span>
    <?php endif; ?>
</td>

                    <td><?php echo e($user->created_at->format('d M Y')); ?></td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="8" class="text-center">
                        No Users Found
                    </td>
                </tr>

                <?php endif; ?>

            </tbody>

        </table>

        <div class="aiz-pagination mt-4">
            <?php echo e($users->links()); ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('agent.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/users/index.blade.php ENDPATH**/ ?>