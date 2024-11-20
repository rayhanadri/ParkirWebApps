<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include the Bootstrap datetime picker CSS file -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>


    <!-- Include the Bootstrap datetime picker JavaScript file -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <style>
        table.dataTable td {
            border: 1px solid black;
        }

        table.dataTable th {
            border: 1px solid black;
        }

        #myTable2 td {
            border: 1px solid black;
        }

        #myTable2 th {
            border: 1px solid black;
        }
    </style>
    <title>Laporan Pendapatan</title>
    <?php use Carbon\Carbon; ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Laporan Pendapatan</h1>
            </div>
        </div>
        <div class="col-md-6 offset-md-3 text-center">
            <p>_____________________________________________________________</p>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3 class="text-center">Detail Pendapatan</h3>
                <table id="myTable">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Polisi</th>
                            <th>Jenis Kendaraan</th>
                            <th>Total Jam Parkir</th>
                            <th>Biaya Parkir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masukKeluarKendaraan as $masukKeluar)
                            <tr>
                                <td>{{ $masukKeluar->tanggal }}</td>
                                <td>{{ $masukKeluar->nomorPolisi }}</td>
                                <td>{{ $masukKeluar->jenisKendaraan }}</td>
                                <td>{{ $masukKeluar->time_difference }}</td>
                                <td>{{ $masukKeluar->totalBiaya }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3 class="text-center">Summary Kendaraan di Lokasi</h3>
                <table id="myTable2" class="table">
                    <thead>
                        <tr>
                            <th>Jenis Kendaraan</th>
                            <th>Subtotal</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($summaryKendaraan as $summKendaraan)
                            <tr>
                                <td>{{ $summKendaraan->jenisKendaraan }}</td>
                                <td>{{ $summKendaraan->subtotal }}</td>
                                <td>{{ $summKendaraan->sumTotalBiaya }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <p>_____________________________________________________________</p>
                <a href="{{ route('pendapatan') }}" class="btn btn-primary">
                    <h2 class="text-center"><i class="fa fa-arrow-left"></i><br>Kembali Pilih Laporan Kendaraan Masuk Keluar</h2>
                </a>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>


</html>
