@extends ('layouts.app')

{{-- Customize layout section --}}

@section('subtitle', 'Level')
@section('content_header_title','Home')
@section('content_header_subtitle','Level')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="float: left;">Manage Level</h3>
            <a href="/level/create" class="btn btn-primary" style="float: right;">Tambah Level</a>
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