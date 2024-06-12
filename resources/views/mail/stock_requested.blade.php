<!DOCTYPE html>
<html>
<head>
    <title>Stock Requested</title>
</head>
<body>
   <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <h1>Stock Requested</h1>
    <table>
    <header>
        <th>Name</th>
        <th>Symbol</th>
        <th>Open</th>
        <th>High</th>
        <th>Low</th>
        <th>Close</th>
    </header>
    <tbody>
        <tr>
            <td>{{$name}}</td>
            <td>{{$symbol}}</td>
            <td>{{$open}}</td>
            <td>{{$high}}</td>
            <td>{{$low}}</td>
            <td>{{$close}}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
