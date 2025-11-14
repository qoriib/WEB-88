@extends('layouts.app')

@section('title', 'Dashboard - OSS')

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-2">Dashboard</h1>
                    <p class="text-muted mb-0">
                        Selamat datang, {{ auth()->user()->name }}. Gunakan menu di atas untuk mengelola toko, produk, atau melakukan pembelian.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
