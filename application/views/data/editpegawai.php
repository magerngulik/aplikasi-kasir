<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
    
        <form action="" method="post">
            <input type="hidden" name="id" id="id" value="<?= $user['id']; ?>">
            <?= $this->session->flashdata('name'); ?>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" >
                    <?= form_error('nm_barang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
         
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Menu</label>
            <div class="col-sm-10">
                        <select name="role" id="role" class="form-control">
                            <?php foreach ($role as $m) : ?>                                     
                                <?php if ($m['id'] == $user['role_id']) : ?>
                                    <option selected value="<?= $m['id']; ?>"><?= $m['role']; ?></option>
                                    <?php else : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['role']; ?></option>                                
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('role', '<small class="text-danger pl-3">', '</small>'); ?>    
                    </div>
            </div>
           

            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=editBuku class="btn btn-primary">Edit</button>                          
                    <a href="<?= base_url('data/pegawai/'); ?>" name=editBuku class="btn btn-secondary ">Kembali</a>
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