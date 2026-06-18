    

    <?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <img class="mr-3" src="<?php echo e(static_asset('assets/img/cards/'.$shipping_system->name.'.png')); ?>" height="30">
                            <h5 class="mb-0 h6"><?php echo e(ucfirst(translate($shipping_system->name))); ?></h5>
                        </div>
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateShippingSettings(this, <?php echo e($shipping_system->id); ?>)" <?php if($shipping_system->active == 1): ?> checked <?php endif; ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="card-body">
                        <?php echo $__env->make('backend.shipping_system.partials.' . $shipping_system->name . '.' . $shipping_system->name, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
            // $demo_mode = env('DEMO_MODE') == 'On' ? true : false;
        ?>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('script'); ?>
        <script type="text/javascript">

            function updateShippingSettings(el, id) {

                if('<?php echo e(env('DEMO_MODE')); ?>' == 'On'){
                    AIZ.plugins.notify('info', '<?php echo e(translate('Data can not change in demo mode.')); ?>');
                    return;
                }

                if ($(el).is(':checked')) {
                    var value = 1;
                } else {
                    var value = 0;
                }

                $.post('<?php echo e(route('shipping.activation')); ?>', {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id,
                    value: value
                }, function(data) {
                    if (data == 1) {
                        AIZ.plugins.notify('success', '<?php echo e(translate('Shipping Settings updated successfully')); ?>');
                    } else {
                        AIZ.plugins.notify('danger', 'Something went wrong');
                    }
                });
            }

        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/shipping_system/index.blade.php ENDPATH**/ ?>