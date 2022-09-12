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
                <a href="<?= base_url("laporan/reportPembelian/") ?>" class="btn btn-primary mb-3">Cetak</a>
                <a href="<?= base_url("laporan/alldataPembelian/") ?>" class="btn btn-danger mb-3">All Data</a>
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
                                    <button class="btn btn-primary" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                        <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>                    
                </div>
                </form>

                <form action="" method="post">
                <div class="form-group col">
                    <label for="notabeli" class="col col-form-label">Nota Beli</label>
                            <div class="input-group">
                                <select name="nonota" id="nonota" class="form-control">
                                        <?php foreach ($nota_beli as $m) : ?>                                                                         
                                        
                                            <option value="<?=$m['no_notabeli']?>"><?=$m['no_notabeli']?></option>                                
                                        <?php endforeach; ?>
                                    </select>

                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                            <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>                    
                </div>
                </form>
                <form action="" method="post">                            
                <div class="form-group col">

                    <label for="notabeli" class="col col-form-label">Jenis Pembayaran</label>
                            <div class="input-group">
                                <select name="jns" id="jns" class="form-control">                                                        
                                            <option>Tunai</option>
                                            <option>Kredit</option>                             
                                    </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                            <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>            
                </div>
                </form>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nota Beli</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Pemasok</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Total Bayar</th>
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
                        <td><?= $sm['no_notabeli']; ?></td>
                        <td><?= $sm['tgl_masuk']; ?></td>
                        <td><?= $sm['nm_supplier']; ?></td>
                        <td><?= $sm['nm_barang']; ?></td>
                        <td><?= $total = $sm['jumlah'] * $sm['harga_beli'];  ?></td>
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
