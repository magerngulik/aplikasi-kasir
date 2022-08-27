<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6" style="height: 20%;">
            <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('data/tambahPegawai') ?>" class="btn btn-primary mb-3" >Tambah Data</a>
            <div class="sctbl">
            <table class="table table-small scd">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Pegawai</th>
                        <th scope="col">Nama Pegawai</th>
                        <th scope="col">role_id</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($datauser as $sm) : ?>
                    <tr>
                        <?php if($sm['id'] ==12):?>
                            <?php continue;?>
                        <?php endif;?>
                        <!-- idpegawai nm_pegawai level password -->
                        <!-- id name email image password role_id is_active date_created id_pegawai -->
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $sm['id_pegawai']; ?></td>
                        <td><?= $sm['name']; ?></td>
                        <?php  foreach ($role as $m) : ?>    
                            <?php if($sm['role_id'] == $m['id']):?>
                            <td><?=$m['role']?></td>                    
                            <?php endif;?>
                        <?php endforeach; ?>

                        <td>
                            <a href="<?= base_url('data/editPegawai/').$sm['id']; ?>" class="badge badge-success">edit</a>
                            <a href="<?= base_url('data/hapusPegawai/').$sm['id']; ?>" onclick="return confirm('Apakah anda ingin menghapus data ini?');" class="badge badge-danger">Delete</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>

        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

