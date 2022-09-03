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
                <div class="col ml-auto">             
                <?=  $this->pagination->create_links();?>
                </div>
            </div>     

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nota Beli</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Pemasok</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Total Bayar</th>
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
                        <td><?= $sm['no_notabeli']; ?></td>
                        <td><?= $sm['tgl_masuk']; ?></td>
                        <td><?= $sm['nm_supplier']; ?></td>
                        <td><?= $sm['jenis']; ?></td>
                        <td><?= $total = $sm['jumlah'] * $sm['harga_beli'];  ?></td>
                                          
                        <td>
                            <a href="<?= base_url('data/hapusDataBarang/').$sm['no_notabeli']; ?>" onclick="return confirm('Apakah anda ingin menghapus data ini?');" class="btn btn-danger">Delete</a>
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
