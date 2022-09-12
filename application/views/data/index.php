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
                                    <button class="btn btn-primary" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <a class="btn btn-danger" href="<?= base_url('data/alldata/')?>"> All Data</a>
                    </div>
                </div>   

                </div>
            </div>  
            <?= $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col">
                <a href="<?= base_url("data/tambahBarang/") ?>" class="btn btn-primary mb-3">Tambah Data</a>
                </div>
                <div class="col ml-auto">             
                <?=  $this->pagination->create_links();?>
                </div>
            </div>     
            <div class="col">
                    <p class="font-weight-bold mb-0">Total Data <?=$total_rows?></p>  
                    <p class="font-weight-bold mb-0">Nilai Assets : <?= rupiah($tAssets['total'])?></p>
                    <p class="font-weight-bold mb-0">Total Stock  : <?= $tStock['total']?> </p>                
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Harga Beli</th>
                        <th scope="col">Harga Jual</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Action</th>
                 
                    </tr>
                </thead>
                <tbody>
                   <?php if(empty($poin)):?>
                    <tr>
                        <td colspan ="8">
                        <div class="alert alert-danger" role="alert">   
                                Data tidak di temukan
                            </div>
                        </td>
                    </tr>
                   <?php endif?>
                    <?php foreach ($poin as $sm) : ?>
                    <tr>
                        <th scope="row"><?= ++$start; ?></th>
                        <td><?= $sm['idbarang']; ?></td>
                        <td><?= $sm['nm_barang']; ?></td>
                        <td><?= $sm['hrg_modal']; ?></td>
                        <td><?= $sm['hrg_satuan']; ?></td>
                        <td><?= $sm['stok']; ?></td>
                        <td><?= $sm['nm_kategori']; ?></td>
                   
                        <td>
                            <a href="<?= base_url('data/editBarang/').$sm['idbarang']; ?>" class="btn btn-primary">edit</a>
                            <a href="<?= base_url('data/hapusDataBarang/').$sm['idbarang']; ?>" onclick="return confirm('Apakah anda ingin menghapus data ini?');" class="btn btn-danger">Delete</a>

                        </td>
                    </tr>
                    <?php ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php 
            function rupiah($angka){
        
                $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                return $hasil_rupiah;
            }        
            ?>
      

   

        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
