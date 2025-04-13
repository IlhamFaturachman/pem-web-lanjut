<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah-penjualan">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    {{-- Form Tanggal: default hari ini --}}
                    <input type="date" name="penjualan_tanggal" class="form-control"
                        value="{{ $tanggal }}" required>
                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                </div>

                <hr>

                <h5>Detail Barang</h5>
                <div id="detail-penjualan">
                    <div class="row mb-2 item-barang">
                        <div class="col-md-4">
                            <select name="barang_id[]" class="form-control barang-select" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $item)
                                <option value="{{ $item->barang_id }}"
                                    data-harga="{{ $item->harga_jual }}"
                                    data-stok="{{ $item->stok_total->total ?? 0 }}">
                                    {{ $item->barang_kode }} - {{ $item->barang_name }} (Stok: {{ $item->stok_total->total ?? 0 }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="harga[]" class="form-control harga-barang" placeholder="Harga" readonly>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-start">
                            <button type="button" class="btn btn-danger btn-sm mt-1 remove-barang">Hapus</button>
                        </div>
                    </div>
                </div>


                <button type="button" class="btn btn-secondary btn-sm mt-2" id="tambah-barang">+ Tambah Barang</button>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Tampilkan tanggal hari ini secara default
        $('input[name="penjualan_tanggal"]').val(new Date().toISOString().split('T')[0]);

        // Tambah barang
        $('#tambah-barang').click(function() {
            const clone = $('#detail-penjualan .item-barang:first').clone();
            clone.find('select').val('');
            clone.find('input').val('');
            clone.find('.harga-barang').val('');
            $('#detail-penjualan').append(clone);
        });

        // Hapus barang
        $(document).on('click', '.remove-barang', function() {
            if ($('.item-barang').length > 1) {
                $(this).closest('.item-barang').remove();
            } else {
                alert('Minimal 1 barang harus ada.');
            }
        });

        // Saat jumlah berubah: validasi dan kurangi stok
        $(document).on('change', '.item-barang select, .item-barang input[name="jumlah[]"]', function() {
            $('.item-barang').each(function() {
                const select = $(this).find('select');
                const inputJumlah = $(this).find('input[name="jumlah[]"]');

                const stok = parseInt(select.find(':selected').data('stok')) || 0;
                const jumlah = parseInt(inputJumlah.val()) || 0;

                // Validasi: jumlah tidak boleh melebihi stok
                if (jumlah > stok) {
                    inputJumlah.val(stok);
                    Swal.fire('Stok Tidak Cukup', 'Jumlah melebihi stok tersedia!', 'warning');
                }
            });
        });

        // Saat barang dipilih, ambil harga dan isi otomatis
        $(document).on('change', '.barang-select', function() {
            const harga = $(this).find(':selected').data('harga') || 0;
            const parent = $(this).closest('.item-barang');
            parent.find('.harga-barang').val(harga);
        });


        // Submit Ajax
        $('#form-tambah-penjualan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serialize(),
                success: function(res) {
                    if (res.status) {
                        $('#myModal').modal('hide');
                        Swal.fire('Berhasil', res.message, 'success');
                        dataPenjualan.ajax?.reload();
                    } else {
                        $('.error-text').text('');
                        $.each(res.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire('Gagal', res.message, 'error');
                    }
                }
            });
        });
    });
</script>