

<?php $__env->startSection('panel_content'); ?>

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3"><?php echo e(translate('Money Withdraw')); ?></h1>
        </div>
      </div>
    </div>

    <div class="row gutters-10">
        <div class="col-md-4 mb-3 ml-auto" >
            <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
              <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                  <i class="las la-dollar-sign la-2x text-white"></i>
              </span>
              <div class="px-3 pt-3 pb-3">
                  <div class="h4 fw-700 text-center"><?php echo e(single_price(Auth::user()->shop->admin_to_pay)); ?></div>
                  <div class="opacity-50 text-center"><?php echo e(translate('Pending Balance')); ?></div>
              </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mr-auto" >
          <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition" onclick="show_request_modal()">
              <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                  <i class="las la-plus la-3x text-white"></i>
              </span>
              <div class="fs-18 text-primary"><?php echo e(translate('Send Withdraw Request')); ?></div>
          </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><?php echo e(translate('Withdraw Request history')); ?></h5>
        </div>
          <div class="card-body">
              <table class="table aiz-table mb-0">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th><?php echo e(translate('Date')); ?></th>
                          <th><?php echo e(translate('Amount')); ?></th>
                          <th data-breakpoints="lg"><?php echo e(translate('Status')); ?></th>
                          <th data-breakpoints="lg" width="60%"><?php echo e(translate('Message')); ?></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php $__currentLoopData = $seller_withdraw_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seller_withdraw_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                              <td><?php echo e($key+1); ?></td>
                              <td><?php echo e(date('d-m-Y', strtotime($seller_withdraw_request->created_at))); ?></td>
                              <td><?php echo e(single_price($seller_withdraw_request->amount)); ?></td>
                              <td>
                                  <?php if($seller_withdraw_request->status == 1): ?>
                                      <span class=" badge badge-inline badge-success" ><?php echo e(translate('Paid')); ?></span>
                                  <?php else: ?>
                                      <span class=" badge badge-inline badge-info" ><?php echo e(translate('Pending')); ?></span>
                                  <?php endif; ?>
                              </td>
                              <td>
                                  <?php echo e($seller_withdraw_request->message); ?>

                              </td>
                          </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
              </table>
              <div class="aiz-pagination">
                  <?php echo e($seller_withdraw_requests->links()); ?>

              </div>
          </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <div class="modal fade" id="request_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('Send A Withdraw Request')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php if(Auth::user()->shop->admin_to_pay > 5): ?> 
                    <form class="" action="<?php echo e(route('seller.money_withdraw_request.store')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body gry-bg px-3 pt-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label><?php echo e(translate('Amount')); ?> <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" lang="en" class="form-control mb-3" name="amount" min="<?php echo e(get_setting('minimum_seller_amount_withdraw')); ?>" max="<?php echo e(Auth::user()->shop->admin_to_pay); ?>" placeholder="<?php echo e(translate('Amount')); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label><?php echo e(translate('Message')); ?></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="message" rows="8" class="form-control mb-3"></textarea>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><?php echo e(translate('Send')); ?></button>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="p-5 heading-3">
                            <?php echo e(translate('You do not have enough balance to send withdraw request')); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function show_request_modal(){
            $('#request_modal').modal('show');
        }

        function show_message_modal(id){
            $.post('<?php echo e(route('withdraw_request.message_modal')); ?>',{_token:'<?php echo e(@csrf_token()); ?>', id:id}, function(data){
                $('#message_modal .modal-content').html(data);
                $('#message_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('seller.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/seller/money_withdraw_requests/index.blade.php ENDPATH**/ ?>