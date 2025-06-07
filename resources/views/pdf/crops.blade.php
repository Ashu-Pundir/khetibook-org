<!DOCTYPE html>
<html>
<head>
    <title>Crop Report</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; }
        h1 { text-align: center; color: #4CAF50; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
        }
        h2{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>KhetiBook Crop Report</h1>
    <h2>{{ $user->name }}</h2>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Crop Name</th>
                <th>Crop Category</th>
                <th>Crop Weight (kg)</th>
                <th>Crop Price (₹)</th>
                <th>Sold on</th>
            </tr>
        </thead>
        <tbody>
            @foreach($crops as $index => $crop)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $crop->crop_name }}</td>
                    <td>{{ $crop->crop_category }}</td>
                    <td>{{ $crop->crop_weight }}</td>
                    <td>₹{{ number_format($crop->crop_price, 2) }}</td>
                    <td>{{ $crop->created_at->format('d M Y')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
