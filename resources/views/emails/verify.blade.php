<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Your Email & Number</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #a8edea, #fed6e3);
            font-family: 'Segoe UI', sans-serif;
        }

        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .card-header {
            font-weight: 600;
            font-size: 18px;
        }

        .card-body label {
            font-weight: 500;
        }
    </style>
</head>

<body class="bg-light">

    @auth
        <a href="{{ route('crop.dashboard') }}" class="btn btn-outline-secondary top-right">← Back</a>
    @endauth

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row g-4">
                    {{-- Email Verification --}}
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-success text-white">Verify Email</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Email:</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::check() ? Auth::user()->email : 'Guest' }}" readonly>
                                </div>

                                @auth
                                    <form method="POST" action="{{ route('send.email.otp') }}">
                                        @csrf
                                        <button class="btn btn-success w-100" type="submit"
                                          @if(Auth::user()->email_verified) disabled @endif>
                                          {{ Auth::user()->email_verified ? '✅ Email Verified' : 'Send Email OTP' }}
                                          </button>
                                    </form>

                                    <form method="POST" action="{{ route('verify.email.otp') }}">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="text" name="otp" class="form-control"
                                                placeholder="Enter Email OTP"
                                                {{ Auth::user()->email_verified ? 'readonly' : '' }}>
                                              </div>
                                          <button class="btn btn-success w-100" type="submit"
                                          @if(Auth::user()->email_verified) disabled @endif>
                                          {{ Auth::user()->email_verified ? '✅ Email Verified' : 'Enter Email OTP' }}
                                          </button>
                                    </form>

                                    @if (Auth::user()->email_verified)
                                        <div class="text-success mt-2">✅ Email Verified</div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>

                    {{-- Phone Verification --}}
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-warning text-dark">Verify Phone Number</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Phone Number:</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ Auth::check() ? Auth::user()->phone_number : 'No Phone Number' }}"
                                        readonly>
                                </div>

                                @auth
                                    <form method="POST" action="{{ route('send.number.otp') }}">
                                        @csrf
                                        @if (session('otp_success'))
                                            <div class="alert alert-success">{{ session('otp_success') }}</div>
                                        @endif

                                        @if (session('otp_error'))
                                            <div class="alert alert-danger">{{ session('otp_error') }}</div>
                                        @endif

                                        <input type="hidden" name="phone_number" value="{{ Auth::user()->phone_number }}">
                                        <button class="btn btn-primary w-100 mb-2" id="phone-otp" type="submit"
                                        @if(Auth::user()->number_verified) disabled @endif>
                                        {{ Auth::user()->number_verified ? '✅ Phone Verified' : 'Send Phone OTP' }}
                                      </button>

                                    </form>



                                    <form method="POST" action="{{ route('verify.number.otp') }}">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="text" name="otp" class="form-control"
                                                placeholder="Enter Phone OTP"
                                                {{ Auth::user()->number_verified ? 'readonly' : '' }}>
                                        </div>
                                        <button class="btn btn-primary w-100 mb-2" id="phone-otp" type="submit"
                                        @if(Auth::user()->number_verified) disabled @endif>
                                        {{ Auth::user()->number_verified ? '✅ Phone Verified' : 'Enter Phone OTP' }}
                                      </button>
                                    </form>

                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif

                                    <div id="otp-timer" class="text-muted text-center mt-2"></div>


                                    @if (Auth::user()->number_verified)
                                        <div class="text-success mt-2">✅ Phone Verified</div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Final Status --}}
                <div class="mt-4">

                    @auth
                        @php
                            $user = Auth::user();
                            $user_verified = $user->email_verified && $user->number_verified;
                        @endphp

                        @if ($user_verified)
                            <div class="alert alert-success text-center">
                                ✅ Your account is fully verified!
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                ⚠️ Your account is not fully verified yet.
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

 <script>
  document.addEventListener('DOMContentLoaded', function () {
    const timerDiv = document.getElementById('otp-timer');
    const sendPhoneBtn = document.getElementById('phone-otp');
    const userId = "{{ Auth::id() }}";
    const isVerified = "{{ Auth::user()->number_verified }}";

    if (isVerified === "1") {
        sendPhoneBtn.disabled = true;
        sendPhoneBtn.innerText = "✅ Phone Verified";
        timerDiv.innerText = "";
        return; // Skip timer logic entirely
    }

    const key = `otpCooldown_user_${userId}`;
    let timer = localStorage.getItem(key) ? parseInt(localStorage.getItem(key)) : 0;

    @if(session('otp_timer_start'))
        timer = 60;
        localStorage.setItem(key, timer);
    @endif

    function updateTimer() {
        if (timer > 0) {
            sendPhoneBtn.disabled = true;
            sendPhoneBtn.innerText = `Wait ${timer}s...`;
            timerDiv.innerText = `Please wait ${timer} seconds before requesting a new OTP.`;
            timer--;
            localStorage.setItem(key, timer);
        } else {
            sendPhoneBtn.disabled = false;
            sendPhoneBtn.innerText = "Send Phone OTP Again";
            timerDiv.innerText = "";
            localStorage.removeItem(key);
            clearInterval(window.otpInterval);
        }
    }

    if (timer > 0) {
        sendPhoneBtn.disabled = true;
        updateTimer();
        window.otpInterval = setInterval(updateTimer, 1000);
    } else {
        sendPhoneBtn.disabled = false;
        sendPhoneBtn.innerText = "Send Phone OTP";
    }
});

 </script>





</body>

</html>
