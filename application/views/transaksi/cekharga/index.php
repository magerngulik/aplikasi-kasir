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
                <div class="col">
                 <div class="row">
                    <div class="col">
                        <form action="<?php base_url('data');?>" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Masukan Keyword Pencarian" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword" autocomplete="off" autofocus >
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <a class="btn btn-danger" href="<?= base_url('transaksi/alldataHarga/')?>"> All Data</a>
                    </div>
                    <div class="col ml-auto">             
                <?=  $this->pagination->create_links();?>
                </div>

                </div>   

                </div>
            </div>  
            <?= $this->session->flashdata('message'); ?>
            <div class="col">
                    <p class="font-weight-bold mb-0">Total Data <?=$total_rows?></p>                
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
                            <a href="<?= base_url('transaksi/hitungharga/').$sm['idbarang']; ?>" class="btn btn-primary">pilih</a> 
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
<?php 
 function rupiah($angka){
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                return $hasil_rupiah;
    }  ?>