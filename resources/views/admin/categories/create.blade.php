@extends('layouts.admin')

@section('content')
    <h3>Tambah Kategori</h3>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div>
            <label>Nama Kategori:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Urutan:</label>
            <input type="number" name="order" value="0" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
@endsection
