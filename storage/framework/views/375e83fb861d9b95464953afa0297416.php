

<?php $__env->startSection('panel_content'); ?>

<div class="aiz-titlebar mt-2 mb-4">

    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">
                Vendor Management
            </h1>
        </div>

        <div class="col-auto">

            <a href="<?php echo e(route('agent.vendors.create')); ?>"
               class="btn btn-primary">

                <i class="las la-plus"></i>

                Create Vendor

            </a>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">
        <h5 class="mb-0 h6">
            Vendors Created By Me
        </h5>
    </div>

    <div class="card-body">

        <table class="table aiz-table mb-0">

            <thead>

                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                 
                    <th>Created At</th>
                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($key + 1); ?></td>

                    <td><?php echo e($vendor->name); ?></td>

                    <td><?php echo e($vendor->email); ?></td>

                    <td><?php echo e($vendor->phone); ?></td>

                  
                    <td>
                        <?php echo e($vendor->created_at->format('d M Y')); ?>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="6"
                        class="text-center">
                        No Vendors Found
                    </td>
                </tr>

                <?php endif; ?>

            </tbody>

        </table>

        <div class="aiz-pagination mt-4">
            <?php echo e($vendors->links()); ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('agent.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/vendors/index.blade.php ENDPATH**/ ?>