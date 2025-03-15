@extends ('layouts.app')

{{-- Customize layout section --}}

@section('subtitle', 'Kategori')
@section('content_header_title','Home')
@section('content_header_subtitle','Kategori')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="float: left;">Manage Kategori</h3>
            <a href="/kategori/create" class="btn btn-primary" style="float: right;">Tambah Kategori</a>
        </div>
        <div class="card-body">
            {{ $dataTable -> table() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{ $dataTable -> scripts() }}
@endpush