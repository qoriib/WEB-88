<p>Halo {{ $order->user->name }},</p>
<p>Terima kasih telah bertransaksi di {{ $order->store->name }}.</p>
<p>Berikut terlampir laporan order <strong>{{ $order->order_number }}</strong> dalam format PDF.</p>
<p>Ringkasan:</p>
<ul>
    <li>Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</li>
    <li>Status Order: {{ ucfirst($order->status) }}</li>
    <li>Status Pembayaran: {{ ucfirst($order->payment->status ?? 'pending') }}</li>
</ul>
<p>Terima kasih,</p>
<p>Tim OSS</p>
