

<?php $__env->startSection('content'); ?>
<style>
    @media (max-width: 576px) {
        .right-content {
            padding: 15px !important;
            height: auto !important;
        }

        .aiz-main-wrapper {
            align-items: center !important;
            /* ✅ allow natural top spacing */
            padding-top: 80px;
            /* ✅ space from top */
            padding-bottom: 20px;
        }

        .mobile-top-space {
            margin-top: 80px;
        }

    }

    .site-logo {
    width: auto;
    height: auto;
    max-width: 120px; /* adjust as needed */
}

.site-logo img {
    width: 100%;
    height: auto;
    object-fit: contain;
    display: block;
}
</style>





<div class="aiz-main-wrapper d-flex flex-column justify-content-md-center bg-white">
    <section class="bg-white overflow-hidden">
        <div class="row">
            <div class="col-xxl-6 col-xl-9 col-lg-10 col-md-7 mx-auto py-lg-4">
                <div class="card shadow-none rounded-0 border-0">
                    <div class="row no-gutters">
                        <!-- Left Side Image-->
                        <div class="d-none"></div>

                        <!-- Right Side -->
                        <div class="col-12 col-md-10 col-lg-9 mx-auto p-4 p-lg-5 d-flex flex-column justify-content-center border rounded shadow-sm right-content">
                            <!-- Site Icon -->
                           <div class="site-logo mb-3 mx-auto mx-lg-0 mobile-top-space">
    <img src="<?php echo e(uploaded_asset(get_setting('site_icon'))); ?>"
         alt="<?php echo e(translate('Site Icon')); ?>"
         class="img-fluid">
