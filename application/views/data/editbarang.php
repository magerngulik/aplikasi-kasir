<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            
        <form action="" method="post">
            <input type="hidden" name="id" id="id" value="<?= $barang['idbarang']; ?>">
            <?= $this->session->flashdata('name'); ?>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nm_barang" name="nm_barang" value="<?= $barang['nm_barang']; ?>" >
                    <?= form_error('nm_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Harga Modal</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="hrg_modal" name="hrg_modal" value="<?= $barang['hrg_modal']; ?>" >
                    <?= form_error('hrg_modal', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Harga Satuan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="hrg_satuan" name="hrg_satuan" value="<?= $barang['hrg_satuan']; ?>" >
                    <?= form_error('hrg_satuan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Stock</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="stok" name="stok" value="<?= $barang['stok']; ?>" >
                    <?= form_error('stok', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
   
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Menu</label>
            <div class="col-sm-10">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <?php foreach ($kategori as $m) : ?>                                     
                                <?php if ($m['idkategori'] == $barang['idkategori']) : ?>
                                    <option selected value="<?= $m['idkategori']; ?>"><?= $m['nm_kategori']; ?></option>
                                    <?php else : ?>
                                <option value="<?= $m['idkategori']; ?>"><?= $m['nm_kategori']; ?></option>                                
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('menu_id', '<small class="text-danger pl-3">', '</small>'); ?>    
                    </div>
            </div>
           

            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=editBuku class="btn btn-primary">Edit</button>                          
                    <a href="<?= base_url('data'); ?>" name=editBuku class="btn btn-secondary ">Kembali</a>
                </div>
                
            </div>
            </div>

            </form>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 