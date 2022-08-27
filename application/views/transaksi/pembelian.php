<!-- Begin Page Content -->
<div class="container-fluid">

    
<!-- no_pembelian no_notabeli idpegawai idsupplier jenis tgl_masuk catatan -->

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">           
            <input type="hidden" name="idsupplier" id="idsupplier" value="<?= $kategori['idsupplier']; ?>">
            <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?= $user['id_pegawai']; ?>">
            <?= $this->session->flashdata('name'); ?>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">No Nota Beli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_nota" name="no_nota">
                    <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Suppiler</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nm_supplier" name="nm_supplier" value="<?= $kategori['nm_supplier']; ?>" readonly >
                    <?= form_error('nm_supplier', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>

            
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Jenis</label>
            <div class="col-sm-10">
                        <select name="jenis" id="jenis" class="form-control">                                                                  
                                <option value="Kredit">Kredit</option>                                
                                <option value="Tunai">Tunai</option>                                
                        </select>
                        <?= form_error('jenis', '<small class="text-danger pl-3">', '</small>'); ?>    
                    </div>
            </div>
   
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Masuk</label>
                    <div class="col-sm-10">
                    <input type="date"  class="col-sm-4" id="tgl_msk" name="tgl_msk" >
                    <br>
                        <?= form_error('tgl_msk', '<small class="text-danger pl-3">', '</small>'); ?>           
                    </div>
                </div>

          
            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=editBuku class="btn btn-primary">Save</button>         
                    <a href="<?= base_url('transaksi'); ?>" name=editBuku class="btn btn-secondary ">Kembali</a>
                </div>
            </div>
            </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 