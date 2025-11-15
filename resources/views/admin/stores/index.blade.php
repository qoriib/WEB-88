@extends('layouts.app')

@section('title', 'Persetujuan Toko - Admin OSS')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase text-primary small mb-1">Admin Panel</p>
                    <h1 class="h4 mb-0">Persetujuan Toko Vendor</h1>
                </div>
                <form class="d-flex gap-2 mt-3 mt-md-0" method="GET">
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Cari nama toko/pemilik">
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        <option value="pending" @selected(($filters['status'] ?? '') === 'pending')>Pending</option>
                        <option value="approved" @selected(($filters['status'] ?? '') === 'approved')>Approved</option>
                        <option value="rejected" @selected(($filters['status'] ?? '') === 'rejected')>Rejected</option>
                    </select>
                    <button class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Daftar Pengajuan</h2>
                    @forelse($stores as $store)
                        <div class="border rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">{{ $store->name }}</h5>
                                    <p class="text-muted small mb-1">{{ $store->category->name ?? '-' }}</p>
                                    <p class="text-muted small mb-1">Pemilik: {{ $store->owner->name }} ({{ $store->owner->email }})</p>
                                    <p class="text-muted small mb-2">{{ $store->city }} - {{ $store->address }}</p>
                                    <p class="mb-0">{{ $store->description }}</p>
                                </div>
                                <div class="text-end">
                                    <p class="text-muted small mb-3">Masuk: {{ $store->created_at->format('d M Y') }}</p>
                                    <p class="text-muted small mb-3">Status: <strong>{{ ucfirst($store->status) }}</strong></p>
                                    <a href="{{ route('admin.stores.show', $store) }}" class="btn btn-link btn-sm w-100 text-decoration-none mb-2">Lihat detail</a>
                                    @if($store->status === 'pending')
                                        <form action="{{ route('admin.stores.approve', $store) }}" method="POST" class="mb-2">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-success btn-sm w-100">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.stores.reject', $store) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-outline-danger btn-sm w-100">Tolak</button>
                                        </form>
                                    @else
                                        <span class="badge text-bg-{{ $store->status === 'approved' ? 'success' : 'danger' }}">
                                            {{ ucfirst($store->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tidak ada pengajuan baru.</p>
                    @endforelse
                </div>
                <div class="card-footer">
                    {{ $stores->links() }}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Riwayat Aktivitas</h2>
                    @forelse($recent as $store)
                        <div class="border rounded-3 p-3 mb-2">
                            <h6 class="mb-1">{{ $store->name }}</h6>
                            <p class="text-muted small mb-1">Pemilik: {{ $store->owner->name }}</p>
                            <p class="text-muted small mb-0">Status: {{ ucfirst($store->status) }} ({{ $store->updated_at->format('d M Y') }})</p>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada data.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
