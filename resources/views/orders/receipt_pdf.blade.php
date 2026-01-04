<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ZENIRO STORE</h1>
        <p>Order Number: {{ $order->order_number }}</p>
    </div>
    <p>Nama: {{ $order->address->full_name }}</p>
    <p>Email: {{ $order->address->email }}</p>
    
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"><b>Total Harga:</b></td>
                <td><b>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
    <h5>Discount    : Rp {{ number_format($order->discount, 0, ',', '.') }}
    <h3>Total Bayar : Rp {{ number_format($order->total_price, 0, ',', '.') }}</h3>
</body>
</html>