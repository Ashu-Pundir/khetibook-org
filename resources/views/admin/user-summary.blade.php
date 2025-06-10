<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>KhetiBook | Users Crop Summary</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <style>
    body {
      background-color: #f4fdf7;
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar {
      background-color: #2f7c4a;
    }

    .navbar-text {
      flex: 1;
      text-align: center;
      font-weight: 500;
      color: white;
    }

    .sidebar {
      background-color: #9cc98d;
      height: 100vh;
      padding-top: 2rem;
    }

    .sidebar a {
      margin: 2px;
      color: white;
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

    .main-content {
      padding: 2rem;
    }

    table thead {
      background-color: #e6ebe9;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
      margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
      margin-top: 1rem;
      margin-bottom: 1rem;
    }

    .sidebar-hide{
      background-color: #9cc98d;
      padding-top: 2rem;
      width: 10vh;
      transition: all 0.25s ease-out;
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
      transition: all 0.25s ease-out; 
    }

    .icon{
      display: flex;
      justify-content: right;
      font-size: x-large;
      color: #198754;
      padding-right: 14px;
      margin-bottom: 20px;
      cursor: pointer;
    }

    /* Force vertical centering for all table cells */
    #user-table td, 
    #user-table th {
      vertical-align: middle !important;
    }

    @media(max-width:768px){
      .sidebar{
        height: 15%; 
      }
    }

  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar d-flex justify-content-between px-4 py-2">
    <div class="fw-bold text-light">KhetiBook</div>
    <div class="navbar-text">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
    <div><a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Logout</a></div>
  </nav>

  <div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar position-sticky sticky-top">
        <!-- Top section with KhetiBook centered and icon on right -->
        <div class="d-flex justify-content-between align-items-center px-3 mb-4">
            <h5 class="text-success mb-4 mx-auto">KHETIBOOK</h5>
            <div class="icon ms-auto" id="icon" style="cursor: pointer;">
            <i class="fa-solid fa-bars text-dark"></i>
            </div>
        </div>

        <!-- Sidebar links -->
        <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-users"></i><span> All Users</span>
        </a>

        <a href="{{ route('admin.userCropSummary') }}" class="{{ Route::is('admin.userCropSummary') ? 'active' : '' }}">
          <i class="fa-solid fa-wheat-awn"></i><span> Crop Summary</span>
        </a>
        <a href="{{ route('admincheck.price') }}" class="{{ request()->is('my-crops') ? 'active' : '' }}" ><i class="fa fa-inr" aria-hidden="true"></i> <span>Market Price</span></a>
        
        <a href="{{ route('admin.setting') }}" class="{{ Route::is('admin.setting') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i><span> Settings</span></a>
        
        </div>


      <!-- Main Content -->
      <div class="col-md-10 main-content">
        <h3 class="text-center text-muted mb-4">Users Crop Summary</h3>

        <!-- Download PDF Button -->
        <div class="mb-3 text-end">
          <a href="{{ route('admin.allUserSummaryPdf') }}" class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Download PDF
          </a>
        </div>

        @if($users->count() > 0)
        <div class="table-responsive m-4">
          <table class="table table-bordered table-striped text-center" id="summary-table">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>City</th>
                <th>State</th>
                <th>Crop Count</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $index => $user)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->phone_number ?? 'N/A' }}</td>
                  <td>{{ $user->city ?? 'N/A' }}</td>
                  <td>{{ $user->state ?? 'N/A' }}</td>
                  <td>{{ $user->crops_count ?? 0 }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
          <p class="text-center text-muted">No records found.</p>
        @endif
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#summary-table').DataTable({
        paging: true,
        searching: true,
        ordering: true
      });
    });

    $('#icon').on('click', function(){
      $('.sidebar').toggleClass('sidebar-hide');
      $('.sidebar').toggleClass('hide');
      $('.main-content').toggleClass('main-content-hide');
    });
  </script>
</body>
</html>
