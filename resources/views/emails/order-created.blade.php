<p>Halo {{ $order->user->name }},</p>
<p>Terima kasih telah membuat pesanan di {{ $order->store->name }}.</p>
<p>Detail order:</p>
<ul>
    <li>Nomor: {{ $order->order_number }}</li>
    <li>Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</li>
    <li>Metode: {{ strtoupper($order->payment_method) }}</li>
    <li>Status: {{ ucfirst($order->status) }}</li>
</ul>
<p>Silakan lanjutkan pembayaran sesuai instruksi di aplikasi, atau jika COD, siapkan pembayaran saat kurir tiba.</p>
<p>Terima kasih,</p>
<p>Tim OSS</p>
