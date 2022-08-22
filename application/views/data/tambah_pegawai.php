<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">
            
            <!-- Full texts
            id
            name
            email
            image
            password
            role_id
            is_active
            date_created
            id_pegawai -->

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Username" autocomplete=’off’>
                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete=’off’>
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Ulangi Password</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Ulangi Password">
                    <?= form_error('repassword', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-3">
                        <select name="role" id="role" class="form-control">
                            <option value="">Pilih Role</option>
                            <?php foreach ($role as $m) : ?>
                            <option value="<?=$m['id']?>"><?=$m['role']  ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('role', '<small class="text-danger pl-3">', '</small>'); ?>    
                        </div>
            </div>
                        
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" name=editBuku class="btn btn-primary">Tambah Data</button>
                    <a href="<?= base_url('data/pegawai'); ?>" name=editBuku class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            </form>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 