@empty($penjualan)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data penjualan tidak ditemukan.
            </div>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm mb-4">
                <tr>
                    <th>Kode Penjualan</th>
                    <td>{{ $penjualan->penjualan_kode }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Pembeli</th>
                    <td>{{ $penjualan->pembeli }}</td>
                </tr>
                <tr>
                    <th>Petugas</th>
                    <td>{{ $penjualan->user->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $penjualan->created_at->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Diupdate Pada</th>
                    <td>{{ $penjualan->updated_at->format('d M Y H:i') }}</td>
                </tr>
            </table>

            <h5>Daftar Barang</h5>
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($penjualan->details as $i => $d)
                    @php
                    $subtotal = $d->harga * $d->jumlah;
                    $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $d->barang->barang_name ?? '-' }}</td>
                        <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" onclick="printStruk()">Cetak Struk</button>
        </div>
    </div>

    {{-- STRUK PRINT --}}
    <div id="print-area" style="display: none;">
        <div style="font-family: monospace; font-size: 12px; width: 250px;">
            <center>
                <h4>{{ config('app.name', 'Toko Ilham') }}</h4>
                <p>{{ now()->format('d M Y H:i') }}</p>
                ----------------------------------------
            </center>
            <p>
                Kode : {{ $penjualan->penjualan_kode }}<br>
                Pembeli : {{ $penjualan->pembeli }}<br>
                Petugas : {{ $penjualan->user->nama ?? '-' }}
            </p>
            ----------------------------------------
            @foreach ($penjualan->details as $d)
            @php
            $subtotal = $d->harga * $d->jumlah;
            @endphp
            {{ $d->barang->barang_name ?? '-' }}<br>
            {{ $d->jumlah }} x Rp {{ number_format($d->harga, 0, ',', '.') }}
            <span style="float: right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span><br>
            @endforeach
            ----------------------------------------
            <strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong><br>
            ----------------------------------------
            <center>Terima kasih!</center>
        </div>
    </div>
</div>
{{-- JS CETAK --}}
<script>
    function printStruk() {
        const content = document.getElementById('print-area').innerHTML;
        const win = window.open('', '', 'width=400,height=600');
        win.document.write(`<html><head><title>Struk Penjualan</title></head><body>`);
        win.document.write(content);
        win.document.write('</body></html>');
        win.document.close();
        win.focus();
        win.print();
        win.close();
    }
</script>
@endempty