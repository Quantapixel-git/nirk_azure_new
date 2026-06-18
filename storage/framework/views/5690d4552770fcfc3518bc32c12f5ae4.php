

<?php $__env->startSection('content'); ?>

<?php
    $route = Route::currentRouteName() == 'sellers.index' ? 'all_seller_route' : 'seller_rating_followers';
?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3"><?php echo e($route == 'all_seller_route' ? translate('All Sellers') : translate('Sellers Review & Followers ')); ?></h1>
        </div>
        <?php if(auth()->user()->can('add_seller') && ($route == 'all_seller_route')): ?>
            <div class="col text-right">
                <a href="<?php echo e(route('sellers.create')); ?>" class="btn btn-circle btn-info">
                    <span><?php echo e(translate('Add New Seller')); ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <form class="" id="sort_sellers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6"><?php echo e($route == 'all_seller_route' ? translate('Sellers') : translate('Sellers Review & Followers ')); ?></h5>
            </div>
            <?php if($route == 'all_seller_route'): ?>
                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        <?php echo e(translate('Bulk Action')); ?>

                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_seller')): ?>
                            <a class="dropdown-item confirm-alert" href="javascript:void(0)"  data-target="#bulk-delete-modal"><?php echo e(translate('Delete selection')); ?></a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seller_commission_configuration')): ?>
                            <a class="dropdown-item confirm-alert" onclick="set_bulk_commission()"><?php echo e(translate('Set Bulk Commission')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-2 ml-auto">
                    <select class="form-control aiz-selectpicker" name="verification_status" onchange="sort_sellers()" data-selected="<?php echo e($verification_status); ?>">
                        <option value=""><?php echo e(translate('Filter by Verification Status')); ?></option>
                        <option value="verified"><?php echo e(translate('Verified')); ?></option>
                        <option value="un_verified"><?php echo e(translate('Unverified')); ?></option>
                    </select>
                </div>
                <div class="col-md-2 ml-auto">
                    <select class="form-control aiz-selectpicker" name="approved_status" id="approved_status" onchange="sort_sellers()">
                        <option value=""><?php echo e(translate('Filter by Approval')); ?></option>
                        <option value="1"  <?php if(isset($approved)): ?> <?php if($approved == '1'): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e(translate('Approved')); ?></option>
                        <option value="0"  <?php if(isset($approved)): ?> <?php if($approved == '0'): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e(translate('Non-Approved')); ?></option>
                    </select>
                </div>
            <?php endif; ?>
            <div class="col-md-3">
                <div class="form-group mb-0">
                  <input type="text" class="form-control" id="search" name="search"<?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?> placeholder="<?php echo e(translate('Type name or email or mobile number & Enter')); ?>">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th>
                        <?php if(auth()->user()->can('delete_seller') && ($route == 'all_seller_route')): ?>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        <?php else: ?>
                            #
                        <?php endif; ?>
                    </th>
                    <th><?php echo e(translate('Name')); ?></th>
                    <th data-breakpoints="lg"><?php echo e(translate('Contact')); ?></th>
                    <?php if($route == 'all_seller_route'): ?>
                        <th data-breakpoints="lg"><?php echo e(translate('Status')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Num. of Products')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Due to seller')); ?></th>
                        <?php if(get_setting('seller_commission_type') == 'seller_based'): ?>
                            <th data-breakpoints="lg"><?php echo e(translate('Commission')); ?></th>
                        <?php endif; ?>
                        <th data-breakpoints="lg"><?php echo e(translate('Email Verification')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Seller Verification')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Verification Approval')); ?></th>
                    <?php else: ?>
                        <th data-breakpoints="lg"><?php echo e(translate('Rating')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Followers')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Custom Followers')); ?></th>
                    <?php endif; ?>
                    <th width="10%"><?php echo e(translate('Options')); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php if(auth()->user()->can('delete_seller') && ($route == 'all_seller_route')): ?>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="<?php echo e($shop->id); ?>">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php echo e(($key+1) + ($shops->currentPage() - 1)*$shops->perPage()); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="row gutters-5  mw-100 align-items-center">
                                <div class="col-auto">
                                    <img src="<?php echo e(uploaded_asset($shop->logo)); ?>" class="size-40px img-fit" alt="Image" onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/placeholder.jpg')); ?>';">
                                </div>
                                <div class="col <?php if($shop->user->is_suspicious == 1): ?> text-info <?php endif; ?>">
                                    <span class="text-truncate-2">
                                        <?php if($shop->user->is_suspicious == 1): ?> 
                                            <i class="las la-exclamation-circle" aria-hidden="true"></i> 
                                        <?php endif; ?>
                                    <a class="text-primary" href="<?php echo e(route('sellers.profile', encrypt($shop->id))); ?>" target="_blank"><?php echo e($shop->name); ?></a></span>
                                </div>
                            </div>
                        </td>
                        <td><?php echo e($shop->user->phone); ?> 
                            <span class="d-block text-truncate-2"><?php echo e($shop->user->email); ?></span>
                        </td>
                        <?php if($route == 'all_seller_route'): ?>
                            <td>
                                <?php if($shop->user->banned): ?>
                                    <span class="badge badge-inline badge-danger"><?php echo e(translate('Banned')); ?></span>
                                <?php elseif($shop->user->is_suspicious): ?>
                                    <span class="badge badge-inline badge-info"><?php echo e(translate('Suspicious')); ?></span>
                                <?php elseif(!$shop->user->banned): ?>
                                    <span class="badge badge-inline badge-success"><?php echo e(translate('Regular')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($shop->user->products->count()); ?></td>
                            <td>
                                <?php if($shop->admin_to_pay >= 0): ?>
                                    <?php echo e(single_price($shop->admin_to_pay)); ?>

                                <?php else: ?>
                                    <?php echo e(single_price(abs($shop->admin_to_pay))); ?> (<?php echo e(translate('Due to Admin')); ?>)
                                <?php endif; ?>
                            </td>
                           
                         
                            <?php if(get_setting('seller_commission_type') == 'seller_based'): ?>
                                <td><?php echo e($shop->commission_percentage); ?>%</td>
                            <?php endif; ?>
                            <td>
                                <?php if($shop->user->email_verified_at != null): ?>
                                    <span class="badge badge-inline badge-success"><?php echo e(translate('Verified')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-inline badge-warning"><?php echo e(translate('Unverified')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start">
                                    <?php if($shop->verification_status != 1 && $shop->verification_info != null): ?>
                                        <span class="badge badge-inline badge-warning mb-1"> <?php echo e(translate('Applied')); ?></span>
                                        <a href="javascript:void();" onclick="show_seller_verification_info('<?php echo e($shop->id); ?>');" class="badge badge-inline badge-info">
                                            <?php echo e(translate('View Details')); ?>

                                        </a>
                                    <?php elseif($shop->verification_status == 1 && $shop->verification_info != null): ?>
                                        <span class="badge badge-inline badge-success mb-1"> <?php echo e(translate('Verified')); ?></span>
                                        <a href="javascript:void();" onclick="show_seller_verification_info('<?php echo e($shop->id); ?>');" class="badge badge-inline badge-info">
                                            <?php echo e(translate('View Details')); ?>

                                        </a>
                                    <?php elseif($shop->verification_status == 1 && $shop->verification_info == null): ?>
                                        <span class="badge badge-inline badge-success mb-1"> <?php echo e(translate('Verified')); ?></span>
                                        <span class="badge badge-inline badge-secondary"><?php echo e(translate('By Admin')); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-inline badge-secondary"> <?php echo e(translate('Not Applied')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve_seller')): ?> onchange="update_approved(this)" <?php endif; ?>
                                        value="<?php echo e($shop->id); ?>" type="checkbox"
                                        <?php if($shop->verification_status == 1) echo "checked";?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('approve_seller')): ?> disabled <?php endif; ?>
                                    >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                        <i class="las la-ellipsis-v seller-list-icon"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_seller_profile')): ?>
                                            <a href="<?php echo e(route('sellers.profile', encrypt($shop->id))); ?>" class="dropdown-item">
                                                <?php echo e(translate('Profile')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('login_as_seller')): ?>
                                            <a href="<?php echo e(route('sellers.login', encrypt($shop->id))); ?>" class="dropdown-item">
                                                <?php echo e(translate('Log in as this Seller')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pay_to_seller')): ?>
                                            <a href="javascript:void();" onclick="show_seller_payment_modal('<?php echo e($shop->id); ?>');" class="dropdown-item">
                                                <?php echo e(translate('Go to Payment')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seller_payment_history')): ?>
                                            <a href="<?php echo e(route('sellers.payment_history', encrypt($shop->user_id))); ?>" class="dropdown-item">
                                                <?php echo e(translate('Payment History')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_seller')): ?>
                                            <a href="<?php echo e(route('sellers.edit', encrypt($shop->id))); ?>" class="dropdown-item">
                                                <?php echo e(translate('Edit')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ban_seller')): ?>
                                            <?php if($shop->user->banned != 1): ?>
                                                <a href="javascript:void();" onclick="confirm_ban('<?php echo e(route('sellers.ban', $shop->id)); ?>');" class="dropdown-item">
                                                    <?php echo e(translate('Ban this seller')); ?>

                                                    <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="javascript:void();" onclick="confirm_unban('<?php echo e(route('sellers.ban', $shop->id)); ?>');" class="dropdown-item">
                                                    <?php echo e(translate('Unban this seller')); ?>

                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('mark_seller_suspected')): ?>
                                            <?php if($shop->user->is_suspicious == 1): ?>
                                                <a href="javascript:void();" onclick="confirm_suspicious('<?php echo e(route('seller.suspicious', encrypt($shop->user->id))); ?>', true);" class="dropdown-item">
                                                        <?php echo e(translate(" Mark as " . ($shop->user->is_suspicious == 1 ? 'unsuspect' : 'suspicious') . " ")); ?>

                                                </a>
                                            <?php else: ?>
                                                <a href="javascript:void();" onclick="confirm_suspicious('<?php echo e(route('seller.suspicious', encrypt($shop->user->id))); ?>', false);" class="dropdown-item">
                                                        <?php echo e(translate(" Mark as " . ($shop->user->is_suspicious == 1 ? 'unsuspect' : 'suspicious') . " ")); ?>

                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>


                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_seller')): ?>
                                            <a href="javascript:void();" class="dropdown-item confirm-delete" data-href="<?php echo e(route('sellers.destroy', $shop->id)); ?>" >
                                                <?php echo e(translate('Delete')); ?>

                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        <?php else: ?>
                            <td>
                                <?php echo e($shop->rating); ?>

                                <span class="rating rating-sm m-0 ml-1">
                                    <?php for($i=0; $i < $shop->rating; $i++): ?>
                                        <i class="las la-star active"></i>
                                    <?php endfor; ?>
                                    <?php for($i=0; $i < 5-$shop->rating; $i++): ?>
                                        <i class="las la-star"></i>
                                    <?php endfor; ?>
                                </span>
                            </td>
                            <td><?php echo e($shop->followers()->count()); ?></td>
                            <td><?php echo e($shop->custom_followers); ?></td>
                            <td>
                                <?php if(auth()->user()->can('edit_seller_custom_followers')): ?>
                                    <a href="javascript:void();" onclick="editCustomFollowers(<?php echo e($shop->id); ?>, <?php echo e($shop->custom_followers); ?>);" class="btn btn-primary btn-xs fs-10 fw-700">
                                        <?php echo e(translate('Edit Custom Follower')); ?>

                                    </a>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        
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
	<!-- Delete Modal -->
	<?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Bulk Delete modal -->
    <?php echo $__env->make('modals.bulk_delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<!-- Seller verification info Modal -->
	<div class="modal fade" id="verification_info_modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content" id="verification-info-modal-content">

			</div>
		</div>
	</div>

	<!-- Seller Payment Modal -->
	<div class="modal fade" id="payment_modal">
	    <div class="modal-dialog modal-dialog-centered">
	        <div class="modal-content" id="payment-modal-content">

	        </div>
	    </div>
	</div>

	
<!-- Reusable Confirmation Modal -->
<div class="modal fade" id="universal-confirm-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6" id="universal-modal-title"><?php echo e(translate('Confirmation')); ?></h5>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="universal-modal-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                <a class="btn btn-primary" id="universal-confirm-button"><?php echo e(translate('Proceed!')); ?></a>
            </div>
        </div>
    </div>
</div>
   

    
    <div class="modal fade" id="edit_seller_custom_followers">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6"><?php echo e(translate('Edit Seller Custom Followers')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <form class="form-horizontal" action="<?php echo e(route('edit_Seller_custom_followers')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="shop_id" value="" id="shop_id">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"><?php echo e(translate('Custom Followers')); ?></label>
                            <div class="col-md-9">
                                <input type="number" lang="en" min="0" step="1" placeholder="<?php echo e(translate('Custom Followers')); ?>" value="" name="custom_followers" id="custom_followers" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm text-white"><?php echo e(translate('save!')); ?></button>
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        function show_seller_payment_modal(id){
            $.post('<?php echo e(route('sellers.payment_modal')); ?>',{_token:'<?php echo e(@csrf_token()); ?>', id:id}, function(data){
                $('#payment_modal #payment-modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
                $('.demo-select2-placeholder').select2();
            });
        }

        function show_seller_verification_info(id){
            $.post('<?php echo e(route('sellers.verification_info_modal')); ?>',{_token:'<?php echo e(@csrf_token()); ?>', id:id}, function(data){
                $('#verification_info_modal #verification-info-modal-content').html(data);
                $('#verification_info_modal').modal('show', {backdrop: 'static'});
            });
        }

        function update_approved(el){
            if('<?php echo e(env('DEMO_MODE')); ?>' == 'On'){
                AIZ.plugins.notify('info', '<?php echo e(translate('Data can not change in demo mode.')); ?>');
                return;
            }

            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('sellers.approved')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '<?php echo e(translate('Approved sellers updated successfully')); ?>');
                }
                else{
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }

        function sort_sellers(el){
            $('#sort_sellers').submit();
        }

        // Ban
        function confirm_ban(url) {
            showConfirmationModal({
                url: url,
                message: '<?php echo e(translate("Do you really want to ban this seller?")); ?>'
            });
        }

        // Unban
        function confirm_unban(url) {
            showConfirmationModal({
                url: url,
                message: '<?php echo e(translate("Do you really want to unban this seller?")); ?>'
            });
        }

        function showConfirmationModal({ url, message }) {
            if ('<?php echo e(env('DEMO_MODE')); ?>' === 'On') {
                AIZ.plugins.notify('info', '<?php echo e(translate('Data can not change in demo mode.')); ?>');
                return;
            }

            // Set dynamic content
            document.getElementById('universal-modal-message').innerText = message;
            document.getElementById('universal-confirm-button').setAttribute('href', url);

            // Show the modal
            $('#universal-confirm-modal').modal('show', { backdrop: 'static' });
        }


        function bulk_delete() {
            var data = new FormData($('#sort_sellers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('bulk-seller-delete')); ?>",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }
        // Set seller bulk commission
        function set_bulk_commission(){
            var sellerIds = [];
            $(".check-one[name='id[]']:checked").each(function() {
                sellerIds.push($(this).val());
            });
            if(sellerIds.length > 0){
                $('#seller_ids').val(sellerIds);
                $('#set_seller_commission').modal('show', {backdrop: 'static'});
            }
            else{
                AIZ.plugins.notify('danger', '<?php echo e(translate('Please Select Seller first.')); ?>');
            }
        }

        
        // Edit seller custom followers
        function editCustomFollowers(shop_id, custom_followers){
            $('#shop_id').val(shop_id);
            $('#custom_followers').val(custom_followers);
            $('#edit_seller_custom_followers').modal('show', {backdrop: 'static'});
        }

        // Suspicious / Unsuspicious
        function confirm_suspicious(url, isSuspicious) {
            const action = isSuspicious ? 'unsuspect' : 'suspect';
            showConfirmationModal({
                url: url,
                message: '<?php echo e(translate("Do you really want to")); ?> ' + action + ' <?php echo e(translate("this seller?")); ?>'
            });
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/sellers/index.blade.php ENDPATH**/ ?>