</div>

                            <!-- Titles -->
                            <div class="text-center text-lg-left mobile-top-space">
                                <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;"><?php echo e(translate('Create an account')); ?></h1>
                            </div>

                            <!-- Register form -->
                            <div class="py-4">
                                <div class="">

                                    <form id="reg-form" class="form-default" role="form" action="<?php echo e(route('register')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <!-- Name -->
                                        <div class="row">

                                            <!-- Row 1 -->
                                            <div class="col-md-6">
                                                <!-- Name -->
                                                <div class="form-group">
                                                    <label for="name" class="fs-12 fw-700 text-soft-dark">
                                                        <?php echo e(translate('Full Name')); ?>

                                                    </label>

                                                    <input type="text"
                                                        class="form-control rounded-0<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>"
                                                        value="<?php echo e(old('name')); ?>"
                                                        placeholder="<?php echo e(translate('Full Name')); ?>"
                                                        name="name">

                                                    <?php if($errors->has('name')): ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">

                                                <?php if(addon_is_activated('otp_system')): ?>

                                                <div id="emailOrPhoneDiv">

                                                    <!-- EMAIL FIELD -->
                                                    <div class="form-group email-form-group mb-1 d-none">
                                                        <label for="email" class="fs-12 fw-700 text-soft-dark">
                                                            <?php echo e(translate('Email')); ?>

                                                        </label>

                                                        <div class="input-group">
                                                            <input type="email"
                                                                class="form-control rounded-0 <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
                                                                value="<?php echo e(old('email')); ?>"
                                                                placeholder="<?php echo e(translate('Email')); ?>"
                                                                id="signinAddonEmail"
                                                                name="email"
                                                                autocomplete="off">

                                                            <?php if(get_setting('customer_registration_verify') == '1'): ?>
                                                            <button class="btn btn-primary ml-2"
                                                                type="button"
                                                                id="sendOtpBtn"
                                                                onclick="sendVerificationCode(this)">
                                                                <?php echo e(translate('Verify')); ?>

                                                            </button>
                                                            <?php endif; ?>
                                                        </div>

                                                        <?php if($errors->has('email')): ?>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong><?php echo e($errors->first('email')); ?></strong>
                                                        </span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- PHONE FIELD -->
                                                    <div class="form-group phone-form-group mb-1">
                                                        <label for="phone" class="fs-12 fw-700 text-soft-dark">
                                                            <?php echo e(translate('Phone')); ?>

                                                        </label>

                                                        <div class="input-group registration-iti">
                                                            <input type="tel"
                                                                phone-number
                                                                id="phone-code"
                                                                class="form-control rounded-0<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>"
                                                                value="<?php echo e(old('phone')); ?>"
                                                                placeholder=""
                                                                name="phone"
                                                                autocomplete="off">

                                                            <?php if(get_setting('customer_registration_verify') == '1'): ?>
                                                            <button class="btn btn-primary"
                                                                type="button"
                                                                id="sendOtpPhoneBtn"
                                                                onclick="sendVerificationCode(this)">
                                                                <?php echo e(translate('Verify')); ?>

                                                            </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <input type="hidden"
                                                        id="country_code"
                                                        name="country_code"
                                                        value="<?php echo e(old('country_code', 'US')); ?>">

                                                    <div class="form-group text-right mb-0" id="mail_phone_toggle_btn">
                                                        <button class="btn btn-link p-0 text-primary"
                                                            type="button"
                                                            onclick="toggleEmailPhone(this)">
                                                            <i>*<?php echo e(translate('Use Email Instead')); ?></i>
                                                        </button>
                                                    </div>

                                                </div>

                                                <?php else: ?>

                                                <!-- EMAIL NORMAL -->
                                                <div class="form-group email-form-group email-phone-div" id="emailOrPhoneDiv">

                                                    <label for="email" class="fs-12 fw-700 text-soft-dark">
                                                        <?php echo e(translate('Email')); ?>

                                                    </label>

                                                    <div class="input-group">
                                                        <input type="email"
                                                            class="form-control rounded-0 <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
                                                            name="email"
                                                            id="signinSrEmail"
                                                            placeholder="<?php echo e(translate('Email Address')); ?>">

                                                        <?php if(get_setting('customer_registration_verify') == '1'): ?>
                                                        <button class="btn btn-primary ml-2"
                                                            type="button"
                                                            id="sendOtpBtn"
                                                            onclick="sendVerificationCode()">
                                                            <?php echo e(translate('Verify')); ?>

                                                        </button>
                                                        <?php endif; ?>
                                                    </div>

                                                    <?php if($errors->has('email')): ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                                    </span>
                                                    <?php endif; ?>

                                                </div>

                                                <?php endif; ?>

                                            </div>

                                            <!-- Row 2 -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="fs-12 fw-700 text-soft-dark">
                                                        <?php echo e(translate('Phone')); ?>

                                                    </label>

                                                    <input type="text"
                                                        class="form-control rounded-0 <?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>"
                                                        name="phone"
                                                        value="<?php echo e(old('phone')); ?>"
                                                        placeholder="<?php echo e(translate('Enter Phone Number')); ?>">
                                                </div>
                                            </div>

                                            

                                            <!-- Row 3 -->
                                            <div class="col-md-6">
                                                <!-- Password -->
                                                <div class="form-group mb-0">
                                                    <label for="password" class="fs-12 fw-700 text-soft-dark">
                                                        <?php echo e(translate('Password')); ?>

                                                    </label>

                                                    <div class="position-relative">
                                                        <input type="password"
                                                            class="form-control rounded-0<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>"
                                                            placeholder="<?php echo e(translate('Password')); ?>"
                                                            name="password">

                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>

                                                    <div class="text-right mt-1">
                                                        <span class="fs-12 fw-400 text-gray-dark">
                                                            <?php echo e(translate('Password must contain at least 6 digits')); ?>

                                                        </span>
                                                    </div>

                                                    <?php if($errors->has('password')): ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Confirm Password -->
                                                <div class="form-group">
                                                    <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">
                                                        <?php echo e(translate('Confirm Password')); ?>

                                                    </label>

                                                    <div class="position-relative">
                                                        <input type="password"
                                                            class="form-control rounded-0"
                                                            placeholder="<?php echo e(translate('Confirm Password')); ?>"
                                                            name="password_confirmation">

                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Referral -->
                                                <div class="form-group">
                                                    <label class="fs-12 fw-700 text-soft-dark">
                                                        Referral Code (Optional)
                                                    </label>

                                                   <input type="text"
    class="form-control rounded-0"
    name="referred_by_code"
   value="<?php echo e(old('referred_by_code', $referral_code)); ?>"
    placeholder="Enter Referral Code (Optional)">
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Recaptcha -->
                                        <?php if(get_setting('google_recaptcha') == 1 && get_setting('recaptcha_customer_register') == 1): ?>

                                        <?php if($errors->has('g-recaptcha-response')): ?>
                                        <span class="border invalid-feedback rounded p-2 mb-3 bg-danger text-white" role="alert" style="display: block;">
                                            <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <!-- Terms and Conditions -->
                                        <div class="mb-3">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="checkbox_example_1" required>
                                                <span class=""><?php echo e(translate('By signing up you agree to our ')); ?> <a href="<?php echo e(route('terms')); ?>" class="fw-500"><?php echo e(translate('terms and conditions.')); ?></a></span>
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="mb-4 mt-4">
                                            <button type="submit" class="btn btn-primary btn-block fw-600 rounded-0" id="createAccountBtn"><?php echo e(translate('Create Account')); ?></button>
                                        </div>
                                    </form>

                                    <!-- Social Login -->
                                    <?php if(get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1 || get_setting('apple_login') == 1): ?>
                                    <div class="text-center mb-3">
                                        <span class="bg-white fs-12 text-gray"><?php echo e(translate('Or Join With')); ?></span>
                                    </div>
                                    <ul class="list-inline social colored text-center mb-4">
                                        <?php if(get_setting('facebook_login') == 1): ?>
                                        <li class="list-inline-item">
                                            <a href="<?php echo e(route('social.login', ['provider' => 'facebook'])); ?>" class="facebook">
                                                <i class="lab la-facebook-f"></i>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(get_setting('twitter_login') == 1): ?>
                                        <li class="list-inline-item">
                                            <a href="<?php echo e(route('social.login', ['provider' => 'twitter'])); ?>" class="x-twitter">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#ffffff" viewBox="0 0 16 16" class="mb-2 pb-1">
                                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 
                                                                .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                                                </svg>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(get_setting('google_login') == 1): ?>
                                        <li class="list-inline-item">
                                            <a href="<?php echo e(route('social.login', ['provider' => 'google'])); ?>" class="google">
                                                <i class="lab la-google"></i>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <?php if(get_setting('apple_login') == 1): ?>
                                        <li class="list-inline-item">
                                            <a href="<?php echo e(route('social.login', ['provider' => 'apple'])); ?>" class="apple">
                                                <i class="lab la-apple"></i>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                    <?php endif; ?>
                                </div>

                                <!-- Log In -->
                                <p class="fs-12 text-gray mb-0">
                                    <?php echo e(translate('Already have an account?')); ?>

                                    <a href="<?php echo e(route('user.login')); ?>" class="ml-2 fs-14 fw-700 animate-underline-primary"><?php echo e(translate('Log In')); ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Go Back -->
                    <div class="mt-3 mr-4 mr-md-0">
                        <a href="<?php echo e(url()->previous()); ?>" class="ml-auto fs-14 fw-700 d-flex align-items-center text-primary" style="max-width: fit-content;">
                            <i class="las la-arrow-left fs-20 mr-1"></i>
                            <?php echo e(translate('Back to Previous Page')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php if(get_setting('google_recaptcha') == 1 && get_setting('recaptcha_customer_register') == 1): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo e(env('CAPTCHA_KEY')); ?>"></script>

<script type="text/javascript">
    document.getElementById('reg-form').addEventListener('submit', function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute(`<?php echo e(env('CAPTCHA_KEY')); ?>`, {
                action: 'register'
            }).then(function(token) {
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
<?php echo $__env->make('auth.verifyEmailOrPhone', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
    const regVerifyRequired = {
        {
            get_setting('customer_registration_verify') ? 'true' : 'false'
        }
    };
    //user registerbtn disable
    const createBtn = $('#createAccountBtn');
    const termsCheckbox = $('input[name="checkbox_example_1"]');

    function toggleCreateBtn() {
        const termsChecked = termsCheckbox.is(':checked');
        const regVerified = regVerifyRequired ? (verifyBtn && verifyBtn.classList.contains('disabled')) : true;
        let enableBtn = false;
        if (regVerifyRequired) {
            enableBtn = termsChecked && regVerified;
        } else {
            enableBtn = termsChecked;
        }
        createBtn.prop('disabled', !enableBtn);
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleCreateBtn();
        termsCheckbox.on('change', toggleCreateBtn);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layouts.authentication', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/auth/boxed/user_registration.blade.php ENDPATH**/ ?>