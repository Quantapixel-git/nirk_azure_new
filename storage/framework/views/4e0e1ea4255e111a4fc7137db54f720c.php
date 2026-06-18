

<?php $__env->startSection('panel_content'); ?>

<div class="aiz-titlebar mt-2 mb-4">

    <div class="row align-items-center">

        <div class="col">
            <h1 class="h3">
                Create User Account
            </h1>
        </div>

    </div>

</div>

<form action="<?php echo e(route('agent.users.store')); ?>"
      method="POST">

    <?php echo csrf_field(); ?>

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0 h6">
                User Information
            </h5>
        </div>

        <div class="card-body">

            <div class="form-group row">

                <label class="col-md-2 col-form-label">
                    Name
                </label>

                <div class="col-md-10">
                    <input type="text"
                           name="name"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2 col-form-label">
                    Email
                </label>

                <div class="col-md-10">
                    <input type="email"
                           name="email"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2 col-form-label">
                    Phone
                </label>

                <div class="col-md-10">
                    <input type="text"
                           name="phone"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2 col-form-label">
                    Password
                </label>

                <div class="col-md-10">
                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="form-group row">

                <label class="col-md-2 col-form-label">
                    Confirm Password
                </label>

                <div class="col-md-10">
                    <input type="password"
                           name="confirm_password"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="text-right">

                <button type="submit"
                        class="btn btn-primary">

                    Create User

                </button>

            </div>

        </div>

    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('agent.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/users/create.blade.php ENDPATH**/ ?>