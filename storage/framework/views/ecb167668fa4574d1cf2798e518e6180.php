

<?php $__env->startSection('content'); ?>

    <div class="">
        <div class="row ">
            <div class="col-md-6">
                <div class="nav border-bottom aiz-nav-tabs">
                    <a class="p-3 fs-16 text-reset show active" data-toggle="tab" href="#installed"><?php echo e(translate('Installed Addon')); ?></a>
                    <a class="p-3 fs-16 text-reset" data-toggle="tab" href="#available"><?php echo e(translate('Available Addon')); ?></a>
                </div>
            </div>
			
            <div class="col mt-3 mt-md-0 text-center text-md-right">
                <a href="https://activeitzone.com/activation/addon" class="btn btn-primary mb-3 mb-sm-0 mx-3 mx-md-0 mr-lg-3" target="_blank">
					<?php echo e(translate('Activate Addon Link')); ?>

				</a>
                <a href="<?php echo e(route('addons.create')); ?>" class="btn btn-primary mx-3 mx-md-0"><?php echo e(translate('Install/Update Addon')); ?></a>
            </div>
        </div>
    </div>
    <br>
    <div class="tab-content filter-tab-content">
        <div class="tab-pane fade in active show" id="installed">
            <div class="row">
                <div class="col-xl-10 col-xxl-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group">
                                <?php $__empty_1 = true; $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item">
                                        <div class="align-items-center d-flex flex-column flex-md-row">
                                            <img class="h-60px mb-3 mb-md-0" src="<?php echo e(static_asset($addon->image)); ?>" alt="Image">
                                            <div class="mr-md-3 ml-md-5">
                                                <h4 class="fs-16 fw-600"><?php echo e(ucfirst($addon->name)); ?></h4>
                                            </div>
                                            <div class="mr-md-3 ml-0">
                                                <p><small><?php echo e(translate('Version')); ?>: </small><?php echo e($addon->version); ?></p>
                                            </div>
                                            <?php if(env('DEMO_MODE') != 'On'): ?>
                                                <div class="mr-md-3 ml-0 w-100 w-md-auto">
                                                    <p><small><?php echo e(translate('Purchase code')); ?>: </small><?php echo e($addon->purchase_code); ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ml-auto mr-0">
                                                <label class="aiz-switch mb-0">
                                                    <input type="checkbox" data-identifier="<?php echo e($addon->unique_identifier); ?>" onchange="updateStatus(this, <?php echo e($addon->id); ?>)" <?php if($addon->activated) echo "checked";?>>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="list-group-item">
                                        <div class="text-center">
                                            <img class="mw-100 h-200px" src="<?php echo e(static_asset('assets/img/nothing.svg')); ?>" alt="Image">
                                            <h5 class="mb-0 h5 mt-3"><?php echo e(translate('No Addon Installed')); ?></h5>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="available">
            <div class="row" id="available-addons-content">

            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>



<?php $__env->startSection('script'); ?>
   <script type="text/javascript">
    var gstConfirmed = false;
    var lastEl, lastId;

    function updateStatus(el, id) {
        if ('<?php echo e(env('DEMO_MODE')); ?>' == 'On') {
            AIZ.plugins.notify('info', '<?php echo e(translate('Data can not change in demo mode.')); ?>');
            $(el).prop('checked', !$(el).is(':checked')); 
            return;
        }

        if ($(el).is(':checked')) {
            var status = 1;
            if ($(el).data('identifier') == 'gst_system') {
                if (!gstConfirmed) {
                    showAlert(el, id); 
                    return;
                }
            }
        } else {
            var status = 0;
            gstConfirmed = false; 
        }

        // Perform AJAX
        $.post('<?php echo e(route('addons.activation')); ?>', {_token:'<?php echo e(csrf_token()); ?>',id:id, status:status}, function(data){
            if (data == 1){
                AIZ.plugins.notify('success', '<?php echo e(translate('Status updated successfully')); ?>');
            } else {
                AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                $(el).prop('checked', !$(el).is(':checked')); // Reset on error
            }
            gstConfirmed = false; 
        });
    }

    function showAlert(el, id) {
        lastEl = el;
        lastId = id;

        showBulkActionModal();
        $('#confirmation-title').text('<?php echo e(translate('GST Activation Confirmation')); ?>');
        $('#confirmation-question').text('<?php echo e(translate('Are you sure you want to enable the GST system?')); ?>');
        $('#impact-message').html('<?php echo e(translate('This action cannot be undone. All existing VAT taxes linked to products will be permanently removed. In addition, any products without an assigned HSN/GST code will be automatically unpublished.')); ?>');
        $('.confirmation-icon').addClass('d-none');
        $('#exclamation-icon').removeClass('d-none');
        
        $('#conform-yes-btn').attr("onclick", "activeGST()");
    }

    function activeGST() {
        gstConfirmed = true;
        hideBulkActionModal(); 
        updateStatus(lastEl, lastId);
    }
    
    $(document).on('click', '#back-btn, [data-dismiss="modal"]', function(){
        if(!gstConfirmed && lastEl){
             $(lastEl).prop('checked', false);
        }
    });

        $(document).ready(function(){
            $.post('https://activeitzone.com/addons/public/addons', {item: 'ecommerce'}, function(data){
                //console.log(data);
                html = '';
                data.forEach((item, i) => {
                    if(item.link != null){
                        html += `<div class="col-lg-4 col-md-6 ">
                                    <div class="card addon-card">
                                        <div class="card-body">
                                            <a href="${item.link}" target="_blank"><img class="img-fluid" src="${item.image}"></a>
                                            <div class="pt-4">
                                                <a class="fs-16 fw-600 text-reset" href="${item.link}" target="_blank">${item.name}</a>
                                                <div class="rating mb-2"><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i></div>
                                                <p class="mar-no text-truncate-3">${item.short_description}</p>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-danger fs-22 fw-600">$${item.price}</div>
                                            <div class=""><a href="${item.link}" target="_blank" class="btn btn-sm btn-secondary">Preview</a> <a href="${item.purchase}" target="_blank" class="btn btn-sm btn-primary">Purchase</a></div>
                                        </div>
                                    </div>
                                </div>`;
                    }
                    else {
                        html += `<div class="col-lg-4 col-md-6 ">
                                    <div class="card addon-card">
                                        <div class="card-body">
                                            <a><img class="img-fluid" src="${item.image}"></a>
                                            <div class="pt-4">
                                                <a class="fs-16 fw-600 text-reset" >${item.name}</a>
                                                <div class="rating mb-2"><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i></div>
                                                <p class="mar-no text-truncate-3">${item.short_description}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-center"><div class="btn btn-outline btn-primary">Coming Soon</div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    }

                });
                $('#available-addons-content').html(html);
            });
        })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/addons/index.blade.php ENDPATH**/ ?>