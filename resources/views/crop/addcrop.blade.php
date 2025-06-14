<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Khetibuddy | Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body {
      background-color: #f0f0e5;
      margin: 0;
      padding: 0;
    }

    .navbar-custom {
      border-bottom: 1px solid #cce0cc;
      color: white;
    }

    .navbar-text-center {
      flex: 1;
      text-align: center;
      font-weight: 500;
      color: white;
    }

    .sidebar {
      background-color: #9cc98d;
      height: 93vh;
      padding-top: 2rem;
      border-right: 1px solid #dee2e6;
      transition: all 0.25s ease-out;
    }

    .sidebar a {
      margin: 2px;
      color: aliceblue;
      padding: 12px 16px;
      display: block;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #e6f3e6;
      color: #2d7833;
      font-weight: 600;
      border-radius: 5px;
    }

    .form-section {
      background-color: #9cc98d;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .sidebar a.disabled-link {
      pointer-events: none;
      color: gray !important;
      text-decoration: line-through !important;
      cursor: not-allowed;
      opacity: 0.6;
    }

    .sidebar a.disabled-link:hover {
      background-color: inherit !important;
      color: gray !important;
      font-weight: normal !important;
    }

    .back-btn:hover{
      background-color: #14A44D;
    }

    .lg-btn:hover{
        background-color: #137d3d;
        color: white;
    }

    .icon{
        display: flex;
        justify-content: right;
        font-size: x-large;
        color: #198754;
        padding-right: 14px;
        margin-bottom: 20px
    }

    .sidebar-hide{
      background-color: #9cc98d;
      height: 93vh;
      padding-top: 2rem;
      width: 10vh;
      transition: all 0.25s ease-out;
    }

    .sidebar.hide a span{
      display: none;
    }

    .sidebar.hide h5{
      display: none;
      margin-bottom: 5px;
    }
    
    .main-content-hide{
      width: 92%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }


    @media (max-width: 768px) {
      .sidebar {
        height: 50%;
        display: none;
      }
    }

    @media(min-width: 769px and max-width: 917px){
      .sidebar-hide{
        height: 100vh;
      }
    }

    @media(max-width:768px and min-width:593px){
      .sidebar-hide{
        height: 185vh;
      }
    }

    @media(max-width:592px){
      .no-icon{
        display: :none !important;
      }
    }

    .verify-acc{
      margin-right: 6px;
    }
    
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-custom d-flex justify-content-between align-items-center px-4 py-2 bg-success fw-bold">
    <a href="#" class="navbar-brand fw-bold text-light"><a href="{{ asset('logo.png') }}">
        <img src="{{ asset('logo.png') }}" alt="KhetiBook Logo" style="height:25px;vertical-align:middle; margin-bottom:2px;margin-right:5px; border-radius:8px;">
      </a>Khetibook</a>
    <div class="navbar-text-center">
      {{ Auth::check() ? Auth::user()->name : 'Guest' }}
    </div>
    <div>
    <a href="{{ route('verify.page') }}" class="verify-acc btn btn-outline-light lg-btn btn-sm">
     @if (Auth::check() && Auth::user()->user_verified)
                Verified <i class="fa-solid fa-file-circle-check"></i>
            @else
                <i class="fa-solid fa-shield-halved"></i> Verify Account
            @endif
    </a>
      <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm lg-btn"><i class="fas fa-sign-out"></i> Logout</a>
    </div>
  </nav>

  <!-- Main Layout -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 sidebar pt-4">
      <div class="d-flex justify-content-between align-items-center px-3 mb-4">
        <h5 class="text-success mb-3 mx-auto">Menu</h5>
        <div class="icon ms-auto" style="cursor: pointer;">
          <i class="fa-solid fa-bars text-dark" id="icon"></i>
        </div>
      </div>

        <a href="{{ route('crop.dashboard') }}" class="{{ request()->routeIs('crop.dashboard') ? 'active' : '' }}"><i class="fa-brands fa-dashcube"></i>  <span>Dashboard</span></a>
        <a href="{{ route('crop.addcrop') }}" class="{{ request()->routeIs('crop.addcrop') ? 'active' : '' }}"><i class="fa-solid fa-plus"></i>  <span>Add New Crop </span></a>
        <a href="{{ route('check.price') }}" class="{{ request()->is('my-crops') ? 'active' : '' }}" ><i class="fa fa-inr" aria-hidden="true"></i> <span>Market Price</span>
          <a href="{{ route('user.update') }}" class="{{ request()->is('user.update') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i>  <span>Settings</span></a>
          </a>
        
      </div>

      <!-- Content -->
      <div class="col-md-10 d-flex align-items-center justify-content-center py-5 form-fix" id="form-sec">
        <div class="form-section w-75">

          <div class="d-flex justify-content-between align-items-center mb-4">
              <div></div> <!-- Empty div to push center heading -->
              <h3 class="text-muted m-0 text-center flex-grow-1">Add Crop Details</h3>
              <a href="{{ route('crop.dashboard') }}" class="btn btn-success btn-outline-secondary back-btn text-light">← Back</a>
          </div>


          <form action="{{ route('crop.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="cropName" class="form-label">Crop Name</label>
              <input type="text" class="form-control" id="cropName" name="cropname" placeholder="Enter crop name">
            </div>
            <div class="mb-3">
              <label for="cropWeight" class="form-label">Crop Weight (kg)</label>
              <input type="number" class="form-control" id="cropWeight" name="cropweight" placeholder="Enter weight">
            </div>
            <div class="mb-3">
              <label for="cropPrice" class="form-label">Price (in ₹)</label>
              <input type="number" class="form-control" id="cropPrice" name="cropprice" placeholder="Enter price">
            </div>
            <div class="mb-3">
            <label for="cropCategory" class="form-label">Crop Category</label>
            <select class="form-select" id="cropCategory" name="cropcategory" required>
                <option value="">-- Select Crop Category --</option>
                @php
                    $categories = [
                          'Cereals (Atta)',
                          'Pulses (Daal)',
                          'Vegetables',
                          'Fruits',
                          'Spices',
                          'Cash/Commercial',
                          'Other'
                    ];
                @endphp

                @foreach ($categories as $category)
                    <option value="{{ $category }}"
                        {{ old('cropcategory', $crop->crop_category ?? '') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
</select>

            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success px-4">Save Crop</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
          // sidebar-toggle

          $(document).ready(function(){
            $('#icon').on('click', function(){
            $('.sidebar').toggleClass('sidebar-hide');
            $('.sidebar').toggleClass('hide');
            $('.main-content').toggleClass('main-content-hide');
            $('#form-sec').toggleClass('form-sec-hide');
            });
          });
  </script>
</body>
</html>
