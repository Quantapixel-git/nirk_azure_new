

<?php $__env->startSection('panel_content'); ?>



<style>
    .wallet-card{
    position: relative;
    background: linear-gradient(135deg, #667eea, #764ba2);;
    border-radius: 10px;
    padding: 15px;
    min-height: 100px;
    overflow: hidden;

    border: 1px solid rgba(255,255,255,.08);

    box-shadow:
        0 10px 30px rgba(0,0,0,.25),
        inset 0 1px 0 rgba(255,255,255,.05);

    transition: all .3s ease;
}

.wallet-card::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    width:6px;
    height:100%;
    background:#00ff88;
    border-radius:20px;
}

.wallet-card:hover{
    transform: translateY(-5px);

    box-shadow:
        0 15px 35px rgba(0,255,136,.15),
        0 10px 25px rgba(0,0,0,.35);
}

.wallet-card h6{
    color:#ffffff;
    font-size:20px;
    font-weight:500;
    margin-bottom:15px;
}

.wallet-card h2{
    color:#ffffff;
    font-size:30px;
    font-weight:500;
    margin-bottom:10px;
}

.wallet-text{
    color:#00ff88;
    font-size:15px;
    font-weight:600;
}

@media(max-width:768px){

    .wallet-card{
        min-height:auto;
    }

    .wallet-card h2{
        font-size:30px;
    }
}



.network-card-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.network-left{
    text-align:left;
}

.network-right{
    text-align:right;
}

.network-right h2{
    margin:0;
    color:#fff;
    font-size:34px;
    font-weight:700;
}

.network-footer{
    margin-top:15px;
    text-align:right;
}

.network-footer .btn{
    border-radius:8px;
    font-size:13px;
    font-weight:600;
}




.table-responsive table{
    border-radius:10px;
    overflow:hidden;
}

.table thead th{
    vertical-align:middle;
    text-align:center;
}

.table tbody td{
    vertical-align:middle;
}

.badge{
    padding:8px 12px;
    font-size:12px;
}




.status-badge{
    display:inline-block;
    padding:8px 16px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
    text-align:center;
    min-width:100px;
    letter-spacing:.3px;
    border:1px solid transparent;
}

