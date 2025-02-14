<!DOCTYPE html>
<html>
<head>
    <title>Transaction Logs PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Transaction Logs</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Loggable Type</th>
                <th>User Role</th>
                <th>Quantity</th>
                <th>Request Type</th>
                <th>Request Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactionLogs as $key => $log)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ class_basename($log->loggable_type) }}</td>
                    <td>{{ $log->user->getRoleNames()->implode(', ') }}</td> <!-- Role of the user -->
                    <td>{{ $log->quantity }}</td>
                    <td>{{ ucfirst($log->request_type) }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->request_date)->format('d M Y H:i:s') }}</td>
                    <td>{{ $log->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
