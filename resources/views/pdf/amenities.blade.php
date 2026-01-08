<!DOCTYPE html>
<html>

<head>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}

    <meta charset="utf-8">
    <title>Amenities PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Amenities List</h2>

    <table>
        <thead>
            <tr>
                <th>Sl NO</th>
                <th>Amenity Name</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($amenties as $key => $amentie)
                <td>{{ $key + 1 }}</td>
                <td>{{ $amentie->amenities_name }}</td>
            @endforeach
        </tbody>
    </table>

</body>

</html>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
