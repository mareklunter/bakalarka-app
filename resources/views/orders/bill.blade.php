<ul class="text-left my-3">
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
                <td>{{ $order->products()->withTrashed()->find($product_id)->price * $amount }}€</td>
            </tr>
        @endforeach
        <tr>
            <th></td>
            <th></td>
            <th>{{ $order->price }}€</td>
        </tr>
    </tbody>
</table>

<div class="btn-group mt-3">
    <a href="#" class="btn btn-dark">Export PDF</a>

    @if ($order->paid)
        <a href="{{ route('orders.pay', $order) }}" class="btn btn-primary">Zrušiť zaplatenie</a>
    @else
        <a href="{{ route('orders.pay', $order) }}" class="btn btn-primary">Zaplatiť</a>
    @endif
</div>
