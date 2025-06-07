<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>KhetiBook - Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

  <style>
    body {
      background: linear-gradient(to right, #a8edea, #fed6e3);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      height: 100%;
      max-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      box-sizing: border-box;
    }

    .register-wrapper {
      width: 75%;
      max-width: 900px;
      background: #ffffff;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      border-radius: 16px;
      padding: 40px;
      max-height: 100vh;
    }

    .brand {
      margin-top: -15px;
      font-size: 32px;
      font-weight: bold;
      color: #28a745;
      text-align: center;
      margin-bottom: 25px;
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
      font-size: 14px;
    }

    /* Smaller, neat inputs */
    input.form-control {
      font-size: 14px;
      padding: 6px 10px;
      height: 38px;        /* smaller height */
      max-width: 100%;     /* prevent overflow */
      white-space: nowrap; /* no wrapping inside input */
      overflow: hidden;    /* hide overflow */
      text-overflow: ellipsis; /* show ... if text too long */
      box-sizing: border-box;
      border-radius: 10px;
    }

    /* Make the readonly inputs look consistent */
    input[readonly] {
      background-color: #f8f9fa;
      cursor: not-allowed;
    }

    /* To avoid horizontal scroll on small screens */
    .register-wrapper form {
      overflow-x: hidden;
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

    .alert ul {
      margin-bottom: 0;
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

    #eye_icon {
      margin-top: 28px;
    }

    @media (max-width: 768px) {
      .register-wrapper {
        width: 95%;
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="register-wrapper">
    <div class="brand">KhetiBook</div>

    <div class="form-title">Register</div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
      @csrf

      <div class="row g-3">
        <div class="col-md-6">
          <label for="name">Name*</label>
          <input type="text" class="form-control" name="uname" id="name" required value="{{ old('uname') }}">
        </div>
        <div class="col-md-6">
          <label for="phone">Phone Number*</label>
          <input type="text" class="form-control" name="uphone" id="phone" required maxlength="10" value="{{ old('uphone') }}">
        </div>
        <div class="col-md-6">
          <label for="email">Email <span class="text-muted">(Optional)</span></label>
          <input type="email" class="form-control" name="uemail" id="email" value="{{ old('uemail') }}">
        </div>
        <div class="col-md-6 password-wrapper">
          <label for="password">Password*</label>
          <input type="password" class="form-control" name="upassword" id="password" required>
          <span class="password-toggle">
            <i class="fa fa-eye-slash toggle-password" id="eye_icon"></i> 
          </span>
        </div>
        <div class="col-md-6">
          <label for="cpassword">Confirm Password*</label>
          <input type="password" class="form-control" name="ucpassword" id="ucpassword" required>
        </div>

        <div class="col-md-6">
          <label for="autocomplete">Street Address*</label>
          <input type="text" class="form-control" id="autocomplete" placeholder="Start typing address..." required>
        </div>

        <div class="col-md-6">
          <label for="city">City</label>
          <input type="text" class="form-control" name="city" id="city">
        </div>

        <div class="col-md-6">
          <label for="district">District</label>
          <input type="text" class="form-control" name="district" id="district">
        </div>

        <div class="col-md-6">
          <label for="state">State</label>
          <input type="text" class="form-control" name="state" id="state">
        </div>

        <div class="col-md-6">
          <label for="pincode">Pincode</label>
          <input type="text" class="form-control" name="pincode" id="pincode">
        </div>

        <div class="col-md-6">
          <label for="country">Country</label>
          <input type="text" class="form-control" name="country" id="country">
        </div>
      </div>

      <!-- Hidden latitude and longitude inputs autofilled by browser geolocation -->
      <input type="hidden" name="latitude" id="latitude" />
      <input type="hidden" name="longitude" id="longitude" />


      <button type="submit" class="btn btn-success w-100 mt-4">Register</button>
    </form>

    <p class="mt-3 text-center">
      Already have an account? <a class="text-info" onclick="window.location.href='{{ route('login') }}'">Login</a>
    </p>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

  <!-- Password Show/Hide Script -->
  <script>
    $(document).ready(function() {
      $('#eye_icon').on('click', function() {
        const passwordInput = $('#password');
        const icon = $(this);
        if (passwordInput.attr('type') === 'password') {
          passwordInput.attr('type', 'text');
          icon.removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
          passwordInput.attr('type', 'password');
          icon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
      });
    });
  </script>

  <!-- Browser Geolocation API to autofill lat/lng on page load -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            // Only fill if hidden inputs are empty (do not overwrite place_changed lat/lng)
            if (!document.getElementById('latitude').value) {
              document.getElementById('latitude').value = position.coords.latitude;
            }
            if (!document.getElementById('longitude').value) {
              document.getElementById('longitude').value = position.coords.longitude;
            }
          },
          function (error) {
            console.warn('Geolocation error:', error);
          }
        );
      } else {
        console.warn('Geolocation is not supported by this browser.');
      }
    });
  </script>

  <script>
  let locationAllowed = false;

  function requestLocationPermission() {
    if (!navigator.geolocation) {
      alert("Geolocation is not supported by your browser.");
      return;
    }

    navigator.geolocation.getCurrentPosition(
      function (position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
        locationAllowed = true;
      },
      function (error) {
        alert("Please allow location access to continue with registration.");
        locationAllowed = false;
      }
    );
  }

  // Call once on page load
  document.addEventListener("DOMContentLoaded", function () {
    requestLocationPermission();
  });

  // Prevent form submission unless location is allowed
  document.querySelector('form').addEventListener('submit', function (e) {
    if (!locationAllowed || !document.getElementById('latitude').value || !document.getElementById('longitude').value) {
      e.preventDefault();
      alert("Location permission is required to register. Please allow it.");
      requestLocationPermission();
    }
  });
</script>

<script>
  let autocomplete;

  function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'),
      { types: ['geocode'], componentRestrictions: { country: 'in' } }
    );

    autocomplete.addListener('place_changed', fillInAddress);
  }

    function fillInAddress() {
      const place = autocomplete.getPlace();
      const addressComponents = place.address_components;

      let city = '', district = '', state = '', pincode = '', country = '';

      for (let i = 0; i < addressComponents.length; i++) {
        const types = addressComponents[i].types;

        if (types.includes("locality")) {
          city = addressComponents[i].long_name;
        }
        if (types.includes("administrative_area_level_2")) {
          district = addressComponents[i].long_name;
        }
        if (types.includes("administrative_area_level_1")) {
          state = addressComponents[i].long_name;
        }
        if (types.includes("postal_code")) {
          pincode = addressComponents[i].long_name;
        }
        if (types.includes("country")) {
          country = addressComponents[i].long_name;
        }
      }

      document.getElementById('city').value = city;
      document.getElementById('district').value = district;
      document.getElementById('state').value = state;
      document.getElementById('pincode').value = pincode;
      document.getElementById('country').value = country;

      // Latitude and Longitude
      // if (place.geometry) {
      //   document.getElementById('latitude').value = place.geometry.location.lat();
      //   document.getElementById('longitude').value = place.geometry.location.lng();
      // }
    }
  </script>

  <script>
  document.querySelector('form').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && e.target.nodeName === 'INPUT') {
      e.preventDefault();
      return false;
    }
  });
</script>

</body>
</html>
