@extends('agent.layout.app')

@section('panel_content')

<style>
    .dashboard-card{
    position: relative;
    background: linear-gradient(135deg, #667eea, #764ba2);;
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
    font-size:30px;
    font-weight:500;
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
            <h2>{{ $totalUsers }} / {{ $userTarget }}</h2>

            @if($userTargetCompleted)
                <span class="text-success font-weight-bold">
                    Target Completed
                </span>
            @else
                <span class="text-info">
                    In Progress
                </span>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Vendor Target</h6>
            <h2>{{ $totalVendors }} / {{ $vendorTarget }}</h2>

            @if($vendorTargetCompleted)
                <span class="text-success font-weight-bold">
                    Target Completed
                </span>
            @else
                <span class="text-info">
                    In Progress
                </span>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Today's Users</h6>
            <h2>{{ $todayUsers }}</h2>
            <span class="text-success">
                Created Today
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Today's Vendors</h6>
            <h2>{{ $todayVendors }}</h2>
            <span class="text-success">
                Created Today
            </span>
        </div>
    </div>

    <!-- NEW CARD -->

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Total Users Created</h6>
            <h2>{{ $totalUsersCreated }}</h2>
            <span class="text-success">
                All Time
            </span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card">
            <h6>Total Vendors Created</h6>
            <h2>{{ $totalVendorsCreated }}</h2>
            <span class="text-success">
                All Time
            </span>
        </div>
    </div>

</div>
@endsection
