@extends('layouts.app')

@section('title', 'Produk Toko - OSS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1">Daftar Produk</h1>
            <p class="text-muted mb-0">{{ $store->name }} &mdash; {{ $store->city }}</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">Tambah Produk</a>
    </div>

    @if($products->isEmpty())
        <div class="alert alert-info">
            Belum ada produk. Mulai dengan menambahkan produk pertama Anda.
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $product->thumbnail_path ? asset('storage/' . $product->thumbnail_path) : 'https://placehold.co/80x80?text=OSS' }}"
                                             class="rounded" alt="{{ $product->name }}" width="64" height="64">
                                        <div>
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                            <div class="text-muted small">SKU: {{ $product->sku ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Tidak aktif' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        </div>
    @endif
@endsection
