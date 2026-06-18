

<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3"><?php echo e(translate('Pending Sellers')); ?></h1>
        </div>
    </div>
</div>

<div class="card">
    <form id="sort_sellers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6"><?php echo e(translate('Pending Seller List')); ?></h5>
            </div>
            <div class="col-md-3 ml-auto">
                <input type="text" class="form-control" name="search" <?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?> placeholder="<?php echo e(translate('Type name or email or mobile number & Enter')); ?>">
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(translate('Name')); ?></th>
                        <th><?php echo e(translate('Phone')); ?></th>
                        <th><?php echo e(translate('Email')); ?></th>
                        <th><?php echo e(translate('Registration Date')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Access Approval')); ?></th>
                        <th><?php echo e(translate('Status')); ?></th>
                        <th><?php echo e(translate('Action')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(($key + 1) + ($shops->currentPage() - 1) * $shops->perPage()); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo e(uploaded_asset($shop->logo)); ?>" class="size-40px img-fit mr-2" onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">
                                    <span class="text-truncate-2"><?php echo e($shop->name); ?></span>
                                </div>
                            </td>
                            <td><?php echo e($shop->user->phone ?? '-'); ?></td>
                            <td><?php echo e($shop->user->email ?? '-'); ?></td>
                            <td><?php echo e($shop->created_at ? $shop->created_at->format('Y-m-d H:i:s') : '-'); ?></td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve_seller')): ?> onchange="update_approved(this)" <?php endif; ?>
                                        value="<?php echo e($shop->id); ?>" type="checkbox"
                                        <?php if($shop->registration_approval == 1) echo "checked";?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('approve_seller')): ?> disabled <?php endif; ?>
                                    >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                             <?php if(addon_is_activated('portfolio_system') !=1): ?>
                            <span class="badge badge-inline badge-warning"><?php echo e(translate('Pending')); ?></span>
                             <?php else: ?>
                                <?php if($shop->verification_status != 1 && $shop->business_info != null): ?>
                                <?php 
                                $verification_docs = json_decode($shop->business_info);
                                ?>
                                <span class="badge badge-inline badge-success"><?php echo e(translate('Submitted')); ?></span> <br>
                                <a href="javascript:void(0)" class="badge badge-inline badge-info border border-info" onclick="showDocsInModal('<?php echo e(json_encode($verification_docs)); ?>', '<?php echo e($shop->id); ?>')"> <?php echo e(translate('View Info')); ?></a>

                                <?php else: ?>
                                    <span class="badge badge-inline badge-secondary"> <?php echo e(translate('Not Submitted')); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                            </td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_seller')): ?>
                                    <a href="javascript:void();" class="badge badge-inline badge-danger confirm-delete" data-href="<?php echo e(route('sellers.destroy', $shop->id)); ?>">
                                        <?php echo e(translate('Delete')); ?>

                                    </a>
                                <?php endif; ?>
                            </td>
                
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="aiz-pagination">
                <?php echo e($shops->appends(request()->input())->links()); ?>

            </div>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="modal fade" id="docsPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(translate('Customer Documents')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="min-height: 500px;">
                    
                    <div id="filePreviewContainer" class="text-center"></div>
                </div>

                <div class="d-flex align-items-center justify-content-between w-100 px-3 px-lg-5 pb-5 mb-3">
                    <button type="button" id="back-btn"
                        class="bg-transparent border-2 border-gray-400 fs-14 fw-700 rounded-2 py-15px text-success d-block mr-2 w-100"
                        data-dismiss="modal"><?php echo e(translate('No')); ?></button>
                    <a href="javascript:void(0)" id="conform-yes-btn"
                        class="bg-transparent text-center border border-2 border-gray-400 rounded-2 fs-14 fw-700 py-15px text-danger d-block w-100"><?php echo e(translate('Approved')); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    function update_approved(el){
        if ('<?php echo e(env('DEMO_MODE')); ?>' === 'On') {
            AIZ.plugins.notify('info', '<?php echo e(translate('Data can not change in demo mode.')); ?>');
            return;
        }
        let registration_approval = el.checked ? 1 : 0;
        let shop_id = el.value;
        let $row = $(el).closest('tr');

        $.post('<?php echo e(route('sellers.registration.approved')); ?>', {
            _token: '<?php echo e(csrf_token()); ?>',
            id: shop_id,
            registration_approval: registration_approval
        }, function (data) {
            if (data == 1) {
                AIZ.plugins.notify('success', '<?php echo e(translate('Pending sellers Approved successfully')); ?>');
                if (registration_approval === 1) {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            } else {
                AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
            }
        });
    }


    function update_registration_verification_approval(shop_id){
        if ('<?php echo e(env('DEMO_MODE')); ?>' === 'On') {
            AIZ.plugins.notify('info', '<?php echo e(translate('Data can not change in demo mode.')); ?>');
            return;
        }
        $.post('<?php echo e(route('sellers.registration.approved')); ?>', {
            _token: '<?php echo e(csrf_token()); ?>',
            id: shop_id,
            registration_approval: 1,
            verification_status : 1
        }, function (data) {
            if (data == 1) {
                AIZ.plugins.notify('success', '<?php echo e(translate('Unverified sellers Verified successfully')); ?>');
                $('#docsPreviewModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 800);
            } else {
                AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
            }
        });
    }

    function showDocsInModal(customer_docs_json, shop_id) {

        const docs = JSON.parse(customer_docs_json);
        const container = $('#filePreviewContainer').empty();

        const baseUrl = "<?php echo e(my_asset('')); ?>/";
        const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        const docList = [
            { key: 'certificate', label: '<?php echo e(translate("Tax Identification Document")); ?>' },
            { key: 'id_card', label: '<?php echo e(translate("ID Card")); ?>' },
            { key: 'seller_photo', label: '<?php echo e(translate("Seller Photo")); ?>' },
            { key: 'seller_selfie', label: '<?php echo e(translate("Seller Selfie")); ?>' }
            
        ];

        if(docs['certificate_number']) {
            container.append(`
                <div class="mb-4">
                    <h5 class="mb-2"><?php echo e(translate('Tax Identification Number')); ?>:</h5>
                    <p>${docs['certificate_number']}</p>
                </div>
            `);
        }

        docList.forEach(({ key, label }) => {

            if (!docs[key]) return;

            const fileUrl = baseUrl + docs[key];
            const ext = docs[key].split('.').pop().toLowerCase();

            let previewHtml = `<p class="text-danger">Unsupported file format.</p>`;

            if (imageExts.includes(ext)) {
                previewHtml = `<img src="${fileUrl}" style="max-width:100%; max-height:600px;">`;
            } else if (ext === 'pdf') {
                previewHtml = `<iframe src="${fileUrl}" style="width:100%; height:600px;" frameborder="0"></iframe>`;
            }

            container.append(`
                <div class="mb-4">
                    <h5 class="mb-2">${label}:</h5>
                    ${previewHtml}
                </div>
            `);
        });
        $('#docsPreviewModal').data('shop-id', shop_id).modal('show');
    }

    $(document).on('click', '#conform-yes-btn', function () {
        const shop_id = $('#docsPreviewModal').data('shop-id');
        update_registration_verification_approval(shop_id);
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/sellers/pending_seller.blade.php ENDPATH**/ ?>