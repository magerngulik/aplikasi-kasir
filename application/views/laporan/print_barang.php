<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Graha Bangunan</title>

    <style>
         th {
            background-color: #1e90ff;
            color: white;
            font-size: 15px;
            text-align: center;
            font-weight: 600
            }
         td{
            font-size: 15px;
            text-transform: lowercase;
            text-align: center;
            font-weight: 600
         }   
    </style>

</head>
<body>

    <h4 style="text-align:center; padding: 0px; margin: 0px;" >STOK BARANG</h4>
    <h4 style="text-align:center; padding: 0px; margin: 0px" >GRAHA BANGUNAN</h4>
    <br>
    <table border="1" cellpadding="10" cellspacing="0" style=" width: 100%; ">
           
                <thead>
                    <tr>
            
                        <th style="width: 10%; font-size: 15px;">ID Barang</th>
                        <th style="text-transform: capitalize;">Nama Barang</th>
                        <th >Harga Beli</th>
                        <th >Harga Jual</th>
                        <th >Stok</th>
                        <th style="text-transform: capitalize;">Kategori</th>
                    </tr>
                </thead>           
                    <?php $i = 1; ?>
                    <?php foreach ($report as $sm) : ?>
                    <tr> 
                   
                        <td><?= $sm['idbarang']; ?></td>
                        <td><?= $sm['nm_barang']; ?></td>
                        <td><?= $sm['hrg_modal']; ?></td>
                        <td><?= $sm['hrg_satuan']; ?></td>
                        <td><?= $sm['stok']; ?></td>
                        <td><?= $sm['nm_kategori']; ?></td>

                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
            
            </table>


</body>
</html>