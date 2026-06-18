

<?php $__env->startSection('panel_content'); ?>

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3"><?php echo e(translate('Bulk Products Upload')); ?></h1>
        </div>
      </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table aiz-table mb-0" style="font-size:14px; background-color: #cce5ff; border-color: #b8daff">
                <tr>
                    <td><?php echo e(translate('1. Download the skeleton file and fill it with data.')); ?>:</td>
                </tr>
                <tr >
                    <td><?php echo e(translate('2. You can download the example file to understand how the data must be filled.')); ?>:</td>
                </tr>
                <tr>
                    <td><?php echo e(translate('3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.')); ?>:</td>
                </tr>
                <tr>
                    <td><?php echo e(translate('4. After uploading products you need to edit them and set products images and choices.')); ?></td>
                </tr>
            </table>
            <a href="<?php echo e(static_asset('download/product_bulk_demo.xlsx')); ?>" download><button class="btn btn-primary mt-2"><?php echo e(translate('Download CSV')); ?></button></a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table aiz-table mb-0" style="font-size:14px;background-color: #cce5ff;border-color: #b8daff">
                <tr>
                    <td><?php echo e(translate('1. Category and Brand should be in numerical id.')); ?>:</td>
                </tr>
                <tr >
                    <td><?php echo e(translate('2. You can download the pdf to get Category and Brand id.')); ?>:</td>
                </tr>
            </table>
            <a href="<?php echo e(route('seller.pdf.download_category')); ?>"><button class="btn btn-primary mt-2"><?php echo e(translate('Download Category')); ?></button></a>
            <a href="<?php echo e(route('seller.pdf.download_brand')); ?>"><button class="btn btn-primary mt-2"><?php echo e(translate('Download Brand')); ?></button></a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6"><?php echo e(translate('Upload CSV File')); ?></h5>
            </div>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="<?php echo e(route('seller.bulk_product_upload')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"><?php echo e(translate('CSV')); ?></label>
                    <div class="col-sm-10">
                        <div class="custom-file">
    						<label class="custom-file-label">
    							<input type="file" name="bulk_file" class="custom-file-input" required>
    							<span class="custom-file-name"><?php echo e(translate('Choose File')); ?></span>
    						</label>
    					</div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary"><?php echo e(translate('Upload CSV')); ?></button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('seller.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/seller/product/product_bulk_upload/index.blade.php ENDPATH**/ ?>