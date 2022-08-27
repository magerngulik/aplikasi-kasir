<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
    <div class="col-lg" style="height: 20%;">
            <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>
            <?php $total?>    
            <?php $nilaitotal=0?>    

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal" style="display:none">Tambah Data</a>
            <div class="sctbl">
            <table class="table table-dark scd">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Id</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($this->cart->contents() as  $sm) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $sm['id']?></td>
                        <td><?= $sm['qty']?></td>
                        <td><?= $sm['price']?></td>
                        <?php $total = $sm['price'] * $sm['qty'] ?> 
                        <td> <?=$total?> </td>
                    </tr>
                    
                    <?php  $nilaitotal = $nilaitotal + $total;?>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                    <td>
                        <a>Total Pembelian</a>
                            <?=$nilaitotal?>
                    </div>  
                    </td>
                </tbody>
            </table>
                        
        </div>
        <div class="col-lg" style="height: 20%;">
        <div class="row">
                      
                        
        </div>
        
        </div>






        <div class="col-lg-6" style="height: 20%;">
            <div class="sctbl">
            <br>
            <br>
            
                <table class="table table-small scd">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($barang as $sm) : ?>
                        <tr>

                            <th scope="row"><?= $i; ?></th>
                            <td><?= $sm['nm_barang']?></td>   
                            <td><?= $sm['hrg_modal']?></td>   

                            <td>    <td>
                            <a href="<?=$sm['idbarang']?>" class="badge badge-success">edit</a>
                            
                        </td></td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            

        </div>
                        
    
    
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