.status-success{
    color:#fff;
    background:linear-gradient(135deg,#28a745,#20c997);
    border-color:#28a745;
    box-shadow:0 4px 10px rgba(40,167,69,.25);
}

.status-warning{
    color:#fff;
    background:linear-gradient(135deg,#ff9800,#ff5722);
    border-color:#ff9800;
    box-shadow:0 4px 10px rgba(255,152,0,.25);
}
</style>





<?php if(auth()->user()->mlm_status == 'blocked'): ?>

<div class="row">
    <div class="col-md-12">

        <div class="alert alert-danger text-center p-4">

            <h3 class="mb-3">
                My Wallet Blocked
            </h3>

            <p class="mb-3">
                Your MY wallet has been blocked due to inactivity during the required 90-day period.
                No MY earnings, withdrawals, wallet usage, or referral commissions can be processed.
            </p>

            <?php if(auth()->user()->mlm_blocked_at): ?>

            <div class="mb-3">
                <strong>
                    Blocked On:
                    <?php echo e(\Carbon\Carbon::parse(auth()->user()->mlm_blocked_at)->format('d M Y h:i A')); ?>

                </strong>
            </div>

            <?php endif; ?>

            <div class="alert alert-warning mb-0">
                Please contact the administrator to reactivate your MY Wallet account.
            </div>

        </div>

    </div>
</div>

<?php else: ?>
<div class="row mb-4">
    <div class="col-md-12">

        <div class="p-4 text-white rounded"
             style="background: linear-gradient(135deg, #667eea, #764ba2);">

            <h5>My Wallet</h5>

           <div class="d-flex justify-content-between align-items-center">

    <div>

        <h3>₹ <?php echo e($confirmedAmount); ?></h3>

        <?php if($confirmedAmount > 0): ?>

            <p class="text-success mb-0">
                You are now eligible to withdraw or use this amount during checkout.
            </p>

        <?php else: ?>

            <p class="text-warning mb-0">
                Return period is not over yet. Please wait.
            </p>

        <?php endif; ?>

    </div>

    <?php if($confirmedAmount > 0): ?>

    <button class="btn btn-light"
            data-toggle="modal"
            data-target="#withdrawModal">

        Request Withdrawal

    </button>

    <?php endif; ?>

</div>
        </div>

    </div>
</div>

<div class="my-2">
    <h3 class="font-weight-bold">
        My Wallet Stats
    </h3>
</div>

<?php
$totalWalletUsed = DB::table('orders')
    ->where('user_id', auth()->id())
    ->sum('mlm_wallet_used');
?>

<div class="row">

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Total Earned</h6>
            <h2>₹ <?php echo e(number_format($totalEarning,2)); ?></h2>
            <span class="wallet-text">
                Commission Earnings
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Total Withdrawn</h6>
            <h2>₹ <?php echo e(number_format($totalWithdrawn,2)); ?></h2>
            <span class="wallet-text">
                Withdrawal History
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Used In Orders</h6>
            <h2>₹ <?php echo e(number_format($totalWalletUsed,2)); ?></h2>
            <span class="wallet-text">
                Wallet Usage
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Refunded Amount</h6>
            <h2>₹ <?php echo e(number_format($refundedAmount,2)); ?></h2>
            <span class="wallet-text">
                Refunded Orders
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="wallet-card">
            <h6>Available Balance</h6>
            <h2>₹ <?php echo e(number_format($confirmedAmount,2)); ?></h2>
            <span class="wallet-text">
                Ready To Withdraw
            </span>
        </div>
    </div>

</div>


<div class="my-2">
    <h3 class="font-weight-bold">
        My Network Statistics
    </h3>
</div>


<div class="row">

<?php $__empty_1 = true; $__currentLoopData = $networkStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<div class="col-lg-4 col-md-6 mb-4">

    <div class="wallet-card">

        <div class="network-card-top">

            <div class="network-left">

                <h6><?php echo e($stat['level']); ?></h6>

                <?php if($key == 0): ?>
                    <span class="wallet-text">
                        Orders : <?php echo e($stat['orders']); ?>

                    </span>
                <?php endif; ?>

            </div>

            <div class="network-right">
                <h2><?php echo e($stat['count']); ?></h2>
            </div>

        </div>

        <div class="network-footer">

            <button class="btn btn-light btn-sm"
                    data-toggle="modal"
                    data-target="#networkModal<?php echo e($key); ?>">
                View Details
            </button>

        </div>

    </div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<div class="col-md-12">

    <div class="wallet-card text-center">

        <h5 class="mb-2 text-white">
            No Network Available
        </h5>

        <p class="mb-0 text-white">
            You don't have any network members yet.
        </p>

    </div>

</div>

<?php endif; ?>

</div>
<?php $__currentLoopData = $networkStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="modal fade"
     id="networkModal<?php echo e($key); ?>">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5>
                    <?php echo e($stat['level']); ?> Users
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>

            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>

                        <?php if($key == 0): ?>
                        <th>Total Orders</th>
                        <?php endif; ?>

                    </tr>

                    </thead>

                    <tbody>

                    <?php $__currentLoopData = $stat['users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr>

                        <td><?php echo e($user->name); ?></td>

                        <td><?php echo e($user->email); ?></td>

                        <td><?php echo e($user->phone); ?></td>

                        <?php if($key == 0): ?>

                        <td>

                           <button class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#orderModal<?php echo e($user->id); ?>">

    <?php echo e($user->level1_orders ?? 0); ?> Orders

</button>

                        </td>

                        <?php endif; ?>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if(isset($networkStats[0]['users'])): ?>
<?php $__currentLoopData = $networkStats[0]['users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="modal fade"
     id="orderModal<?php echo e($user->id); ?>">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5>
                    Orders - <?php echo e($user->name); ?>

                </h5>
<button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>Order Code</th>
                        <th>Amount</th>
                        <th>Date</th>

                    </tr>

                    </thead>

                    <tbody>

                  <?php
$orderIds = DB::table('mlm_wallet')
    ->where('user_id', $user->id)
    ->where('level', 1)
    ->whereNotNull('order_id')
    ->distinct()
    ->pluck('order_id');

$orders = \App\Models\Order::whereIn('id', $orderIds)
    ->latest()
    ->get();
?>

<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

                        <td><?php echo e($order->code); ?></td>

                        <td>₹ <?php echo e($order->grand_total); ?></td>

                        <td><?php echo e($order->created_at); ?></td>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<div class="my-2">
    <h3 class="font-weight-bold">
        My All Levels History
    </h3>
</div>


<div class="row">

<?php $__empty_1 = true; $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $levelName => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<?php
    $totalAmount = collect($items)->sum('pt_value');

   $levelConfirmedAmount = collect($items)
        ->where('wallet_status',1)
        ->sum('pt_value');

    $levelHoldAmount = collect($items)
        ->where('wallet_status',2)
        ->sum('pt_value');

    $totalCoins = collect($items)->sum('pt_coins');
?>

<div class="card mb-4 border-0 shadow-lg"
     style="background: linear-gradient(135deg,#667eea,#764ba2); border-radius:15px;">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="text-white mb-1">
                    <?php echo e($levelName); ?>

                </h4>

                <small class="text-light">
                    My Earnings Summary
                </small>
            </div>

            <div class="text-right">

                <div class="text-white font-weight-bold">
                    Confirmed:
                   ₹ <?php echo e(number_format($levelConfirmedAmount,2)); ?>

                </div>

                <div class="text-warning font-weight-bold">
                    Hold:
                    ₹ <?php echo e(number_format($levelHoldAmount,2)); ?>

                </div>

                <div class="text-success font-weight-bold">
                    Total:
                    ₹ <?php echo e(number_format($totalAmount,2)); ?>

                </div>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-striped mb-0 bg-white">

                <thead class="thead-dark">

                <tr>
                    <th width="8%">#</th>
                    <th>User Name</th>
                    <th>Total Coins</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>

                </thead>

                <tbody>

                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>

                    <td><?php echo e($index + 1); ?></td>

                    <td>
                        <?php echo e($trx->buyer_name ?? 'Self Purchase'); ?>

                    </td>

                    <td>
                        <?php echo e(number_format($trx->pt_coins,2)); ?>

                    </td>

                    <td>
                        ₹ <?php echo e(number_format($trx->pt_value,2)); ?>

                    </td>

                    <td>

                        <?php if($trx->wallet_status == 1): ?>

    <span class="status-badge status-success">
        Confirmed
    </span>

<?php else: ?>

    <span class="status-badge status-warning">
        On Hold
    </span>

<?php endif; ?>

                    </td>

                    <td>

                        <?php if($levelName == 'Level 0'): ?>

                            I purchased
                            <strong>
                                <?php echo e($trx->product_name ?? 'a product'); ?>

                            </strong>
                            and earned
                            ₹ <?php echo e($trx->pt_value); ?>


                        <?php else: ?>

                            <strong>
                                <?php echo e($trx->buyer_name ?? 'A user'); ?>

                            </strong>

                            purchased

                            <strong>
                                <?php echo e($trx->product_name ?? 'a product'); ?>

                            </strong>

                            and you earned

                            ₹ <?php echo e($trx->pt_value); ?>


                            from

                            <?php echo e($levelName); ?>


                        <?php endif; ?>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>

                <tfoot>

                <tr class="font-weight-bold bg-light">

                    <td colspan="2">
                        Total
                    </td>

                    <td>
                        <?php echo e(number_format($totalCoins,2)); ?>

                    </td>

                    <td>
                        ₹ <?php echo e(number_format($totalAmount,2)); ?>

                    </td>

                    <td colspan="2">
                        Confirmed:
                        ₹ <?php echo e(number_format($levelConfirmedAmount,2)); ?>


                        |
                        Hold:
                         ₹ <?php echo e(number_format($levelHoldAmount,2)); ?>

                    </td>

                </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<div class="alert alert-info text-center">
    No MLM earnings yet
</div>

<?php endif; ?>

</div>


<div class="modal fade"
     id="withdrawModal">

    <div class="modal-dialog">

        <form action="<?php echo e(route('mlm.withdraw.request')); ?>"
              method="POST">

            <?php echo csrf_field(); ?>

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Withdrawal Request</h5>
                </div>

                <div class="modal-body">

                    <label>Amount</label>

                    <input type="number"
                           name="amount"
                           max="<?php echo e($confirmedAmount); ?>"
                           class="form-control"
                           required>

                    <small class="text-muted">
    Available Balance:
    ₹ <?php echo e(number_format($confirmedAmount,2)); ?>

</small>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-primary">

                        Submit Request

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.user_panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u635947223/domains/dialfirst.in/public_html/nirk/resources/views/frontend/user/mlm_wallet.blade.php ENDPATH**/ ?>