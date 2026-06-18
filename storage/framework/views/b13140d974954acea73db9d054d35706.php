

<?php $__env->startSection('panel_content'); ?>

<style>
    .dashboard-card{
    position: relative;
    background: #081426;
    border-radius: 18px;
    padding: 25px;
    min-height: 170px;
    overflow: hidden;

    border: 1px solid rgba(255,255,255,.08);

    box-shadow:
        0 10px 30px rgba(0,0,0,.25),
        inset 0 1px 0 rgba(255,255,255,.05);

    transition: all .3s ease;
}

.dashboard-card::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    width:6px;
    height:100%;
    background:#00ff88;
    border-radius:20px;
}

.dashboard-card:hover{
    transform: translateY(-5px);

    box-shadow:
        0 15px 35px rgba(0,255,136,.15),
        0 10px 25px rgba(0,0,0,.3);
}

.dashboard-card h6{
    color:#ffffff;
    font-size:20px;
    font-weight:500;
    margin-bottom:15px;
}

.dashboard-card h2{
    color:#ffffff;
    font-size:42px;
    font-weight:700;
    margin-bottom:10px;
}

.dashboard-card span{
    font-size:16px;
    font-weight:600;
}

@media(max-width:768px){

    .dashboard-card{
        min-height:auto;
    }

    .dashboard-card h2{
        font-size:32px;
    }
}
</style>
    <h3 class="mb-4">
        Welcome to the Agent Dashboard
    </h3>

    <div class="row">

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>User Target</h6>
            <h2><?php echo e($totalUsers); ?> / <?php echo e($userTarget); ?></h2>

            <?php if($userTargetCompleted): ?>
                <span class="text-success font-weight-bold">
                    Target Completed
                </span>
            <?php else: ?>
                <span class="text-info">
                    In Progress
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Vendor Target</h6>
            <h2><?php echo e($totalVendors); ?> / <?php echo e($vendorTarget); ?></h2>

            <?php if($vendorTargetCompleted): ?>
                <span class="text-success font-weight-bold">
                    Target Completed
                </span>
            <?php else: ?>
                <span class="text-info">
                    In Progress
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Today's Users</h6>
            <h2><?php echo e($todayUsers); ?></h2>
            <span class="text-success">
                Created Today
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Today's Vendors</h6>
            <h2><?php echo e($todayVendors); ?></h2>
            <span class="text-success">
                Created Today
            </span>
        </div>
    </div>

    <!-- NEW CARD -->

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Total Users Created</h6>
            <h2><?php echo e($totalUsersCreated); ?></h2>
            <span class="text-success">
                All Time
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Total Vendors Created</h6>
            <h2><?php echo e($totalVendorsCreated); ?></h2>
            <span class="text-success">
                All Time
            </span>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('agent.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/agent/dashboard.blade.php ENDPATH**/ ?>