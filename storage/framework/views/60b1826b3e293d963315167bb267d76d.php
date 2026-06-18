

<?php $__env->startSection('content'); ?>
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3"><?php echo e(translate('Edit Page Information')); ?></h1>
		</div>
	</div>
</div>
<div class="card">
	<!-- <ul class="nav nav-tabs nav-fill language-bar">
		<?php $__currentLoopData = get_all_active_language(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li class="nav-item">
				<a class="nav-link text-reset <?php if($language->code == $lang): ?> active <?php endif; ?> py-3" href="<?php echo e(route('custom-pages.edit', ['id'=>$page->slug, 'lang'=> $language->code] )); ?>">
					<img src="<?php echo e(static_asset('assets/img/flags/'.$language->code.'.png')); ?>" height="11" class="mr-1">
					<span><?php echo e($language->name); ?></span>
				</a>
			</li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul> -->

	<form class="p-4" action="<?php echo e(route('custom-pages.update', $page->id)); ?>" method="POST" enctype="multipart/form-data">
		<?php echo csrf_field(); ?>
		<input type="hidden" name="_method" value="PATCH">
		<input type="hidden" name="lang" value="<?php echo e($lang); ?>">

		<div class="card-header px-0">
			<h6 class="fw-600 mb-0"><?php echo e(translate('Page Content')); ?></h6>
		</div>
		<div class="card-body px-0">
			<div class="form-group row">
				<label class="col-sm-2 col-from-label" for="name"><?php echo e(translate('Title')); ?> <span class="text-danger">*</span> <i class="las la-language text-danger" title="<?php echo e(translate('Translatable')); ?>"></i></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" placeholder="<?php echo e(translate('Title')); ?>" name="title" value="<?php echo e($page->getTranslation('title',$lang)); ?>" required>
				</div>
			</div>


				<div class="form-group row">
					<label class="col-sm-2 col-from-label" for="name"><?php echo e(translate('Link')); ?> <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<div class="input-group d-block d-md-flex">
							<?php if($page->type == 'custom_page'): ?>
								<div class="input-group-prepend"><span class="input-group-text flex-grow-1"><?php echo e(route('home')); ?>/</span></div>
								<input type="text" class="form-control w-100 w-md-auto" placeholder="<?php echo e(translate('Slug')); ?>" name="slug" value="<?php echo e($page->slug); ?>">
							<?php else: ?>
								<input class="form-control w-100 w-md-auto" value="<?php echo e(route('home')); ?>/<?php echo e($page->slug); ?>" disabled>
							<?php endif; ?>
						</div>
						<small class="form-text text-muted"><?php echo e(translate('Use character, number, hypen only')); ?></small>
					</div>
				</div>

			<div class="form-group row">
				<label class="col-sm-2 col-from-label" for="name"><?php echo e(translate('Add Content')); ?> <span class="text-danger">*</span></label>
				<div class="col-sm-10">
					<textarea
						class="aiz-text-editor form-control"
						placeholder="<?php echo e(translate('Content..')); ?>"
						data-buttons='[["font", ["bold", "underline", "italic", "clear"]],["para", ["ul", "ol", "paragraph"]],["style", ["style"]],["color", ["color"]],["table", ["table"]],["insert", ["link", "picture", "video"]],["view", ["fullscreen", "codeview", "undo", "redo"]]]'
						data-min-height="300"
						name="content"
						required
					><?php echo $page->getTranslation('content',$lang); ?></textarea>
				</div>
			</div>
		</div>

		<div class="card-header px-0">
			<h6 class="fw-600 mb-0"><?php echo e(translate('Seo Fields')); ?></h6>
		</div>
		<div class="card-body px-0">

			<div class="form-group row">
				<label class="col-sm-2 col-from-label" for="name"><?php echo e(translate('Meta Title')); ?></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" placeholder="<?php echo e(translate('Title')); ?>" name="meta_title" value="<?php echo e($page->meta_title); ?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-from-label" for="name"><?php echo e(translate('Meta Description')); ?></label>
				<div class="col-sm-10">
					<textarea class="resize-off form-control" placeholder="<?php echo e(translate('Description')); ?>" name="meta_description"><?php echo $page->meta_description; ?></textarea>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-from-label" for="name"><?php echo e(translate('Keywords')); ?></label>
				<div class="col-sm-10">
					<textarea class="resize-off form-control" placeholder="<?php echo e(translate('Keyword, Keyword')); ?>" name="keywords"><?php echo $page->keywords; ?></textarea>
					<small class="text-muted"><?php echo e(translate('Separate with coma')); ?></small>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-from-label" for="name"><?php echo e(translate('Meta Image')); ?></label>
				<div class="col-sm-10">
					<div class="input-group " data-toggle="aizuploader" data-type="image">
							<div class="input-group-prepend">
								<div class="input-group-text bg-soft-secondary font-weight-medium"><?php echo e(translate('Browse')); ?></div>
						</div>
						<div class="form-control file-amount"><?php echo e(translate('Choose File')); ?></div>
						<input type="hidden" name="meta_image" class="selected-files" value="<?php echo e($page->meta_image); ?>">
					</div>
					<div class="file-preview">
					</div>
				</div>
			</div>

			<div class="text-right">
				<button type="submit" class="btn btn-primary"><?php echo e(translate('Update Page')); ?></button>
			</div>
		</div>
	</form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/backend/website_settings/pages/edit.blade.php ENDPATH**/ ?>