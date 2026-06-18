
<?php $__env->startSection('panel_content'); ?>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6"><?php echo e(translate('Note Information')); ?></h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="<?php echo e(route('seller.note.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"><?php echo e(translate('Type')); ?></label>
                            <div class="col-md-9">
                                <select name="note_type" class="form-control aiz-selectpicker mb-2 mb-md-0" required>
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->value); ?>" class="text-uppercase"><?php echo e(translate($type->name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                <?php echo e(translate('Description')); ?>

                                <p class="fs-10">(<?php echo e(translate('Max 900 Character')); ?>)</p>
                            </label>
                            <div class="col-md-9">
                                <textarea name="description" rows="8" class="form-control"><?php echo e(old('description')); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary"><?php echo e(translate('Save')); ?></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('seller.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/seller/note/create.blade.php ENDPATH**/ ?>