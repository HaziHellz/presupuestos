<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cotización</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-8">
            <h1 class="display-1">Cotización en la categoría "{{$category->name}}".</h1>
            <p>Para el cliente: <strong>{{$quote->client->name . ' ' . $quote->client->last_name}}</strong></p>
        </div>
        <div class="col-4">
            <p class="display-6">
                Fecha de realización: {{$date}}
            </p>
        </div>
        <div class="col-12">
            <p>
                Esta es la lista de servicios que se tomaron en cuenta en la cotización.
            </p>
        </div>
    </div>
    <div class="row g-3">
        @if($details->isEmpty())
            <div class="col-12">
                <div class="alert">¡No se han cargado servicios!</div>
            </div>
        @else
            <table class="table table-striped mt-3">
                <thead>
                <tr>
                    <th width="50px">#</th>
                    <th width="300px">Servicio</th>
                    <th width="100px">Cantidad</th>
                    <th width="100px">Precio</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td width="50px">{{$detail['id']}}</td>
                        <td width="300px">{{$detail['concept']}}</td>
                        <td width="100px">{{$detail['quantity']}}</td>
                        <td width="100px">${{$detail['price']}} MXN</td>
                    </tr>
                @endforeach
                <tr>
                    <th width="50px">Total</th>
                    <th width="300px">&nbsp;</th>
                    <th width="100px">&nbsp;</th>
                    <th width="100px">${{$total}} MXN.</th>
                </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
</body>
</html>
