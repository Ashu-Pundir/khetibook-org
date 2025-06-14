<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        <style>
    :root {
      --bg-main: #f0f0e5;
      --table-header: #e6ebe9;
      --accent: #8FBC8F;
      --text: #36454F;
    }
    body {
      background-color: var(--bg-main);
      font-family: 'Segoe UI', sans-serif;
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
      width: 5vw;
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

<body class="bg-light">

<!-- Navbar -->
  <nav class="navbar d-flex justify-content-between px-4 py-2 bg-success col-sm-12">
    <div class="fw-bold text-light"><a href="{{ asset('logo.png') }}">
        <img src="{{ asset('logo.png') }}" alt="KhetiBook Logo" style="height:25px;vertical-align:middle; margin-bottom:4px; border-radius:8px;">
      </a>KhetiBook</div>
    <div class="navbar-text">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
    <a href="{{ route('verify.page') }}" class="verify-acc btn btn-outline-light lg-btn btn-sm">
     @if (Auth::check() && Auth::user()->user_verified)
                Verified <i class="fa-solid fa-file-circle-check"></i>
            @else
                <i class="fa-solid fa-shield-halved"></i> Verify Account
            @endif
    </a>
    <div><a href="{{ route('logout') }}" class="btn btn-outline-light lg-btn btn-sm"><i class="fas fa-sign-out"></i> Logout</a></div>
  </nav>

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
        <a href="{{ route('check.price') }}" class="{{ request()->is('my-crops') ? 'active' : '' }}" ><i class="fa fa-inr" aria-hidden="true"></i> <span>Market Price</span></a>
        <a href="{{ route('user.update') }}" class="{{ request()->routeIs('user.update') ? 'active' : '' }}" ><i class="fa-solid fa-gear"></i>  <span>Settings</span></a>
      </div> 

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user-cog"></i> Edit User Profile</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('submituser.update', ['id' => auth()->user()->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}">
                            </div>
                            <div class="col-md-6">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', auth()->user()->city) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>District</label>
                                <input type="text" name="district" class="form-control" value="{{ old('district', auth()->user()->district) }}">
                            </div>
                            <div class="col-md-6">
                                <label>State</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', auth()->user()->state) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Pincode</label>
                                <input type="text" name="pincode" class="form-control" value="{{ old('pincode', auth()->user()->pincode) }}">
                            </div>
                            <div class="col-md-6">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', auth()->user()->country) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control" value="{{ old('latitude', auth()->user()->latitude) }}">
                            </div>
                            <div class="col-md-6">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control" value="{{ old('longitude', auth()->user()->longitude) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
                            </div>
                            <div class="col-md-6">
                                <label>Phone Number (Uneditable)</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->phone_number }}" disabled>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
