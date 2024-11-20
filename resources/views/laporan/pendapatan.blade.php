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

    <!-- Include the Bootstrap datetime picker JavaScript file -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
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
                <form method="POST" action="{{ route('resultPendapatan') }}">
                    @csrf
                    <div class="form-group">
                        <label for="datetimepicker">Datetime Start:</label>
                        <input type="text" class="form-control" id="datetimepicker" name="dateStart">
                    </div>
                    <div class="form-group">
                        <label for="datetimepicker">Datetime End:</label>
                        <input type="text" class="form-control" id="datetimepicker2" name="dateEnd">
                    </div>
                    <div class="form-group">
                        <label for="jenisKendaraan">Jenis Kendaraan</label>
                        <select class="form-control" name="jenisKendaraan">
                            <option value="*">All</option>
                            @foreach ($jenisKendaraan as $kendaraan)
                                <option value="{{ $kendaraan->jenisKendaraan }}">{{ $kendaraan->jenisKendaraan }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="current_time" value="{{ Carbon::now() }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <p>_____________________________________________________________</p>
                <a href="{{ route('menuLaporan') }}" class="btn btn-primary">
                    <h2 class="text-center"><i class="fa fa-arrow-left"></i><br>Kembali ke Menu Laporan</h2>
                </a>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    var dateNow = new Date().getDate();
    $(function() {
        $('#datetimepicker').datetimepicker({
            inline: true,
            sideBySide: true,
            defaultDate: moment().startOf('day').format("YYYY-MM-DD 00:00"),
            format: "YYYY-MM-DD HH:mm"
        });
    });
    $(function() {
        $('#datetimepicker2').datetimepicker({
            inline: true,
            sideBySide: true,
            format: "YYYY-MM-DD HH:mm"
        });
    });
</script>


</html>
