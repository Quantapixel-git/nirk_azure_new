@extends('frontend.layouts.app')

@section('content')
<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container text-center" style="margin-top:150px;">
    <h3>Your KYC is Pending</h3>
    <p>Please complete your KYC to proceed further.</p>

    <button id="completeKycBtn" class="btn btn-primary my-5" style="padding:12px 30px;">
        Complete KYC
    </button>
</div>

<script>
    document.getElementById('completeKycBtn').addEventListener('click', function() {
        // Show SweetAlert success message
        Swal.fire({
            icon: 'success',
            title: 'Redirecting...',
            text: 'You will be redirected to complete your KYC.',
            showConfirmButton: false,
            timer: 2000,
            didClose: () => {
                // Navigate to KYC page after alert closes
                window.location.href = "{{ route('user.kyc', ['step' => 1]) }}";
            }
        });
    });
</script>
@endsection


