@extends('layouts.app')

@section('title', 'Detail Toko - ' . $store->name)

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <p class="text-uppercase text-primary small mb-1">Admin Panel</p>
                <h1 class="h4 mb-0">Detail Toko: {{ $store->name }}</h1>
            </div>
            <a href="{{ route('admin.stores.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge text-bg-{{ $store->status === 'approved' ? 'success' : ($store->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($store->status) }}
                            </span>
                            <h2 class="h4 mt-2 mb-1">{{ $store->name }}</h2>
                            <p class="text-muted mb-2">{{ $store->category->name ?? 'Tanpa kategori' }}</p>
                            <p class="text-muted mb-2">{{ $store->city }} &mdash; {{ $store->address }}</p>
                            <p class="mb-0">{{ $store->description }}</p>
                            <div class="mt-3 p-2 bg-light rounded">
                                <p class="fw-semibold mb-1">Rekening Pembayaran</p>
                                <p class="text-muted small mb-0">
                                    {{ $store->bank_name ?? '-' }}<br>
                                    a.n {{ $store->bank_account_name ?? '-' }}<br>
                                    {{ $store->bank_account_number ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="text-muted small mb-1">Diajukan: {{ $store->created_at->format('d M Y H:i') }}</p>
                            @if($store->approved_at)
                                <p class="text-muted small mb-0">Disetujui: {{ $store->approved_at->format('d M Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">Produk Terbaru ({{ $store->products_count }})</h2>
                    @if($store->products->isEmpty())
                        <p class="text-muted mb-0">Belum ada produk yang terdaftar di toko ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($store->products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                <span class="badge text-bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
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
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Informasi Pemilik</h2>
                    <p class="mb-1 fw-semibold">{{ $store->owner->name }}</p>
                    <p class="text-muted small mb-2">{{ $store->owner->email }}</p>
                    <p class="text-muted small mb-2">Telepon: {{ $store->contact_phone ?? $store->owner->phone ?? '-' }}</p>
                    <p class="text-muted small mb-0">Alamat: {{ $store->owner->address ?? '-' }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">Aksi</h2>
                    @if($store->status === 'pending')
                        <form action="{{ route('admin.stores.approve', $store) }}" method="POST" class="mb-2">
                            @csrf @method('PATCH')
                            <button class="btn btn-success w-100" type="submit">Setujui Toko</button>
                        </form>
                        <form action="{{ route('admin.stores.reject', $store) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-outline-danger w-100" type="submit">Tolak Toko</button>
                        </form>
                    @else
                        <p class="text-muted small mb-3">Toko sudah berstatus {{ $store->status }}.</p>
                        <form action="{{ route('admin.stores.reject', $store) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-outline-danger w-100" type="submit">
                                Tandai sebagai ditolak
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
