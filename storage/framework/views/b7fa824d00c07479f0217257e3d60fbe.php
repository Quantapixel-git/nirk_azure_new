

<?php $__env->startSection('panel_content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3"><?php echo e(translate('Set Category Base Product Discount')); ?></h1>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6"><?php echo e(translate('Categories')); ?></h5>
        <form class="" id="sort_categories" action="" method="GET">
            <div class="box-inline pad-rgt pull-left">
                <div class="" style="min-width: 200px;">
                    <input type="text" class="form-control" id="search" name="search"<?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?> placeholder="<?php echo e(translate('Type name & Enter')); ?>">
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th data-breakpoints="lg"><?php echo e(translate('Icon')); ?></th>
                    <th><?php echo e(translate('Name')); ?></th>
                    <th data-breakpoints="lg"><?php echo e(translate('Parent Category')); ?></th>
                    <th data-breakpoints="lg" width="15%"><?php echo e(translate('Discount')); ?></th>
                    <th data-breakpoints="lg" width="20%"><?php echo e(translate('Discount Date Range')); ?></th>
                    <th data-breakpoints="lg" class="text-right"><?php echo e(translate('Action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $discount = $category->sellerDiscount;
                        $start_date = $discount && $discount->discount_start_date ? date('d-m-Y H:i:s', $discount->discount_start_date) : null;
                        $end_date   = $discount && $discount->discount_end_date ? date('d-m-Y H:i:s', $discount->discount_end_date) : null;
                    ?>
                    <tr>
                        <td><?php echo e(($key+1) + ($categories->currentPage() - 1)*$categories->perPage()); ?></td>
                        <td>
                            <?php if($category->icon != null): ?>
                                <span class="avatar avatar-square avatar-xs">
                                    <img src="<?php echo e(uploaded_asset($category->icon)); ?>" alt="<?php echo e(translate('icon')); ?>">
                                </span>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td class="align-items-center d-flex fw-800">
                            <?php echo e($category->getTranslation('name')); ?>

                            <?php if($category->digital == 1): ?>
                                <img src="<?php echo e(static_asset('assets/img/digital_tag.png')); ?>" alt="<?php echo e(translate('Digital')); ?>" class="ml-2 h-25px" style="cursor: pointer;" title="DIgital">
                            <?php endif; ?>
                         </td>
                        <td class="fw-600">
                            <?php
                                $parent = \App\Models\Category::where('id', $category->parent_id)->first();
                            ?>
                            <?php if($parent != null): ?>
                                <?php echo e($parent->getTranslation('name')); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discount_<?php echo e($category->id); ?>" step="0.01" value="<?php echo e($discount ? $discount->discount : '0'); ?>" min="0" placeholder="<?php echo e(translate('Discount')); ?>"
                                    style="border-radius: 8px 0 0 8px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-left-0" id="inputGroupPrepend" style="border-radius: 0 8px 8px 0;">%</span>
                                </div>
                            </div>
                        </td>
                       
                        <td>
                            <input type="text" class="form-control aiz-date-range rounded-2" value="<?php echo e($start_date && $end_date ? $start_date . ' to ' . $end_date : ''); ?>" placeholder="<?php echo e(translate('Select Date')); ?>" id="date_range_<?php echo e($category->id); ?>" placeholder="<?php echo e(translate('Select Date')); ?>" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
                        </td>
                        <td class="text-right">
                            <div class="form-group mb-0 text-right">
                                <button type="button" onclick="trigger_alert(<?php echo e($category->id); ?>)" class="btn btn-primary btn-sm rounded-2 w-120px"><?php echo e(translate('Set')); ?></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="aiz-pagination">
            <?php echo e($categories->appends(request()->input())->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <!-- confirm Modal -->
    <div id="confirm-modal" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered" style="max-width: 540px;">
            <div class="modal-content p-2rem">
                <div class="modal-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="64" viewBox="0 0 72 64">
                        <g id="Octicons" transform="translate(-0.14 -1.02)">
                          <g id="alert" transform="translate(0.14 1.02)">
                            <path id="Shape" d="M40.159,3.309a4.623,4.623,0,0,0-7.981,0L.759,58.153a4.54,4.54,0,0,0,0,4.578A4.718,4.718,0,0,0,4.75,65.02H67.587a4.476,4.476,0,0,0,3.945-2.289,4.773,4.773,0,0,0,.046-4.578Zm.6,52.555H31.582V46.708h9.173Zm0-13.734H31.582V23.818h9.173Z" transform="translate(-0.14 -1.02)" fill="#ffc700" fill-rule="evenodd"/>
                          </g>
                        </g>
                    </svg>
                    <p class="mt-3 mb-3 fs-16 fw-700"><?php echo e(translate('Are you sure you want to set this discount?')); ?></p>
                    <div>
                        <button type="button" class="btn btn-light rounded-2 mt-2 fs-13 fw-700 w-150px" data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                        <a href="javascript:void(0)" id="trigger_btn" data-value="" class="btn btn-warning rounded-2 mt-2 fs-13 fw-700 w-250px" onclick="setDiscount()"><?php echo e(translate('Confirm')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">

        $(document).ready(function() {
            setTimeout(() => {
                AIZ.plugins.dateRange();
            }, "2000");
        });
        
        function trigger_alert(CategoryId){
            $('#trigger_btn').attr('data-value', CategoryId);
            $('#confirm-modal').modal('show');
        }

        function setDiscount(CategoryId){
            $('#confirm-modal').modal('hide');
            var CategoryId = $('#trigger_btn').attr('data-value');
            var discount =  $("#discount_" + CategoryId).val();
            var dateRange =  $("#date_range_" + CategoryId).val();

            if(discount < 0) {
                AIZ.plugins.notify('danger', '<?php echo e(translate('Discount can not be less than 0')); ?>');
            }
            else{
                $.post('<?php echo e(route('seller.set_product_discount')); ?>', {
                    _token:'<?php echo e(csrf_token()); ?>', 
                    category_id:CategoryId, 
                    discount:discount, 
                    date_range:dateRange
                }, function(data) {
                    if(data == 1){
                        AIZ.plugins.notify('success', '<?php echo e(translate('Category Wise Product Discount Set Successfully')); ?>');
                    }
                    else{
                        AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                    }
                    location.reload();
                });
            }   
        }
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('seller.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/seller/product/category_wise_discount/set_discount.blade.php ENDPATH**/ ?>