<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
        <form action="" method="post">
            <input type="hidden" name="id" id="id" value="<?= $subMenu['id']; ?>">
            <?= $this->session->flashdata('name'); ?>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Title Menu</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" value="<?= $subMenu['title']; ?>" >
                    <?= form_error('nm_siswa', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            
   
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Menu</label>
            <div class="col-sm-10">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <?php foreach ($menu as $m) : ?>

                            <?php if ($m['id'] == $subMenu['menu_id']) : ?>
                            <option selected value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php else : ?>
                            <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>           
                           <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('menu_id', '<small class="text-danger pl-3">', '</small>'); ?>    
                        </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Url Menu</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="url" name="url" value="<?= $subMenu['url']; ?>">
                    <?= form_error('nisn', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Icon Menu</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="icon" name="icon" value="<?= $subMenu['icon']; ?>" >                                  
                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>           
                </div>
            </div>

            <div class="form-group row justify-content-end">
                    <div class="col-md-10">
                        <button type="submit" name=editBuku class="btn btn-primary">Edit</button>       
                        
                    <a href="<?= base_url('menu/submenu'); ?>" name=editBuku class="btn btn-secondary ">Kembali</a>
                </div>
                
            </div>

            </form>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 