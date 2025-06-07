<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>KhetiBook - Login</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      background: linear-gradient(to right, #a8edea, #fed6e3);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-wrapper {
      width: 75%;
      max-width: 900px;
      background: #ffffff;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      border-radius: 16px;
      padding: 40px;
    }

    .brand {
      font-size: 32px;
      font-weight: bold;
      color: #28a745;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-title {
      font-size: 22px;
      font-weight: 600;
      color: #444;
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      font-weight: 500;
      color: #333;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 15px;
    }

    .btn-success {
      border-radius: 10px;
      padding: 10px;
      font-size: 16px;
    }

    .text-info {
      color: #28a745 !important;
      cursor: pointer;
    }

    .text-info:hover {
      text-decoration: underline;
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper .form-control {
      padding-right: 40px; /* space for the eye icon */
    }

    .password-toggle {
      position: absolute;
      top: 50%;
      right: 14px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
      font-size: 18px;
    }

    #eye_icon{
      margin-top: 28px;
    }

    .admin-logo{

      

    }


    @media (max-width: 768px) {
      .login-wrapper {
        width: 95%;
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

<div class="login-wrapper">
  <div class="brand">KhetiBook</div>
  <div class="position-relative mb-3">
  <div class="text-center">
    <div class="form-title">Admin Login</div>
  </div>
  <div class="position-absolute top-0 end-0">
    <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Back</a>
  </div>
</div>


  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('admin-login.submit') }}">
    @csrf
    <div class="mb-3">
      <label for="phone">Phone Number</label>
      <input type="text" class="form-control" name="uphone" id="phone" maxlength="10" value="{{ old('uphone') }}" required>
    </div>

    <div class="mb-4 password-wrapper">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="upassword" id="password" required>
      <span class="password-toggle">
        <i class="fa fa-eye-slash toggle-password" id="eye_icon"></i> 
      </span>
    </div>

    <button type="submit" class="btn btn-success w-100">Admin Login</button>
  </form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Password Show/Hide Script -->
<script>
    $(document).ready(function()
        {
            $('#eye_icon').on('click', function()
            {
                const passwordInput = $('#password');
                const icon = $(this);
                if (passwordInput.attr('type') === 'password')
                {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
                else
                {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
