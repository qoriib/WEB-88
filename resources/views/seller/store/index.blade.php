@extends('layouts.app')

@section('title', 'Status Toko - OSS')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="h4 mb-3">Status Pengajuan Toko</h1>
                    @if($store)
                        <span class="badge text-bg-{{ $store->status === 'approved' ? 'success' : ($store->status === 'rejected' ? 'danger' : 'warning') }}">
                            Status: {{ ucfirst($store->status) }}
                        </span>
                        <h5 class="mt-3">{{ $store->name }}</h5>
                        <p class="text-muted mb-1">{{ $store->category->name ?? '-' }}</p>
                        <p class="text-muted mb-3">{{ $store->city }} - {{ $store->address }}</p>
                        <p class="mb-0">{{ $store->description }}</p>

                        <div class="mt-4">
                            @if($store->status === 'pending')
                                <div class="alert alert-info mb-0">
                                    Pengajuan Anda sedang ditinjau oleh admin. Anda akan menerima notifikasi setelah disetujui.
                                </div>
                            @elseif($store->status === 'approved')
                                <div class="alert alert-success mb-0">
                                    Toko telah disetujui. Anda dapat mulai mengelola produk begitu modul vendor aktif.
                                </div>
                                <a href="{{ route('seller.store.edit') }}" class="btn btn-primary mt-3">Edit Profil Toko</a>
                                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-primary mt-3">Kelola Produk</a>
                            @else
                                <div class="alert alert-warning">
                                    Pengajuan ditolak. Anda dapat mengajukan ulang dengan memperbarui data toko.
                                </div>
                                <a href="{{ route('seller.store.create') }}" class="btn btn-primary">Ajukan ulang</a>
                            @endif
                        </div>
                    @else
                        <p class="mb-4">
                            Anda belum memiliki toko aktif. Ajukan toko baru untuk mulai menjual produk di platform OSS.
                        </p>
                        <a href="{{ route('seller.store.create') }}" class="btn btn-primary">Ajukan Toko Sekarang</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
