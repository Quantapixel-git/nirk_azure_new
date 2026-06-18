@extends('frontend.layouts.app')


@section('content')
<style>
    :root {
        --primary-color: #2563eb;
        --primary-dark: #1d4ed8;
        --light-bg: #f4f7ff;
        --border-color: #e5e7eb;
        --text-dark: #111827;
        --text-light: #6b7280;
        --success: #10b981;
    }

    body {
        background: linear-gradient(to right, #f8fbff, #eef4ff);
    }

    .kyc-wrapper {
        padding: 60px 15px;
    }

    .kyc-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.08);
        overflow: hidden;
        border: 1px solid #edf1f7;
    }

    .kyc-header {
        background: linear-gradient(135deg, var(--primary-color), #3b82f6);
        padding: 28px 35px;
        color: #fff;
    }

    .kyc-header h2 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .kyc-header p {
        margin: 0;
        opacity: .9;
    }

    .stepper-wrapper {
        padding: 35px 30px 15px;
    }

    .stepper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-bottom: 10px;
    }

    .stepper::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 10%;
        width: 80%;
        height: 4px;
        background: #e5e7eb;
        z-index: 1;
    }

    .step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #d1d5db;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin: auto;
        transition: .3s;
    }

    .step.active .step-circle {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
    }

    .step.completed .step-circle {
        background: var(--success);
        border-color: var(--success);
        color: #fff;
    }

    .step-label {
        margin-top: 12px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-section {
        padding: 20px 35px 40px;
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-subtitle {
        color: var(--text-light);
        margin-bottom: 30px;
    }

    .form-control,
    .form-select {
        height: 56px;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        padding-left: 16px;
        font-size: 15px;
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
    }

    .input-group-text {
        border-radius: 14px 0 0 14px;
        background: #f9fafb;
        border-color: var(--border-color);
    }

    .step-content {
        display: none;
        animation: fadeIn .4s ease;
    }

    .step-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-kyc {
        border: none;
        border-radius: 14px;
        padding: 14px 28px;
        font-weight: 600;
        transition: .3s;
        font-size: 15px;
    }

    .btn-next {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.18);
    }

    .btn-next:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .btn-prev {
        background: #eef2ff;
        color: var(--primary-color);
    }

    .btn-prev:hover {
        background: #dbeafe;
        color: var(--primary-dark);
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.18);
    }

    .btn-submit:hover {
        color: #fff;
        transform: translateY(-2px);
    }

    .action-btns {
        margin-top: 35px;
    }

    .kyc-icon-box {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background: rgba(37, 99, 235, .08);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    .kyc-icon-box i {
        font-size: 30px;
        color: var(--primary-color);
    }

    @media(max-width:768px) {

        .kyc-header,
        .form-section {
            padding-left: 20px;
            padding-right: 20px;
        }

        .step-label {
            font-size: 12px;
        }

        .step-circle {
            width: 42px;
            height: 42px;
            font-size: 14px;
        }

        .form-title {
            font-size: 22px;
        }

        .action-btns {
            flex-direction: column;
            gap: 15px;
        }

        .action-btns .d-flex {
            width: 100%;
        }

        .btn-kyc {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container kyc-wrapper">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            <div class="kyc-card">

                <!-- Header -->
                <div class="kyc-header">
                    <h2>KYC Verification</h2>
                    <p>Complete your verification in 3 secure steps</p>
                </div>

                <!-- Stepper -->
                <div class="stepper-wrapper">
                    <div class="stepper">

                        <div class="step active" id="indicator-1" onclick="goToStep(1)">
                            <div class="step-circle">1</div>
                            <div class="step-label">Bank Verification</div>
                        </div>

                        <div class="step" id="indicator-2" onclick="goToStep(2)">
                            <div class="step-circle">2</div>
                            <div class="step-label">Aadhaar Verification</div>
                        </div>

                        <div class="step" id="indicator-3" onclick="goToStep(3)">
                            <div class="step-circle">3</div>
                            <div class="step-label">PAN Verification</div>
                        </div>

                    </div>
                </div>

                <div class="form-section">

                    <form id="kycForm">
                        @csrf

                        <!-- STEP 1 -->
                        <div class="step-content active" id="step-1">

                            <div class="kyc-icon-box">
                                <i class="bi bi-bank"></i>
                            </div>

                            <h3 class="form-title">Bank Verification</h3>
                            <p class="form-subtitle">
                                Verify your bank details securely for faster payouts and transactions.
                            </p>

                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Bank Name</label>
                                    <select class="form-select" id="bank_name">
                                        <option selected disabled>Select Your Bank</option>
                                        <option value="State Bank of India"
                                            {{ $kyc->bank_name == 'State Bank of India' ? 'selected' : '' }}>
                                            State Bank of India
                                        </option>
                                        <option>HDFC Bank</option>
                                        <option>ICICI Bank</option>
                                        <option>Axis Bank</option>
                                        <option>Punjab National Bank</option>
                                        <option>Bank of Baroda</option>
                                        <option>Kotak Mahindra Bank</option>
                                        <option>Canara Bank</option>
                                        <option>Union Bank of India</option>
                                        <option>IDFC First Bank</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Account Holder Name</label>
                                    <input type="text" value="{{ $kyc->bank_holder }}" id="holder_name" class="form-control" placeholder="Enter Account Holder Name">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Bank Account Number</label>
                                    <input type="text" class="form-control" value="{{ $kyc->bank_account }}" id="account_number" placeholder="Enter Account Number">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control" value="{{ $kyc->bank_ifsc }}" id="ifsc_code" placeholder="Enter IFSC Code">
                                </div>
                                <div class="col-md-6 mb-4">
    <label class="form-label">Bank Passbook</label>
    <input type="file"
           class="form-control"
           id="bank_passbook">
</div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Phone Number</label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone"></i>
                                        </span>

                                        <input type="text" class="form-control" value="{{ $kyc->phone }}" id="phone_number" placeholder="Enter Phone Number">
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end action-btns">
                                <button type="button" class="btn btn-kyc btn-next" onclick="saveBankStep()">
                                    Next Step
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                        </div>

                        <!-- STEP 2 -->
                        <div class="step-content" id="step-2">

                            <div class="kyc-icon-box">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <h3 class="form-title">Aadhaar Verification</h3>
                            <p class="form-subtitle">
                                Enter your Aadhaar number to continue verification process.
                            </p>

                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label">Aadhaar Number</label>
                                    <input type="text"
                                        class="form-control"
                                        id="aadhaar_number"
                                        value="{{ $kyc->aadhar }}"
                                        maxlength="12"
                                        placeholder="Enter Your Aadhaar Number">
                                </div>

                                <div class="col-md-6 mb-4 mt-2">
    <label class="form-label">Aadhaar Front</label>
    <input type="file"
           class="form-control"
           id="aadhar_front">
</div>

<div class="col-md-6 mb-4 mt-2 ">
    <label class="form-label">Aadhaar Back</label>
    <input type="file"
           class="form-control"
           id="aadhar_back">
</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center action-btns">

                                <button type="button"
                                    class="btn btn-kyc btn-prev"
                                    onclick="prevStep(1)">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Previous
                                </button>

                                <button type="button"
                                    class="btn btn-kyc btn-next"
                                    onclick="saveAadharStep()">
                                    Next Step
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>

                            </div>

                        </div>

                        <!-- STEP 3 -->
                        <div class="step-content" id="step-3">

                            <div class="kyc-icon-box">
                                <i class="bi bi-person-vcard"></i>
                            </div>

                            <h3 class="form-title">PAN Verification</h3>
                            <p class="form-subtitle">
                                Submit your PAN details to complete your KYC verification.
                            </p>

                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label">PAN Number</label>
                                    <input type="text"
                                        class="form-control"
                                        id="pan_number"
                                        value="{{ $kyc->pan  }}"
                                        placeholder="Enter Your PAN Number">
                                </div>

                                <div class="col-md-6 mb-4 mt-2">
    <label class="form-label">PAN Front</label>
    <input type="file"
           class="form-control"
           id="pan_front">
</div>

<div class="col-md-6 mb-4 mt-2">
    <label class="form-label">PAN Back</label>
    <input type="file"
           class="form-control"
           id="pan_back">
</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center action-btns">

                                <button type="button"
                                    class="btn btn-kyc btn-prev"
                                    onclick="prevStep(2)">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Previous
                                </button>

                                <button type="button"
                                    class="btn btn-kyc btn-submit"
                                    onclick="savePanStep()">

                                    Submit KYC
                                    <i class="bi bi-check-circle ms-2"></i>
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Current step from backend
    let currentStepFromBackend = {{ $currentStep }};
    let currentStep = 1; // Default to Step 1

    // Completed steps based on DB values
    let completedSteps = {
        1: {{ $kyc->is_bank == 1 ? 'true' : 'false' }},
        2: {{ $kyc->is_aadhar == 1 ? 'true' : 'false' }},
        3: {{ $kyc->is_pan == 1 ? 'true' : 'false' }}
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Locking logic for new users
        if (completedSteps[1] === false) {
            currentStep = 1; // Always start with Step 1
        } else if (completedSteps[2] === false) {
            currentStep = 2; // Step 2 unlocked only if Step 1 completed
        } else if (completedSteps[3] === false) {
            currentStep = 3; // Step 3 unlocked only if Step 2 completed
        }

        showStep(currentStep);
        updateIndicator(currentStep);
    });

    // SHOW STEP
    function showStep(step) {
        currentStep = step;
        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        updateIndicator(step);
    }

    // UPDATE STEPPER UI
    function updateIndicator(step) {
        document.querySelectorAll('.step').forEach((el, index) => {
            el.classList.remove('active', 'completed');
            let stepNumber = index + 1;

            if (completedSteps[stepNumber]) el.classList.add('completed');
            if (stepNumber == step) el.classList.add('active');
        });
    }

    // DIRECT STEP CLICK
    function goToStep(step) {
        // Only allow click if previous step is completed
        if (step === 1 || completedSteps[step - 1]) {
            showStep(step);
        } else {
            Swal.fire('Oops', 'Please complete previous step first', 'warning');
        }
    }

    // PREVIOUS STEP BUTTON
    function prevStep(step) { showStep(step); }

    // NEXT STEP BUTTON
    function nextStep(step) {
        if (validateStep(currentStep)) {
            completedSteps[currentStep] = true;
            showStep(step);
        }
    }

    // VALIDATION FUNCTION
    function validateStep(step) {
        if (step == 1) {
            let bankName = document.getElementById('bank_name').value.trim();
            let holderName = document.getElementById('holder_name').value.trim();
            let accountNumber = document.getElementById('account_number').value.trim();
            let ifscCode = document.getElementById('ifsc_code').value.trim();
            let phoneNumber = document.getElementById('phone_number').value.trim();

            if (!bankName) { Swal.fire('Error','Please select bank name','error'); return false; }
            if (!holderName) { Swal.fire('Error','Please enter account holder name','error'); return false; }
            if (!accountNumber) { Swal.fire('Error','Please enter account number','error'); return false; }
            if (!ifscCode) { Swal.fire('Error','Please enter IFSC code','error'); return false; }
            if (!phoneNumber) { Swal.fire('Error','Please enter phone number','error'); return false; }
            if ($('#bank_passbook')[0].files.length === 0) {
    Swal.fire('Error','Please upload Bank Passbook/Cancelled Cheque','error');
    return false;
}

            return true;
        }

        if (step == 2) {

    let aadhaar = document.getElementById('aadhaar_number').value.trim();

    if (!aadhaar) {
        Swal.fire('Error','Please enter Aadhaar number','error');
        return false;
    }

    if (aadhaar.length != 12) {
        Swal.fire('Error','Aadhaar number must be 12 digits','error');
        return false;
    }

    if ($('#aadhar_front')[0].files.length === 0) {
        Swal.fire('Error','Please upload Aadhaar Front Image','error');
        return false;
    }

    if ($('#aadhar_back')[0].files.length === 0) {
        Swal.fire('Error','Please upload Aadhaar Back Image','error');
        return false;
    }

    return true;
}

        if (step == 3) {

    let pan = document.getElementById('pan_number').value.trim();

    if (!pan) {
        Swal.fire('Error','Please enter PAN number','error');
        return false;
    }

    if ($('#pan_front')[0].files.length === 0) {
        Swal.fire('Error','Please upload PAN Front Image','error');
        return false;
    }

    if ($('#pan_back')[0].files.length === 0) {
        Swal.fire('Error','Please upload PAN Back Image','error');
        return false;
    }

    return true;
}

        return true;
    }

    // AJAX SAVE STEPS (unchanged)
    function saveBankStep(){

    let formData = new FormData();

    formData.append('_token',"{{ csrf_token() }}");
    formData.append('bank_name',$('#bank_name').val());
    formData.append('bank_account',$('#account_number').val());
    formData.append('bank_ifsc',$('#ifsc_code').val());
    formData.append('bank_holder',$('#holder_name').val());
    formData.append('phone',$('#phone_number').val());
    formData.append('bank_passbook',$('#bank_passbook')[0].files[0]);

    $.ajax({
        url:"{{ route('save.bank.kyc') }}",
        type:"POST",
        data:formData,
        processData:false,
        contentType:false,
        success:function(response){
            completedSteps[1] = true;
            showStep(2);
            Swal.fire('Success',response.message,'success');
        }
    });
}
    function saveAadharStep() {

    if (!validateStep(2)) return;

    let formData = new FormData();

    formData.append('_token', "{{ csrf_token() }}");
    formData.append('aadhar', $('#aadhaar_number').val());

    formData.append(
        'aadhar_front',
        $('#aadhar_front')[0].files[0]
    );

    formData.append(
        'aadhar_back',
        $('#aadhar_back')[0].files[0]
    );

    $.ajax({
        url: "{{ route('save.aadhar.kyc') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function(response) {

            completedSteps[2] = true;
            showStep(3);

            Swal.fire(
                'Success',
                response.message,
                'success'
            );
        },

        error: function(xhr) {

            if (xhr.status === 422) {

                let errors = xhr.responseJSON.errors;
                let errorMsg = '';

                $.each(errors, function(key, value) {
                    errorMsg += value[0] + '<br>';
                });

                Swal.fire(
                    'Validation Error',
                    errorMsg,
                    'error'
                );

            } else {

                Swal.fire(
                    'Error',
                    'Something went wrong.',
                    'error'
                );

            }
        }
    });
}

   function savePanStep() {

    if (!validateStep(3)) return;

    let formData = new FormData();

    formData.append('_token', "{{ csrf_token() }}");
    formData.append('pan', $('#pan_number').val());

    formData.append(
        'pan_front',
        $('#pan_front')[0].files[0]
    );

    formData.append(
        'pan_back',
        $('#pan_back')[0].files[0]
    );

    $.ajax({
        url: "{{ route('save.pan.kyc') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function(response) {

            completedSteps[3] = true;

            Swal.fire(
                'Success',
                response.message,
                'success'
            ).then(() => {

                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    location.reload();
                }

            });
        },

        error: function(xhr) {

            if (xhr.status === 422) {

                let errors = xhr.responseJSON.errors;
                let errorMsg = '';

                $.each(errors, function(key, value) {
                    errorMsg += value[0] + '<br>';
                });

                Swal.fire(
                    'Validation Error',
                    errorMsg,
                    'error'
                );

            } else {

                Swal.fire(
                    'Error',
                    'Something went wrong. Please try again.',
                    'error'
                );

            }
        }
    });
}
</script>

@endsection