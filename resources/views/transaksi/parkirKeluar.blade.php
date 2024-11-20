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
    <title>Keluar Parkir</title>
    <?php use Carbon\Carbon; ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Keluar Parkir</h1>
            </div>
        </div>
        <div class="col-md-6 offset-md-3 text-center">
            <p>_____________________________________________________________</p>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="POST" action="{{ route('prosesKeluarParkir') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nopol">Nomor Polisi</label>
                        <input type="text" class="form-control" id="nopol" name="nopol">
                        <input type="hidden" name="current_time" value="{{ Carbon::now() }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
