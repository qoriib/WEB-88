@extends('layouts.app')

@section('title', 'OSS - Online Shopping System')

@section('content')
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <p class="text-uppercase text-primary fw-semibold mb-2">Prima Tech Solution</p>
            <h1 class="display-5 fw-bold text-dark mb-4">Online Shopping System untuk Toko Alat Kesehatan Modern</h1>
            <p class="text-muted fs-5 mb-4">
                OSS memudahkan vendor alat kesehatan membuka toko daring, dan pelanggan bisa memesan perangkat
                diagnostik, perawatan pasien, hingga perlengkapan laboratorium tanpa meninggalkan klinik mereka.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4">Belanja Sekarang</a>
                <a href="{{ route('store.apply.public') }}" class="btn btn-outline-primary btn-lg px-4">Ajukan Toko</a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row g-3">
                <div class="col-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-3">
                        <p class="fw-semibold mb-1">Produk Resmi</p>
                        <p class="text-muted small mb-0">Mitra terverifikasi alat kesehatan, harga transparan.</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-3">
                        <p class="fw-semibold mb-1">Pembayaran Aman</p>
                        <p class="text-muted small mb-0">Upload bukti transfer, verifikasi langsung oleh vendor.</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-3">
                        <p class="fw-semibold mb-1">Pengajuan Toko</p>
                        <p class="text-muted small mb-0">Daftar gratis, ajukan toko, admin menyetujui.</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-3">
                        <p class="fw-semibold mb-1">Lacak Pesanan</p>
                        <p class="text-muted small mb-0">Dashboard pelanggan memantau status order & pembayaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="h4 mb-1">Lihat katalog terbaru</h2>
                <p class="text-muted mb-0">Produk yang disediakan langsung oleh mitra resmi OSS.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Buka katalog</a>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <img src="https://placehold.co/600x400?text=OSS+Product" class="img-fluid rounded mb-3" alt="Produk OSS">
                    <h6 class="fw-semibold mb-1">Tensimeter Omron HEM-7156</h6>
                    <p class="text-muted small mb-2">Mitra Alkes Indonesia</p>
                    <p class="fw-bold text-primary mb-0">Rp865.000</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <img src="https://placehold.co/600x400?text=OSS+Product" class="img-fluid rounded mb-3" alt="Produk OSS">
                    <h6 class="fw-semibold mb-1">Kursi Roda Sella FS809</h6>
                    <p class="text-muted small mb-2">Total Care Bandung</p>
                    <p class="fw-bold text-primary mb-0">Rp1.850.000</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <img src="https://placehold.co/600x400?text=OSS+Product" class="img-fluid rounded mb-3" alt="Produk OSS">
                    <h6 class="fw-semibold mb-1">Autoclave Tuttnauer EZ9</h6>
                    <p class="text-muted small mb-2">Prima MedLab Surabaya</p>
                    <p class="fw-bold text-primary mb-0">Rp48.500.000</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-semibold">Pelanggan</h5>
                        <p class="text-muted">Daftar, pilih produk, bayar (upload bukti), pantau status di dashboard.</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Buat Akun</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-link btn-sm">Dashboard</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-semibold">Vendor</h5>
                        <p class="text-muted">Ajukan toko, tunggu persetujuan admin, lalu kelola produk dan verifikasi pembayaran.</p>
                        <a href="{{ route('store.apply.public') }}" class="btn btn-outline-primary btn-sm">Ajukan Toko</a>
                        <a href="{{ route('seller.products.index') }}" class="btn btn-link btn-sm">Produk Saya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
