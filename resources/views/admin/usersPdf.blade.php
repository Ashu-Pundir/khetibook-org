<!DOCTYPE html>
<html>
<head>
    <title>Crop Report</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; 
        font-size: 16px;
        margin: 0px;
        padding: 0px;
    }
    
    h1 { text-align: center; color: #4CAF50; }
    table {
            font-size: 12px;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            font-size: 12px;
            padding: 6px;
            border: 1px solid #999;
            text-align: left;
        }
        h2{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>KhetiBook All Users</h1>
    @if($users->count() > 0)
  <div class="table-responsive m-3">
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
        </tr>
      </thead>
      <tbody>
        @foreach($users as $index => $user)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $user->name ?? 'N/A' }}</td>
          <td>{{ $user->phone_number ?? 'N/A' }}</td>
          <td>{{ $user->email ?? 'N/A' }}</td>
          <td>{{ $user->city ?? 'N/A' }}</td>
          <td>{{ $user->district ?? 'N/A' }}</td>
          <td>{{ $user->state ?? 'N/A' }}</td>
          <td>{{ $user->pincode ?? 'N/A' }}</td>
          <td>{{ $user->country ?? 'N/A' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <p class="text-center text-muted">No user records found.</p>
  @endif
</div>