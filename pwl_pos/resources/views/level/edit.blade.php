@extends('layouts.app')
{{-- Customize layout section --}}

@section('subtitle', 'Level')
@section('content_header_title','Level')
@section('content_header_subtitle','Edit')

@section('content')
<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Level</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('level.update', $level->level_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeLevel">Kode Level</label>
                        <input type="text" class="form-control" id="kodeLevel" name="kodeLevel" required placeholder="Masukkan kode level" value="{{ $level->level_kode }}">
                    </div>
                    <div class="form-group">
                        <label for="namaLevel">Nama Level</label>
                        <input type="text" class="form-control" id="namaLevel" name="namaLevel" required placeholder="Masukkan nama level" value="{{ $level->level_name }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection