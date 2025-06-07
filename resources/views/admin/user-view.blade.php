<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .map-div {
            padding: 60px 10px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit User Details</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>

    <!-- Form Starts -->
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- User Info -->
            <div class="col-md-8">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ $user->phone_number }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control" value="{{ $user->district }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ $user->city }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="{{ $user->pincode }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ $user->state }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ $user->country }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" class="form-control" value="{{ $user->latitude }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" class="form-control" value="{{ $user->longitude }}">
                    </div>
                </div>
            </div>

            <!-- Small Map -->
            <div class="col-md-4 map-div">
                <div class="row mb-2">
                    <div class="col-6 text-center offset-3">
                        <label class="form-label fw-bold">Location on Map</label>
                    </div>
                </div>
                <div class="card">
                    <div style="height: 250px;">
                        <iframe
                            width="100%"
                            height="100%"
                            frameborder="0"
                            style="border:0"
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q={{ $user->latitude }},{{ $user->longitude }}&hl=es;z=14&output=embed"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-success px-4">Update User</button>
        </div>
    </form>

    <!-- Add Crop Button -->
<div class="mb-3 text-end">
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCropModal">
        ➕ Add Crop
    </button>
</div>

<!-- Add Crop Modal -->
<div class="modal fade" id="addCropModal" tabindex="-1" aria-labelledby="addCropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.crop.store') }}" method="POST">
                @csrf

                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="modal-header">
                    <h5 class="modal-title">Add Crop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Crop Name</label>
                        <input type="text" name="crop_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Crop Category</label>
                        <input type="text" name="crop_category" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Crop Quantity</label>
                        <input type="text" name="crop_weight" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Crop Price</label>
                        <input type="text" name="crop_price" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Crop</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


   <!-- Crop Details -->
<div class="mt-5">
    <h4>Crop Details</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>S No.</th>
                    <th>Crop Name</th>
                    <th>Crop Category</th>
                    <th>Crop Quantity</th>
                    <th>Crop Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($crop as $item)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $item->crop_name }}</td>
                        <td>{{ $item->crop_category }}</td>
                        <td>{{ $item->crop_weight }}</td>
                        <td>{{ $item->crop_price }}</td>
                        <td>
                            <!-- Edit Icon -->
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCropModal{{ $item->id }}">
                                ✏️
                            </button>

                            <!-- Delete Icon -->
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCropModal{{ $item->id }}">
                                🗑️
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editCropModal{{ $item->id }}" tabindex="-1" aria-labelledby="editCropLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.crop.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Crop</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Crop Name</label>
                                            <input type="text" name="crop_name" class="form-control" value="{{ $item->crop_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Crop Category</label>
                                            <input type="text" name="crop_category" class="form-control" value="{{ $item->crop_category }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Crop Quantity</label>
                                            <input type="text" name="crop_weight" class="form-control" value="{{ $item->crop_weight }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Crop Price</label>
                                            <input type="text" name="crop_price" class="form-control" value="{{ $item->crop_price }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteCropModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteCropLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('admin.crop.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Crop</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the crop <strong>{{ $item->crop_name }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="6" class="text-center">No crops available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
