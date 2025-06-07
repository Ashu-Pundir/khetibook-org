<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Crop Summary PDF</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      color: #333;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #555;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #d4e4d4;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <h2>User Crop Summary</h2>
  <table>
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
</body>
</html>
