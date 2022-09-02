<!-- Begin Page Content -->
<div class="container-fluid">

    
<!-- no_pembelian no_notabeli idpegawai idsupplier jenis tgl_masuk catatan -->

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">
            <input type="hidden" name="idbarang" id="idbarang" value="<?= $ketbarang['idbarang']; ?>">
            <input type="hidden" name="hrg_modal" id="hrg_modal" value="<?= $ketbarang['hrg_modal']; ?>">
            <input type="hidden" name="hrg_satuan" id="hrg_satuan" value="<?= $ketbarang['hrg_satuan']; ?>">

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nm_barang" name="nm_barang" value ="<?=$ketbarang['nm_barang']?>" readonly>
                    <?= form_error('nm_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="hrg_modal" name="hrg_modal"  value ="<?=$ketbarang['hrg_modal']?>" readonly>
                    <?= form_error('hrg_modal', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>          
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Jumlah</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="jml" name="jml">
                    <?= form_error('jml', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>          
            </div>
            <div class="form-group row justify-content-end">
                <div class="col">
                    <button type="submit" name="total" class="btn btn-primary"  style="width: 66%;">Hitung</button>               
                </div>
            </div>
        
            </form>
            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Total Harga</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="total" name="total"  value ="<?=$total?>" readonly>
                    <?= form_error('hrg_modal', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>          
            </div> 
            <div class="form-group row justify-content-end">
                    <div class="col-md-5 ">                   
                    <a href="<?= base_url('transaksi/cekharga'); ?>" name=detailBeli class="btn btn-secondary ">Kembali</a>
                    </div>
            </div>       
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 