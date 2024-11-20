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
    <title>Tiket Parkir</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <div id="strukParkir">
                    {!! $tiket !!}
                </div>
                <br>
                @if ($jenisTiket != 'ERROR')
                    <a href="#" class="btn btn-primary" onclick="printDiv()" class="btn btn-success">
                        <i class="fa fa-print"></i> Cetak Struk
                    </a>
                @endif
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
<script>
    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(value);
    }

    const element = document.getElementById("currency");
    const value = parseFloat(element.innerHTML);
    element.innerHTML = formatCurrency(value);

    function printDiv() {
        var divContents = document.getElementById("strukParkir").innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write(divContents);
        a.document.close();
        a.print();
    }
</script>
