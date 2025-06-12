<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>KhetiBook | Admin Dashboard</title>

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

    .action-icons i {
      cursor: pointer;
      margin: 0 5px;
      font-size: 1.2rem;
    }

    .action-icons i.view {
      color: #2f7c4a;
    }

    .action-icons i.delete {
      color: #dc3545;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
    margin-bottom: 1rem; /* or 16px, adjust as you want */
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
    margin-top: 1rem;
    margin-bottom: 1rem;
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

    .sidebar-hide{
      background-color: #9cc98d;
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

    .icon{
        display: flex;
        justify-content: right;
        font-size: x-large;
        color: #198754;
        padding-right: 14px;
        margin-bottom: 20px
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

        <a href="{{ route('admincheck.price') }}" class="{{ Route::is('admincheck.price') ? 'active' : '' }}" ><i class="fa fa-inr" aria-hidden="true"></i> <span>Market Price</span>
        </a>

        <a href="{{ route('admin.setting') }}" class="{{ Route::is('admin.setting') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i><span> Settings</span></a>
        
        </div>
<!-- Main Content -->
<!-- ... your existing HTML and styles ... -->

<div class="col-md-10 main-content">
  <h3 class="text-center text-muted mb-4">User Records</h3>

  <!-- Download PDF Button -->
  <div class="mb-3 text-end">
    
    <a href=" {{ route('admin.users.downloadPdf') }} " class="btn btn-success">
      <i class="fas fa-file-pdf"></i> Download PDF
    </a>
  </div>

  @if($users->count() > 0)
  <div class="table-responsive m-4">
    <table class="table table-bordered table-striped text-center" id="user-table">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>City</th>
          <th>District</th>
          <th>State</th>
          <th>Pincode</th>
          <th>Country</th>
          <th>User_Verified</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $index => $user)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->phone_number ?? 'N/A' }}</td>
          <td>{{ $user->email ?? 'N/A' }}</td>
          <td>{{ $user->city ?? 'N/A' }}</td>
          <td>{{ $user->district ?? 'N/A' }}</td>
          <td>{{ $user->state ?? 'N/A' }}</td>
          <td>{{ $user->pincode ?? 'N/A' }}</td>
          <td>{{ $user->country ?? 'N/A' }}</td>
          <td>{!! $user->user_verified ? '<i class="fa-solid fa-check" style="color: #00ffb3; font-size:22px; margin-top:12px;"></i>' : '<i class="fa-solid fa-xmark" style="color: #ff0000; font-size:22px; margin-top:12px;"></i>' !!}</td>

          <td class="action-icons">
            <a href="{{ route('admin.users.show', $user->id) }}"><i class="fas fa-eye view" title="View"></i></a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-link p-0 m-0"><i class="fas fa-trash delete" title="Delete"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <p class="text-center text-muted">No user records found.</p>
  @endif
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#user-table').DataTable({
        paging: true,
        searching: true,
        ordering: true
      });
    });
  </script>

  <script>
    $('#icon').on('click', function(){
      $('.sidebar').toggleClass('sidebar-hide');
      $('.sidebar').toggleClass('hide');
      $('.main-content').toggleClass('main-content-hide');
    })
  </script>
</body>
</html>
