<!-- Begin Page Content -->
<div class="container-fluid">

    
<!-- no_pembelian no_notabeli idpegawai idsupplier jenis tgl_masuk catatan -->

    <h1 class="h3 text-gray-800"><?= $title; ?></h1>
    <div class="row mx-auto">
         <!-- Awal -->     
         <div class="col-lg-7"> 
            
      
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
                                <input type="text" class="form-control" placeholder="Masukan Keyword Pencarian" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword" autocomplete="off" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="submit" name= "submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <a class="btn btn-danger" href="<?= base_url('transaksi/alldataJual/')?>"> All Data</a>
                    </div>
                    <div class="col ml-auto">             
                    <?=  $this->pagination->create_links();?>
                    </div>
                </div>   
                </div>
            </div>  
            <?= $this->session->flashdata('message'); ?> 

            <table class="table table-hover lg-6">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Stok</th>                     
                        <th scope="col">Harga Jual</th>                     
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
                        <td><?= $sm['stok']; ?></td>                 
                        <td><?= $sm['hrg_modal']; ?></td>                 
                        <td>
                            <a href="<?= base_url('transaksi/iddatapenjualan/').$sm['idbarang']; ?>" class="btn btn-primary">Pilih</a>                 
                        </td>
                    </tr>
                    <?php ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
           
            <form action="" method="post">
        </div>
        <!-- tabel data nota -->       
        <div class="col-lg-4 ml-5 mb-3">
            <h1 class="h3 text-gray-800">Keterangan Nota Penjualan</h1>
                <form action="" method="post">
                          
                <!-- no_nota	tgl_nota jml_bayar	idpegawai	idpelanggan -->
                <input type="hidden" name="no_nota" id="no_nota" value="<?= $nota_jual['no_nota']; ?>">
                <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?= $user['id_pegawai']; ?>">
                <?= $this->session->flashdata('name'); ?>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">No Nota</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="no_nota" name="no_nota" value="<?= $nota_jual['no_nota']; ?>" readonly>
                        <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Nama Pelangan</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="no_nota" name="no_nota" value="<?= $nota_jual['nm_konsumen']; ?>" readonly>
                        <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

       
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Tanggal Masuk</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="tgl_nota" name="tgl_nota" value="<?= $nota_jual['tgl_nota']; ?>" readonly>
                        <?= form_error('no_nota', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
            </form> 

        </div>
        <!-- akhir nota -->
    </div>

    <!-- btn hitung -->
    <div class="row">
        <div class="col">
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Jumlah Bayar" name="bayar" autocomplete="off" autofocus>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-primary btn-lg" style="width: 100%;" type="submit" name= "submit">Hitung</button>
                </div>
            </form>
        </div>                    
    </div>
    

                        


    <div class="row mt-5">
     <div class="col-lg mx-auto">
        <table class="table table-bordered">
            <thead>
                <tr>
                    
                <th scope="col">No</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if(empty($cart)):?>
                    <tr>
                        <td colspan ="7">
                        <div class="alert alert-success" role="alert">   
                                Belum ada data transaksi
                            </div>
                        </td>
                    </tr>
                    <?php endif?> 
                    <?php $i = 1;
                    $total =0;
                    $countTotal=0;
                    ?>
                    <?php foreach ($cart as $sm) : ?>
                    <tr>                        
                    <th scope="row"><?=$i?></th>
                        <td><?= $sm['nm_barang']; ?></td>
                        <td><?= $sm['harga_jual']; ?></td>
                        <td><?= $sm['jumlah']; ?></td>
                        <td><?= $total = $sm['harga_jual'] * $sm['jumlah'] ?></td>
                        <td>
                            <a href="<?= base_url('transaksi/hapusCardPenjualan/').$sm['rowid']; ?>" onclick="return confirm('Apakah anda ingin menghapus data ini?');" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                        <?php 
                        $countTotal = $countTotal + $total;                       
                        ?>
                    <?php $i++?>
                    <?php endforeach; ?>
                    <!-- bawah -->
                    <tr>
                        <td class="font-weight-bold" colspan="4">Total Penjualan</td>
                        <td colspan="3"><?=rupiah($countTotal)?> </td>
                    </tr>
                    <tr>
                        <?php $kembalian = $this->input->post('bayar')?>
                        <td class="font-weight-bold" colspan="4">Dibayarkan</td>
                        <td colspan="3"><?=rupiah($kembalian)?> </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold" colspan="4">Kembalian</td>
                        <td colspan="3"><?=rupiah($kembalian - $countTotal)?> </td>
                    </tr>
            </tbody>  
            
            

            <?php 
            function rupiah($angka){  
                $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                return $hasil_rupiah;
            }        
            ?>
            </table>                                                
        </div>    
    </div>   
    <div class="row ">
    <div class="col"><a href="<?= base_url('transaksi/simpanPenjualan') ?>" class="btn btn-primary btn-lg" type="button" style="width: 100%;">SIMPAN</a></div>
			<div class="col"> <a href="<?= base_url('transaksi/hapusNotaPenjualan/') ?>" class="btn btn-warning btn-lg" style="width: 100%;">KEMBALI</a></div>
    </div>        

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 