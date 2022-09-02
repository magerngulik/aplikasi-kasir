<!-- Begin Page Content -->
<div class="container-fluid">

    
<!-- no_pembelian no_notabeli idpegawai idsupplier jenis tgl_masuk catatan -->

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">
            <!-- idbarang nm_barang hrg_modal hrg_satuan stok idkategori	 -->

            <!-- 
            nm barang 
			idbarang 
			
            stok

			Harga Beli
			hrg_modal

			Harga Jual
			hrg_satuan
			
            Jumlah
            jml -->

            <input type="hidden" name="idbarang" id="idbarang" value="<?= $ketbarang['idbarang']; ?>">
            <input type="hidden" name="hrg_modal" id="hrg_modal" value="<?= $ketbarang['hrg_modal']; ?>">
            <input type="hidden" name="hrg_satuan" id="hrg_satuan" value="<?= $ketbarang['hrg_satuan']; ?>">
            
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Barang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nm_barang" name="nm_barang" value ="<?=$ketbarang['nm_barang']?>" readonly>
                    <?= form_error('nm_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Stok</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="stok" name="stok" value ="<?=$ketbarang['stok']?>" readonly>
                    <?= form_error('stok', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="hrg_modal" name="hrg_modal"  value ="<?=$ketbarang['hrg_modal']?>" readonly>
                    <?= form_error('hrg_modal', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Harga Jual</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="hrg_satuan" name="hrg_satuan" value ="<?=$ketbarang['hrg_satuan']?>">
                    <?= form_error('hrg_satuan', '<small class="text-danger pl-3">', '</small>'); ?>
                    <?= $this->session->flashdata('modalnotvalid'); ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Jumlah Beli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jml_beli" name="jml_beli">
                    <?= form_error('jml_beli', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>

            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=detailbeli class="btn btn-primary">Simpan</button>         
                    <a href="<?= base_url('transaksi/hapusidJualBarang'); ?>" name=detailBeli class="btn btn-secondary ">Kembali</a>
                </div>
            </div>
        </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 