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
                <a href="<?= base_url("laporan/reportKonsumen/") ?>" class="btn btn-primary mb-3">Cetak</a>
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
                        <th scope="col">ID Konsumen</th>
                        <th scope="col">Nama Konsumen</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">No Telpon</th>
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
                        <td><?= $sm['alamat']; ?></td>
                        <td><?= $sm['no_telp']; ?></td>
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
