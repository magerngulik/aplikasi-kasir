<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
   <!-- konsumen idpelanggan nm_konsumen alamat no_telp -->
    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">
            <input type="hidden" name="idsupplier" id="idsupplier" value="<?= $kategori['idpelanggan']; ?>">
            <?= $this->session->flashdata('name'); ?>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nama Konsumen</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nm_konsumen" name="nm_konsumen" value="<?= $kategori['nm_konsumen']; ?>" >
                    <?= form_error('nm_konsumen', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
          
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $kategori['alamat']; ?>" >
                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
          
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">No Telpon</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $kategori['no_telp']; ?>" >
                    <?= form_error('no_telp', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
          
            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=editBuku class="btn btn-primary">Edit</button>         
                    <a href="<?= base_url('data/konsumen'); ?>" name=editBuku class="btn btn-secondary ">Kembali</a>
                </div>
            </div>
            </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 