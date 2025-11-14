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
            <div class="d-flex gap-3">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Mulai Registrasi</a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4">Sudah punya akun?</a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Mengapa OSS?</h5>
                    <ul class="list-unstyled mt-3 mb-0">
                        <li class="d-flex mb-3">
                            <span class="badge text-bg-primary rounded-circle me-3">1</span>
                            <div>
                                <h6 class="fw-semibold mb-1">Manajemen toko lengkap</h6>
                                <p class="mb-0 text-muted">Admin menyetujui permohonan toko, vendor mengelola katalog, stok, dan pesanan.</p>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                            <span class="badge text-bg-primary rounded-circle me-3">2</span>
                            <div>
                                <h6 class="fw-semibold mb-1">Keranjang & pembayaran aman</h6>
                                <p class="mb-0 text-muted">Pelanggan dapat checkout dengan prepaid (VA/ kartu) atau COD dalam kota.</p>
                            </div>
                        </li>
                        <li class="d-flex">
                            <span class="badge text-bg-primary rounded-circle me-3">3</span>
                            <div>
                                <h6 class="fw-semibold mb-1">Laporan transaksi otomatis</h6>
                                <p class="mb-0 text-muted">Setiap order menghasilkan PDF dan dikirim ke pelanggan untuk arsip.</p>
                            </div>
                        </li>
                    </ul>
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
                    <h6 class="fw-semibold mb-1">Tensimeter Omron HEM-7156</h6>
                    <p class="text-muted small mb-2">Mitra Alkes Indonesia</p>
                    <p class="fw-bold text-primary mb-0">Rp865.000</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <h6 class="fw-semibold mb-1">Kursi Roda Sella FS809</h6>
                    <p class="text-muted small mb-2">Total Care Bandung</p>
                    <p class="fw-bold text-primary mb-0">Rp1.850.000</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100">
                    <h6 class="fw-semibold mb-1">Autoclave Tuttnauer EZ9</h6>
                    <p class="text-muted small mb-2">Prima MedLab Surabaya</p>
                    <p class="fw-bold text-primary mb-0">Rp48.500.000</p>
                </div>
            </div>
        </div>
    </div>
@endsection
