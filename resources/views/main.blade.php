<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <title>SECURE PARKING MENU</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">SECURE PARKING</h1>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <p>_____________________________________________________________</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <a href="{{ route('masukParkir') }}" class="btn btn-success btn-block">
                    <h2 class="text-center"><i class="fa fa-sign-in-alt"></i><br> Masuk Parkir</h2>
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <a href="{{ route('keluarParkir') }}" class="btn btn-danger btn-block">
                    <h2 class="text-center"><i class="fa fa-sign-out-alt"></i><br> Keluar Parkir</h2>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <p>_____________________________________________________________</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <a href="{{ route('menuPengaturan') }}" class="btn btn-primary btn-block">
                    <h2 class="text-center"><i class="fa fa-cog"></i><br> Pengaturan</h2>
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <a href="{{ route('menuLaporan') }}" class="btn btn-primary btn-block">
                    <h2 class="text-center"><i class="fa fa-book"></i><br> Laporan</h2>
                </a>
            </div>
        </div>


    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
