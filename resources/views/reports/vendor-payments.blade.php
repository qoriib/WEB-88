<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran - {{ $store->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f5f5f5; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Pembayaran Pelanggan</h2>
    <p><strong>Toko:</strong> {{ $store->name }}</p>
    <p><strong>Tanggal:</strong> {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Pelanggan</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->order->order_number }}</td>
                    <td>{{ $payment->order->user->name }}</td>
                    <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
