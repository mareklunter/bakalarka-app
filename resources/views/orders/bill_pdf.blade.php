<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill Pdf</title>
</head>

<style>
    body {
        font-family: DejaVu Sans;
        text-align: center;
    }

    ul {
        list-style: none;
    }

    table {
        color: #212529;
        border-collapse: collapse;
        margin: 30px auto 0;
    }

    table,
    td,
    th {
        border: 1px solid black;
        text-align: center;
    }

    td,
    th {
        padding: 4px 6px
    }

    .company-name {
        font-weight: bolder
    }

    .border-bottom {
        border-bottom: 1px solid rgba(0, 0, 0, 0.452);
    }

    .order-info{
        width: 50%;
        margin: 50px auto 0;
        text-align: left;
    }

    thead {
        background-color: #003049;
        color: whitesmoke
    }
</style>

<body>

    <div class="border-bottom">
        <h2>Zaplatenie objednávky</h2>
    </div>

    <div>
        <ul class="order-info">
            <li><strong>ID objednávky: </strong>{{ $order->id }}</li>
            <li><strong>Stôl: </strong>
                @if ($order->table)
                    {{ $order->table->tag }}
                @else
                    <p>Žiaden stôl</p>
                @endif
            </li>
            <li><strong>Vytvorená: </strong> {{ $order->created_at }}</li>
        </ul>
        <table class="table table-sm my-3">
            <thead>
                <tr>
                    <th scope="col">Názov</th>
                    <th scope="col">Počet</th>
                    <th scope="col">Cena spolu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_items as $product_id => $amount)
                    <tr>
                        <th>{{ $order->products()->withTrashed()->find($product_id)->name }}</th>
                        <td>{{ $amount }}</td>
                        <td>{{ $order->products()->withTrashed()->find($product_id)->price * $amount }}&#8364;</td>
                    </tr>
                @endforeach
                <tr>
                    <th>
                        </td>
                    <th>
                        </td>
                    <th>{{ $order->price }}&#8364;</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p>Ďakujeme za Vašu návštevu</p>
    <span class="company-name">{{ $order->user->name }}</span>
</body>

</html>
