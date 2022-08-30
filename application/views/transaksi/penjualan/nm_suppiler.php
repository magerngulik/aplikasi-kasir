<!-- Begin Page Content -->
<div class="container-fluid">

    
<!-- no_pembelian no_notabeli idpegawai idsupplier jenis tgl_masuk catatan -->

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">           
            <input type="hidden" name="idpelanggan" id="idpelanggan" value="<?= $konsumen['idpelanggan']; ?>">
            <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?= $user['id_pegawai']; ?>">
            <input type="hidden" name="alamat" id="alamat" value="<?= $konsumen['alamat']; ?>">
            <input type="hidden" name="no_telp" id="no_telp" value="<?= $konsumen['no_telp']; ?>">
            <?= $this->session->flashdata('name'); ?>

            <!-- idpelanggan	nm_konsumen	alamat no_telp -->
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nama Pelangan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nm_konsumen" name="nm_konsumen" value="<?= $konsumen['nm_konsumen']?>" readonly>
                    <?= form_error('nm_konsumen', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div> 

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Nota</label>
                    <div class="col-sm-10">
                    <input type="date"  class="col-sm-4" id="tgl_msk" name="tgl_msk" >
                    <br>
                        <?= form_error('tgl_msk', '<small class="text-danger pl-3">', '</small>'); ?>           
                    </div>
                </div>

          
            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=editBuku class="btn btn-primary">Save</button>         
                    <a href="<?= base_url('transaksi/penjualan/'); ?>" name=editBuku class="btn btn-secondary ">Kembali</a>
                </div>
            </div>
            </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 