@extends('layouts.admin')

@section('header')
    Tambah Kostum Baru
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Kostum</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Kode Kostum</label>
                                    <input type="text" name="code" class="form-control" id="code" placeholder="Masukkan kode unik" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Kostum</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama kostum" required>
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <select name="category_id" class="form-control" id="category_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price_per_day">Harga Sewa / Hari (Rp)</label>
                                    <input type="number" name="price_per_day" class="form-control" id="price_per_day" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_qty">Stok Awal</label>
                                    <input type="number" name="stock_qty" class="form-control" id="stock_qty" placeholder="0" required>
                                </div>
                                <div class="form-group">
                                    <label for="condition_status">Kondisi Awal</label>
                                    <select name="condition_status" class="form-control" id="condition_status">
                                        <option value="Good">Good (Baik)</option>
                                        <option value="Minor Damage">Minor Damage</option>
                                        <option value="Damaged">Damaged (Rusak)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" class="form-control" id="description" rows="1" placeholder="Deskripsi singkat..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="condition_notes">Catatan Kondisi</label>
                                    <textarea name="condition_notes" class="form-control" id="condition_notes" rows="1" placeholder="Detail kondisi awal..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="image">Foto Kostum</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Kostum</button>
                        <a href="{{ route('admin.assets.index') }}" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
