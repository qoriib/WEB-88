<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Order {{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1, h2, h3, h4 { margin: 0 0 8px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f5f5f5; text-align: left; }
    </style>
</head>
<body>
    <h2>OSS - Laporan Order</h2>
    <p><strong>Nomor Order:</strong> {{ $order->order_number }}</p>
    <p><strong>Tanggal:</strong> {{ $order->placed_at?->format('d M Y H:i') }}</p>

    <h3>Pelanggan</h3>
    <p>
        {{ $order->user->name }}<br>
        {{ $order->user->email }}<br>
        {{ $order->shipping_address }} ({{ $order->city }})
    </p>

    <h3>Toko</h3>
    <p>
        {{ $order->store->name }}<br>
        {{ $order->store->address }} ({{ $order->store->city }})<br>
        Rekening: {{ $order->store->bank_name ?? '-' }} a.n {{ $order->store->bank_account_name ?? '-' }} ({{ $order->store->bank_account_number ?? '-' }})
    </p>

    <h3>Detail Item</h3>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Ringkasan</h3>
    <p>
        Subtotal: Rp{{ number_format($order->subtotal, 0, ',', '.') }}<br>
        Ongkir: Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}<br>
        Total: <strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong><br>
        Status Order: {{ ucfirst($order->status) }}<br>
        Status Bayar: {{ ucfirst($order->payment->status ?? 'pending') }}
    </p>
</body>
</html>
