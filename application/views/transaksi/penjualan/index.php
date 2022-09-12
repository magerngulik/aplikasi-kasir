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
                <div class="col-lg">
                 <div class="row">
                    <div class="col">
                        <form action="<?php base_url('data');?>" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Masukan Keyword Pencarian" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword" autocomplete="off" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <a class="btn btn-danger" href="<?= base_url('transaksi/allKonsumen1') ?>"> All Data</a>
                    </div>
                    <div class="col ml-auto">             
                    <?=  $this->pagination->create_links();?>
                    </div>
                </div>   

                </div>
            </div>  
            <?= $this->session->flashdata('message'); ?>
         
            <p class="font-weight-bold mb-0">Total Data <?=$total_rows?></p>  

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID Konsumen</th>
                        <th scope="col">Nama Konsumen</th>
                    
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
                    <!-- idpelanggan	nm_konsumen	alamat no_telp -->
                        <th scope="row"><?= ++$start; ?></th>
                        <td><?= $sm['idpelanggan']; ?></td>
                        <td><?= $sm['nm_konsumen']; ?></td>
                        <td>
                            <a href="<?= base_url('transaksi/inputNmKonsumen/').$sm['idpelanggan']; ?>" class="btn btn-primary">pilih</a>  
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
