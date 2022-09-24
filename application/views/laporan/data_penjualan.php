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

            <?= $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col">
                <a href="<?= base_url("laporan/reportPenjualan/") ?>" class="btn btn-primary mb-3">Cetak</a>
                <a href="<?= base_url("laporan/alldataPenjualan/") ?>" class="btn btn-danger mb-3">All Data</a>
           
                </div>

                <div class="col ml-auto">             
                <?=  $this->pagination->create_links();?>
                </div>
            </div>     
            <div class="row">
                <form action="" method="post">
                <div class="form-group col">
                    <label for="notabeli" class="col col-form-label">Tanggal Masuk</label>
                            <div class="input-group">
                            <input type="date" class="form-control" placeholder="Masukan Keyword Pencarian" name="tgl_msk" autocomplete="off" autofocus>

                            <div class="input-group-append">
                                    <button class="btn btn-primary" type="submittgl" name= "submittgl">Cari</button>
                                </div>
                            </div>
                        <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>                    
                </div>
                </form>

                <form action="" method="post">
                <div class="form-group col">
                    <label for="notabeli" class="col col-form-label">Nota</label>
                            <div class="input-group">
                                <select name="no_nota" id="no_nota" class="form-control">
                                        <?php foreach ($nota_beli as $m) : ?>                                                                         
                                        
                                            <option value="<?=$m['no_nota']?>"><?=$m['no_nota']?></option>                                
                                        <?php endforeach; ?>
                                    </select>

                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                            <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>                    
                </div>
                </form>

                
            </div>
            <div class="col">
                    <p class="font-weight-bold mb-0">Total Penjualan : <?= rupiah($total_jual['total']) ?></p>
                    <p class="font-weight-bold mb-0">Total Laba  : <?= rupiah($total_laba['laba']) ?> </p>                
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>

                        <th scope="col">No</th>
                        <th style="width: 20%; font-size: 15px;">Tanggal Nota</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Harga Jual</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Total</th>
                        <th scope="col">Laba</th>
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
                        <td><?= $sm['tgl_nota']; ?></td>
                        <td><?= $sm['nm_barang']; ?></td>
                        <td><?= $sm['harga_jual']; ?></td>
                        <td><?= $sm['jumlah']; ?></td>
                        <td><?= $total = $sm['jumlah'] * $sm['harga_jual'];  ?></td>
                        <td><?= $sm['laba']; ?></td>
                    </tr>
                    <?php ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

        <?php 
            function rupiah($angka){
        
                $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                return $hasil_rupiah;
            }        
            ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
