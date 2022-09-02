<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <div class="row">
                <!-- ukuran dalam col untuk mengatur panjang dari dari element yang sedand ei eksekusi-->
                <div class="col-6">
                 <div class="row">
                    <div class="col">
                        <form action="<?php base_url('data');?>" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Masukan Keyword Pencarian" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword" autocomplete="off" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <a class="btn btn-danger" href="<?= base_url('data/allSupiller') ?>"> All Data</a>
                    </div>
                    </div>   

                </div>
            </div>  

            <?= $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col">
                <a href="<?= base_url("data/tambahSupplier/") ?>" class="btn btn-primary mb-3">Tambah Data</a>
                </div>
                <div class="col ml-auto">             
                <?=  $this->pagination->create_links();?>
                </div>
            </div>     
            <p class="font-weight-bold mb-0">Total Data <?=$total_rows?></p>  

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID Suppiler</th>
                        <th scope="col">Nama Suppiler</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">No Telpon</th>
                        <th scope="col">Kontak</th>
                        <th scope="col">Action</th>
                 
                    </tr>
                </thead>
                <tbody>
                   <?php if(empty($poin)):?>
                    <tr>
                        <td colspan ="7">
                        <div class="alert alert-danger" role="alert">   
                                Data tidak di temukan
                            </div>
                        </td>
                    </tr>
                   <?php endif?>
                    <?php foreach ($poin as $sm) : ?>
                    <tr>
                    <!-- idsupplier	nm_supplier	alamat	no_telp	kontak -->
                        <th scope="row"><?= ++$start; ?></th>
                        <td><?= $sm['idsupplier']; ?></td>
                        <td><?= $sm['nm_supplier']; ?></td>
                        <td><?= $sm['alamat']; ?></td>
                        <td><?= $sm['no_telp']; ?></td>
                        <td><?= $sm['kontak']; ?></td>
                      
                   
                        <td>
                            <a href="<?= base_url('data/editSuppiler/').$sm['idsupplier']; ?>" class="badge badge-success">edit</a>
                            <a href="<?= base_url('data/hapusSuppiler/').$sm['idsupplier']; ?>" onclick="return confirm('Apakah anda ingin menghapus data ini?');" class="badge badge-danger">Delete</a>
                        </td>
                    </tr>
                    <?php ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
