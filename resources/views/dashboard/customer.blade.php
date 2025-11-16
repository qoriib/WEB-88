@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-2">Dashboard Customer</h1>
                    <p class="text-muted mb-0">Pantau semua transaksi dan status pembayaran.</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h6 mb-1">Transaksi Saya</h2>
                            <p class="text-muted small mb-0">Pesanan terbaru Anda.</p>
                        </div>
                    </div>
                    @if($orders->isEmpty())
                        <p class="text-muted mb-0">Belum ada transaksi. Mulai belanja di katalog produk.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order</th>
                                        <th>Toko</th>
                                        <th>Total</th>
                                        <th>Status Order</th>
                                        <th>Status Bayar</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->store->name ?? '-' }}</td>
                                            <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td><span class="badge text-bg-secondary">{{ ucfirst($order->status) }}</span></td>
                                            <td>
                                                @php $payStatus = $order->payment->status ?? 'pending'; @endphp
                                                <span class="badge text-bg-{{ $payStatus === 'confirmed' ? 'success' : ($payStatus === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($payStatus) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                @if(($order->payment->status ?? 'pending') !== 'confirmed')
                                                    <a href="{{ route('orders.payment.create', $order) }}" class="btn btn-sm btn-outline-primary">Upload Bukti</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
