<?php
    $layout = 'frontend.layouts.app';

    if (addon_is_activated('portfolio_system')) {
        $user = auth()->user();

        if (
            !$user ||
            $user->verification_status == 0 ||
            optional($user->shop)->verification_status == 0
        ) {
            $layout = 'frontend.layouts.portfolio_app';
        }
    }
?>



<?php $__env->startSection('meta_title'); ?><?php echo e($page->meta_title); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta_description'); ?><?php echo e($page->meta_description); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta_keywords'); ?><?php echo e($page->tags); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?php echo e($page->meta_title); ?>">
    <meta itemprop="description" content="<?php echo e($page->meta_description); ?>">
    <meta itemprop="image" content="<?php echo e(uploaded_asset($page->meta_image)); ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="website">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="<?php echo e($page->meta_title); ?>">
    <meta name="twitter:description" content="<?php echo e($page->meta_description); ?>">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="<?php echo e(uploaded_asset($page->meta_image)); ?>">

    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo e($page->meta_title); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo e(URL($page->slug)); ?>" />
    <meta property="og:image" content="<?php echo e(uploaded_asset($page->meta_image)); ?>" />
    <meta property="og:description" content="<?php echo e($page->meta_description); ?>" />
    <meta property="og:site_name" content="<?php echo e(env('APP_NAME')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="pt-4 my-4">
    <?php
        $lang = str_replace('_', '-', app()->getLocale());
        $content = json_decode($page->getTranslation('content', $lang));
    ?>
    <div class="container">
        <div class="" style="background-color: <?php echo e(hex2rgba(get_setting('base_color', '#d43533'), 0.02)); ?>">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <div class="p-3 p-md-4 p-xl-5">
                        <h1 class="fs-36 fw-700 mb-4"><?php echo e($page->getTranslation('title')); ?></h1>
                        <p class="fs-16 fw-400 mb-5"><?php echo e($content->description); ?></p>
                        <div class="d-flex mb-5">
                            <span class="size-48px d-flex align-items-center justify-content-center border border-gray-500 rounded-content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19.201" height="24" viewBox="0 0 19.201 24">
                                    <path id="c2b0eedccc4761c59dc63e9987216605" d="M13.6,2A9.611,9.611,0,0,0,4,11.6c0,3.906,2.836,7.15,5.839,10.583.95,1.087,1.934,2.212,2.81,3.349a1.2,1.2,0,0,0,1.9,0c.876-1.138,1.86-2.262,2.81-3.349,3-3.433,5.839-6.677,5.839-10.583A9.611,9.611,0,0,0,13.6,2Zm0,13.2a3.6,3.6,0,1,1,3.6-3.6A3.6,3.6,0,0,1,13.6,15.2Z" transform="translate(-4 -2)" fill="#9d9da6"/>
                                </svg>
                            </span>
                            <span class="ml-3">
                                <span class="fs-19 fw-700"><?php echo e(translate('Address')); ?></span><br>
                                <span class="fs-14 text-secondary"><?php echo str_replace("\n", "<br>", $content->address); ?></span>
                            </span>
                        </div>
                        <div class="d-flex mb-5">
                            <span class="size-48px d-flex align-items-center justify-content-center border border-gray-500 rounded-content">
                                <i class="las la-2x la-phone text-gray"></i>
                            </span>
                            <span class="ml-3">
                                <span class="fs-19 fw-700"><?php echo e(translate('Phone')); ?></span><br>
                                <span class="fs-14 text-secondary"><?php echo e($content->phone); ?></span>
                            </span>
                        </div>
                        <div class="d-flex">
                            <span class="size-48px d-flex align-items-center justify-content-center border border-gray-500 rounded-content">
                                <i class="las la-2x la-envelope text-gray"></i>
                            </span>
                            <span class="ml-3">
                                <span class="fs-19 fw-700"><?php echo e(translate('Email Address')); ?></span><br>
                                <span class="fs-14 text-secondary"><?php echo e($content->email); ?></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-3 p-md-4 p-xl-5">
                        <div class="bg-white p-4 p-xl-2rem border rounded-3">
                            <form class="form-default" id="contact-us" role="form" action="<?php echo e(route('contact')); ?>" method="POST">
                                <?php echo csrf_field(); ?>

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name" class="fs-14 fw-700 text-soft-dark"><?php echo e(translate('Name')); ?></label>
                                    <input type="text" class="form-control rounded-0" value="<?php echo e(old('name')); ?>" placeholder="<?php echo e(translate('Enter Name')); ?>" name="name" required>
                                </div>
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email" class="fs-14 fw-700 text-soft-dark"><?php echo e(translate('Email')); ?></label>
                                    <input type="email" class="form-control rounded-0" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(translate('Enter Email')); ?>" name="email" required>
                                </div>
                                <!-- Phone -->
                                <div class="form-group">
                                    <label for="phone" class="fs-14 fw-700 text-soft-dark"><?php echo e(translate('Phone no. (optional)')); ?></label>
                                    <input type="tel" class="form-control rounded-0" value="<?php echo e(old('phone')); ?>" placeholder="<?php echo e(translate('Enter Phone')); ?>" name="phone">
                                </div>
                                <!-- Query -->
                                <div class="form-group">
                                    <label for="query" class="fs-14 fw-700 text-soft-dark"><?php echo e(translate('Tell us about your query')); ?></label>
                                    <textarea
                                        class="form-control rounded-0"
                                        placeholder="<?php echo e(translate('Type here...')); ?>"
                                        name="content"
                                        rows="3"
                                        required
                                    ></textarea>
                                </div>

                               <!-- Recaptcha -->
                                <?php if(get_setting('google_recaptcha') == 1 && get_setting('recaptcha_contact_form') == 1): ?> 
                                    
                                    <?php if($errors->has('g-recaptcha-response')): ?>
                                        <span class="border invalid-feedback rounded p-2 mb-3 bg-danger text-white" role="alert" style="display: block;">
                                            <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <?php if(env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null): ?>
                                        <a class="btn btn-primary fw-700 fs-14 rounded-0 w-200px"
                                            href="javascript:void(1)" onclick="showWarning()">
                                            <?php echo e(translate('Submit')); ?>

                                        </a>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-primary fw-700 fs-14 rounded-0 w-200px"><?php echo e(translate('Submit')); ?></button>
                                    <?php endif; ?>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
     <?php if(get_setting('google_recaptcha') == 1 && get_setting('recaptcha_contact_form') == 1): ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo e(env('CAPTCHA_KEY')); ?>"></script>
        
        <script type="text/javascript">
                document.getElementById('contact-us').addEventListener('submit', function(e) {
                    e.preventDefault();
                    grecaptcha.ready(function() {
                        grecaptcha.execute(`<?php echo e(env('CAPTCHA_KEY')); ?>`, {action: 'contact_us'}).then(function(token) {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'hidden');
                            input.setAttribute('name', 'g-recaptcha-response');
                            input.setAttribute('value', token);
                            e.target.appendChild(input);
                            e.target.submit();
                        });
                    });
                });
        </script>
    <?php endif; ?>


    <script type="text/javascript">
        function showWarning(){
            AIZ.plugins.notify('warning', "<?php echo e(translate('Something went wrong.')); ?>");
            return false;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/contact_us_page.blade.php ENDPATH**/ ?>