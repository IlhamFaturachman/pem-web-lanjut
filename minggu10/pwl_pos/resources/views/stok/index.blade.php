@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title ?? 'Manajemen Stok Barang' }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Stok</button>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row mx-3 mt-2">
        <div class="col-md-12">
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Filter:</label>
                <div class="col-3">
                    <select class="form-control" id="kategori_id" name="kategori_id">
                        <option value="">- Semua -</option>
                        @foreach ($kategori as $item)
                        <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Kategori Barang</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mx-3 mb-3">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan Stok Barang Saat Ini</h3>
                    <a href="{{ url('/stok/export_excel') }}" class="btn btn-success btn-sm ml-1">Export Excel</a>
                </div>
                <div class="card-body" id="stok-summary">
                    <div class="text-muted">Memuat data...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah Stok</th>
                    <th>Jenis</th>
                    <th>Tanggal Stok Masuk</th>
                    <th>Diinput Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true">
</div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataStok;
    $(document).ready(function() {
        dataStok = $('#table_stok').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('stok/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.kategori_id = $('#kategori_id').val();
                }
            },
            columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang.barang_name",
                    orderable: true
                },
                {
                    data: "barang.kategori.kategori_nama",
                    orderable: false
                },
                {
                    data: "stok_jumlah",
                    className: "text-right",
                    orderable: true
                },
                {
                    data: "stok_jenis",
                    className: "text-center"
                },
                {
                    data: "stok_tanggal",
                    className: "text-center",
                    orderable: true
                },
                {
                    data: "user.nama",
                    orderable: false
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#kategori_id').on('change', function() {
            dataStok.ajax.reload();
        });
    });

    $(document).ready(function() {
        $.getJSON('/stok/summary', function(data) {
            let html = `
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kondisi Stok Sekarang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>`;

            data.forEach(item => {
                let badgeClass = item.status === 'Hampir Habis' ? 'danger' : 'success';
                html += `
                <tr>
                    <td>${item.barang_name}</td>
                    <td><strong>${item.total_stok}</strong></td>
                    <td><span class="badge bg-${badgeClass}">${item.status}</span></td>
                </tr>`;
            });

            html += `</tbody></table>`;
            $('#stok-summary').html(html);
        });
    });
</script>
@endpush