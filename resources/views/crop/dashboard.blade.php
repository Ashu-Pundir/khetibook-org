<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>KhetiBook | My Crops</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


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
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar d-flex justify-content-between px-4 py-2 bg-success col-sm-12">
    <div class="fw-bold text-light">KhetiBook</div>
    <div class="navbar-text">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
    <div><a href="{{ route('logout') }}" class="btn btn-outline-light lg-btn btn-sm">Logout</a></div>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <div class="icon">
          <i class="fa-solid fa-bars " id="icon"></i>
        </div>
        <h5 class="text-center mb-4 text-success">Menu</h5>
        <a href="{{ route('crop.dashboard') }}" class="{{ request()->routeIs('crop.dashboard') ? 'active' : '' }}"><i class="fa-brands fa-dashcube"></i>  <span>Dashboard</span></a>
        <a href="{{ route('crop.addcrop') }}" class="{{ request()->routeIs('crop.addcrop') ? 'active' : '' }}"><i class="fa-solid fa-plus"></i>  <span>Add New Crop </span></a>
        {{-- <a href="{{ url('/my-crops') }}" class="{{ request()->is('my-crops') ? 'active' : '' }}" class="disabled-link" >My Crops</a>
        <a href="{{ url('/settings') }}" class="{{ request()->is('settings') ? 'active' : '' }}" class="disabled-link" >Settings</a> --}}
        <a href="#" class="disabled-link"><i class="fa-solid fa-wheat-awn"></i>  <span>My Crops</span></a>
        <a href="#" class="disabled-link"><i class="fa-solid fa-gear"></i>  <span>Settings</span></a>
      </div>  

      <!-- Main Content -->
      <div class="col-md-10 col-sm-12 main-content">
        <h3 class="mb-4 text-muted text-center">Your Crop Records</h3>

        @if($crops->count() > 0)
        <a href="{{ route('crops.pdf') }}" class="btn btn-success mb-3" target="_blank">📄 Download Crop Report (PDF)</a>
        @endif
        <a href="{{ route('crop.addcrop') }}" class="btn btn-success mb-3">Add new Crop</a>

        @if($crops->count() > 0)
        <div class="table-responsive">
          <div class="input-group mb-3 mt-2" style="max-width: 250px;">
        </div>

          <table class="table table-bordered table-striped bg-primary align-middle text-center rounded" id="crop-table">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Crop Name</th>
                <th>Crop Category</th>
                <th>Crop Weight (kg)</th>
                <th>Crop Price (₹)</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($crops as $crop)
              <tr>
                <td>{{ ($crops->currentPage() - 1)* $crops->perPage() + $loop->iteration}}</td>
                <td>{{ $crop->crop_name }}</td>
                <td>{{ $crop->crop_category }}</td>
                <td>{{ $crop->crop_weight }}</td>
                <td>{{ $crop->crop_price }}</td>
                <td class="action-buttons">
                  <button 
                    title="Edit"
                    data-bs-toggle="tooltip"
                    class="btn btn-primary text-bg-light edit-button"
                    data-id="{{ $crop->id }}"
                    data-name="{{ $crop->crop_name }}"
                    data-category="{{ $crop->crop_category }}"
                    data-weight="{{ $crop->crop_weight }}"
                    data-price="{{ $crop->crop_price }}"
                  >
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>

                  <form action="{{ route('crop.delete', [$crop->id]) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" title="Delete"
                    data-bs-toggle="tooltip" class="btn btn-danger m-1 delete-button">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div class="d-flex justify-content-center mt-3">
            {{ $crops->links() }}
          </div>
        </div>
        @else
        <p class="text-center text-muted">No crop records found.</p>
        @endif
      </div>
    </div>
  </div>
  
  <!-- Edit Modal -->
  <div class="modal fade" id="editCropModal" tabindex="-1" aria-labelledby="editCropModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="" id="editCropForm">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Crop</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="crop_id" name="id">
            
            <div class="mb-3">
              <label for="crop_name" class="form-label">Crop Name</label>
              <input type="text" class="form-control" id="crop_name" name="crop_name" required>
            </div>
            
            <div class="mb-3">
              <label for="crop_category" class="form-label">Crop Category</label>
              <input type="text" class="form-control" id="crop_category" name="crop_category" required>
            </div>
            
            <div class="mb-3">
              <label for="crop_weight" class="form-label">Weight (kg)</label>
              <input type="number" class="form-control" id="crop_weight" name="crop_weight" step="0.01" required>
            </div>
            
            <div class="mb-3">
              <label for="crop_price" class="form-label">Price (₹)</label>
              <input type="number" class="form-control" id="crop_price" name="crop_price" step="0.01" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script>
    // Delete confirmation
    document.querySelectorAll('.delete-button').forEach(button => {
      button.addEventListener('click', function () {
        const form = this.closest('form');
        Swal.fire({
          title: 'Are you sure?',
          text: "This crop will be permanently deleted.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

    // Edit modal setup
    document.querySelectorAll('.edit-button').forEach(button => {
      button.addEventListener('click', function () {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const category = this.dataset.category;
        const weight = this.dataset.weight;
        const price = this.dataset.price;

        document.getElementById('editCropForm').action = `/crop/update/${id}`;
        document.getElementById('crop_name').value = name;
        document.getElementById('crop_category').value = category;
        document.getElementById('crop_weight').value = weight;
        document.getElementById('crop_price').value = price;

        const modal = new bootstrap.Modal(document.getElementById('editCropModal'));
        modal.show();
      });
    });

    // Show update success alert (if available)
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
      });
    @endif


    // Enable Bootstrap tooltips
      document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });
      });

      $(document).ready(function () {
          let table = new DataTable('#crop-table',{
            paging: false,

          });

          $('#searchBtn').on('click', function () {
              let query = $('#myInput').val();
              table.search(query).draw();
          });

          // Optional: trigger search when pressing Enter
          $('#myInput').on('keypress', function (e) {
              if (e.which == 13) {
                  $('#searchBtn').click();
              }
          });

          // sidebar-toggle
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
