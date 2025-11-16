@extends('layouts.app')

@section('title', 'Dashboard Vendor')

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-2">Dashboard Vendor</h1>
                    <p class="text-muted mb-0">Kelola toko, produk, dan pembayaran pelanggan.</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <p class="text-muted small mb-1">Status Toko</p>
                            <span class="badge text-bg-{{ $summary['storeStatus'] === 'approved' ? 'success' : ($summary['storeStatus'] === 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($summary['storeStatus']) }}
                            </span>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <p class="text-muted small mb-1">Produk</p>
                            <h5 class="mb-0">{{ $summary['products'] }}</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted small mb-1">Pembayaran Pending</p>
                            <h5 class="mb-0">{{ $summary['pendingPayments'] }}</h5>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2 flex-wrap">
                        <a href="{{ route('seller.store.index') }}" class="btn btn-outline-primary btn-sm">Profil Toko</a>
                        <a href="{{ route('seller.products.index') }}" class="btn btn-outline-primary btn-sm">Kelola Produk</a>
                        <a href="{{ route('seller.payments.index') }}" class="btn btn-outline-primary btn-sm">Verifikasi Pembayaran</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">Pembayaran Terbaru</h2>
                    @if($recentPayments->isEmpty())
                        <p class="text-muted mb-0">Belum ada pembayaran.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order</th>
                                        <th>Pelanggan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->order->order_number }}</td>
                                            <td>{{ $payment->order->user->name }}</td>
                                            <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge text-bg-{{ $payment->status === 'confirmed' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('seller.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
