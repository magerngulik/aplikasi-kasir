<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">
            <input type="hidden" name="idkategori" id="idkategori" value="<?= $kategori['idkategori']; ?>">
            <?= $this->session->flashdata('name'); ?>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nama Kategori</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nm_kategori" name="nm_kategori" value="<?= $kategori['nm_kategori']; ?>" >
                    <?= form_error('nm_kategori', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=editBuku class="btn btn-primary">Edit</button>         
                    <a href="<?= base_url('data/kategori'); ?>" name=editBuku class="btn btn-secondary ">Kembali</a>
                </div>
            </div>
            </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 