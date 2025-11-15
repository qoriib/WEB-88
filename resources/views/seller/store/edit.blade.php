@extends('layouts.app')

@section('title', 'Edit Profil Toko - OSS')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-4">Perbarui Informasi Toko</h1>
                    <form action="{{ route('seller.store.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Toko</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $store->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="store_category_id" class="form-select @error('store_category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('store_category_id', $store->store_category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('store_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $store->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                   value="{{ old('city', $store->city) }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $store->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Email Kontak</label>
                                <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror"
                                       value="{{ old('contact_email', $store->contact_email) }}" required>
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telepon Kontak</label>
                                <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror"
                                       value="{{ old('contact_phone', $store->contact_phone) }}" required>
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('seller.store.index') }}" class="btn btn-outline-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
