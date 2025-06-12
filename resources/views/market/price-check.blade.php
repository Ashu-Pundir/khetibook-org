<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Khetibook - Check Crop Price</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />


  <style>
    :root {
      --bg-main: #f0f0e5;
      --table-header: #e6ebe9;
      --accent: #8FBC8F;
      --text: #36454F;
    }
    body {
      background-color: var(--bg-main);
      font-family: 'Segoe UI', sans-serif !important;
      margin: 0;
    }
    .navbar {
      background-color: #366d24;
    }
    .navbar-text {
      flex: 1;
      text-align: center;
      font-weight: 500;
      color: white;
    }
    .sidebar {
      background-color: #9cc98d;
      height: 92vh;
      padding-top: 2rem;
      transition: all 0.25s ease-out; 
    }
    .sidebar a {
      margin: 2px;
      color: aliceblue;
      padding: 12px 16px;
      display: block;
      text-decoration: none;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background-color: #e6f3e6;
      color: #2d7833;
      font-weight: 600;
      border-radius: 5px;
    }
    .table thead {
      background-color: var(--table-header);
    }
    .main-content {
      padding: 2rem;
    }
    .action-buttons .btn {
      padding: 0.3rem 0.6rem;
    }

    #myInput:focus {
        outline: none;
        box-shadow: none;
        border-color: #ced4da; /* Default Bootstrap border color */
    }

    .dataTables_filter {
      float: left; /* Move to left if desired */
      margin-bottom: 16px;
    }

    .dataTables_filter input {
      padding: 4px 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
      width: 200px;
      box-shadow: none; /* removes blue border on focus */
      outline: none;
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


    .dataTables_paginate {
        display: none !important;
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
      height: 92vh;
      padding-top: 2rem;
      width: 10vh;
      transition: all 0.25s ease-out;
    }
    
    .sidebar.hide a span{
      display: none;
    }
    
    .sidebar.hide h5{
      display: none;
      margin-bottom: 5px;`
    }
    
    .main-content-hide{
      width: 92%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      transition: all 0.25s ease-out; 
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
      margin-right: 10px;
    }
    
  </style>
</head>
<body>

 <!-- Navbar -->
  <nav class="navbar d-flex justify-content-between px-4 py-2 bg-success col-sm-12">
    <div class="fw-bold text-light">KhetiBook</div>
    <div class="navbar-text">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
    <a href="{{ route('verify.page') }}" class="verify-acc btn btn-outline-light lg-btn btn-sm">
    @if(Auth::check() && Auth::user()->user_verified)
      <i class="fa-solid fa-shield-check text-success"></i> Verified
    @else
      <i class="fa-solid fa-shield-check"></i> Verify Account
    @endif
    </a>
    <div><a href="{{ route('logout') }}" class="btn btn-outline-light lg-btn btn-sm">Logout</a></div>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <div class="col-md-2 sidebar pt-4">
      <div class="d-flex justify-content-between align-items-center px-3 mb-4">
        <h5 class="text-success mb-3 mx-auto" style="font-family: 'Segoe UI', sans-serif; font-weight: 600; letter-spacing: 1px;">Menu</h5>
        <div class="icon ms-auto" style="cursor: pointer;">
          <i class="fa-solid fa-bars text-dark" id="icon"></i>
        </div>
      </div>
      <a href="{{ route('crop.dashboard') }}" class="{{ request()->routeIs('crop.dashboard') ? 'active' : '' }}"><i class="fa-brands fa-dashcube"></i>  <span>Dashboard</span></a>
      <a href="{{ route('crop.addcrop') }}" class="{{ request()->routeIs('crop.addcrop') ? 'active' : '' }}"><i class="fa-solid fa-plus"></i>  <span>Add New Crop </span></a>
      <a href="{{ url('/check-price') }}" class="{{ request()->routeIs('check.price') ? 'active' : '' }}" ><i class="fa fa-inr" aria-hidden="true"></i>  <span>Market Price</span></a>
      <a href="{{ route('user.update') }}" class="{{ request()->routeIs('user.update') ? 'active' : '' }}" ><i class="fa-solid fa-gear"></i>  <span>Settings</span></a>
      </div>  

    <!-- Main Content -->
    <div class="col-md-10 col-sm-12 main-content">
      <nav class="navbar navbar-expand-lg navbar-custom mb-4 col-md-12">
        <div class="container-fluid">
          <a class="navbar-brand text-light" href="#">CROPS MARKET PRICE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </nav>

      <div class="card p-4 shadow rounded col-md-12">
        <h3 class="mb-4 text-muted text-center">Check Current Market Price</h3>

        <form method="POST" action="{{ route('submit.checkprice') }}" class="mb-4">
          @csrf
          <div class="row g-2 align-items-center justify-content-center">
            <div class="col-md-4">
              <select name="crop" id="crop" class="form-select" required>
                <option value="">Select Crop</option>
                @foreach($crops as $crop)
                  <option value="{{ $crop->crop_name }}">{{ ucfirst($crop->crop_name) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-success w-100">Check Price</button>
            </div>
          </div>
        </form>

        @if(session('price'))
          <div class="alert alert-info text-center">
            Estimated price of <strong>{{ session('crop') }}</strong>: ₹{{ session('price') }} per kg
          </div>
        @elseif(session('error'))
          <div class="alert alert-danger text-center">
            {{ session('error') }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/8df15f4693.js" crossorigin="anonymous"></script>

<script>
     $(document).ready(function () {
         $('#icon').on('click', function(){
            $('.sidebar').toggleClass('sidebar-hide');
            $('.sidebar').toggleClass('hide');
            $('.main-content').toggleClass('main-content-hide');
            $('.sidebar').addClass('.no-icon');
          });
      });
</script>
</body>
</html>
