@csrf
<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $product->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">SKU</label>
    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
           value="{{ old('sku', $product->sku ?? '') }}">
    @error('sku')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $product->price ?? '') }}" min="0" required>
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Stok</label>
        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
@php($isActive = old('is_active', $product->is_active ?? true))
<div class="form-check form-switch mt-4">
    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ $isActive ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Produk aktif dan tampil pada katalog</label>
</div>
<div class="mt-3">
    <label class="form-label">Foto Produk</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/png,image/jpeg">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(!empty($product?->thumbnail_path))
        <div class="mt-2">
            <p class="text-muted small mb-1">Foto saat ini:</p>
            <img src="{{ asset('storage/' . $product->thumbnail_path) }}" alt="Foto produk" class="img-thumbnail" style="max-height: 120px;">
        </div>
    @endif
</div>
