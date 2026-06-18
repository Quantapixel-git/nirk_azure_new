<?php
    $user_id = Auth::id();
    $credential = App\Models\ShiprocketCredential::where('user_id', $user_id)->first();
?>
<form class="form-horizontal" action="<?php echo e(route('shiprocket_settings.update')); ?>" method="POST" id="aizSubmitForm">
    <?php echo csrf_field(); ?>
    <div id="shipRocket">
        <div class="form-group row">
            <input type="hidden" name="types[]" value="SHIPROCKET_EMAIL">
            <div class="col-md-3">
                <label class="col-from-label"><?php echo e(translate('Shiprocket Email')); ?></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="SHIPROCKET_EMAIL" value="<?php echo e($credential->email ?? ''); ?>"
                    placeholder="<?php echo e(translate('Shiprocket Email')); ?>">
            </div>
        </div>
        <div class="form-group row">
            <input type="hidden" name="types[]" value="SHIPROCKET_PASSWORD">
            <div class="col-md-3">
                <label class="col-from-label"><?php echo e(translate('Shiprocket Password')); ?></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="SHIPROCKET_PASSWORD"
                    value="<?php echo e($credential->password ?? ''); ?>" placeholder="<?php echo e(translate('Shiprocket Password')); ?>">
            </div>
        </div>
    </div>
    <div class="form-group mb-0 text-right">
        <button type="submit" class="btn btn-primary"><?php echo e(translate('Save Configuration')); ?></button>
    </div>
</form><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/shipping_system/partials/shiprocket/shiprocket.blade.php ENDPATH**/ ?>