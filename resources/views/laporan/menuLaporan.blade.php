<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Menu Laporan</title>
    <?php use Carbon\Carbon; ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Laporan</h1>
            </div>
        </div>
        <div class="col-md-6 offset-md-3 text-center">
            <p>_____________________________________________________________</p>
        </div>
        <div class="row">
            <div class="col-lg-4 text-center">
                <a href="{{ route('pendapatan') }}" class="btn btn-primary h-100 btn-block">
                    <h2 class="text-center"><i class="fa fa-money-bill"></i><br> Pendapatan</h2>
                </a>
            </div>
            <div class="col-lg-4 text-center">
                <a href="{{ route('kendaraanDiLokasi') }}" class="btn btn-primary h-100 btn-block">
                    <h2 class="text-center"><i class="fa fa-clipboard-list"></i><br> Kendaraan di Lokasi</h2>
                </a>
            </div>
            <div class="col-lg-4 text-center">
                <a href="{{ route('kendaraanMasukKeluar') }}" class="btn btn-primary h-100 btn-block">
                    <h2 class="text-center"><i class="fa fa-desktop"></i><br> Kendaraan Masuk dan Keluar</h2>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <p>_____________________________________________________________</p>
                <a href="{{ route('main') }}" class="btn btn-primary">
                    <h2 class="text-center"><i class="fa fa-arrow-left"></i><br>Kembali ke Menu</h2>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
