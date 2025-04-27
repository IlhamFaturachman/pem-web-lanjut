@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title ?? 'Transaksi Penjualan' }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Transaksi Baru</button>
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

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Penjualan</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Jumlah Item</th>
                    <th>Total Harga</th>
                    <th>Petugas</th>
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

    var dataPenjualan;
    $(document).ready(function() {
        dataPenjualan = $('#table_penjualan').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('penjualan/list') }}",
                type: "POST",
                data: function(d) {
                    d.kategori_id = $('#kategori_id').val();
                }
            },
            columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false
                },
                {
                    data: "penjualan_kode"
                },
                {
                    data: "pembeli"
                },
                {
                    data: "penjualan_tanggal",
                    className: "text-center"
                },
                {
                    data: "total_item",
                    className: "text-center"
                },
                {
                    data: "total_harga",
                    className: "text-right"
                },
                {
                    data: "user.nama"
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#kategori_id').on('change', function() {
            dataPenjualan.ajax.reload();
        });
    });
</script>
@endpush