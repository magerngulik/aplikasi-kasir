<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">
            
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nm_barang" name="nm_barang" placeholder="Nama Barang">
                    <?= form_error('nm_barang', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="hrg_modal" name="hrg_modal" placeholder="Harga Modal">
                    <?= form_error('hrg_modal', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label"> Harga Jual</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="hrg_satuan" name="hrg_satuan" placeholder="Harga Jual">
                    <?= form_error('hrg_satuan', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label"> Stock</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok">
                    <?= form_error('stok', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $m) : ?>
                            <option value="<?=$m['idkategori']?>"><?=$m['nm_kategori']  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('kategori', '<small class="text-danger pl-3">', '</small>'); ?>    
                        </div>
            </div>
                        
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" name=editBuku class="btn btn-primary">Tambah Data</button>
                    <a href="<?= base_url('data/'); ?>" name=editBuku class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            </form>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 