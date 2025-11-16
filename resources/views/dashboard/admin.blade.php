@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-2">Dashboard Admin</h1>
                    <p class="text-muted mb-0">Ringkasan approval toko dan pesanan terbaru.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 mb-0">Pengajuan Toko Pending</h2>
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                    @if($pendingStores->isEmpty())
                        <p class="text-muted mb-0">Tidak ada pengajuan.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($pendingStores as $store)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-semibold">{{ $store->name }}</div>
                                        <small class="text-muted">Pemilik: {{ $store->owner->name }}</small>
                                    </div>
                                    <a href="{{ route('admin.stores.show', $store) }}" class="btn btn-sm btn-outline-primary">Review</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h6 mb-3">Pesanan Terbaru</h2>
                    @if($recentOrders->isEmpty())
                        <p class="text-muted mb-0">Belum ada pesanan</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($recentOrders as $order)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="fw-semibold">{{ $order->order_number }}</div>
                                            <small class="text-muted">Pelanggan: {{ $order->user->name }} | Toko: {{ $order->store->name ?? '-' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-semibold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                            <small class="badge text-bg-secondary">{{ ucfirst($order->status) }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
