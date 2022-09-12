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
            text-transform: capitalize;
            text-align: center;
            font-weight: 600
         }   
    </style>

</head>
<body>

    <h4 style="text-align:center; padding: 0px; margin: 0px;" >DAFTAR PEMBELIAN</h4>
    <h4 style="text-align:center; padding: 0px; margin: 0px" >GRAHA BANGUNAN</h4>
    <br>
    <table border="1" cellpadding="10" cellspacing="0" style=" width: 100%; ">
           
                <thead>
                    <tr>
                        <th style="width: 20%; font-size: 15px;">Nota Beli</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Pemasok</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Total Bayar</th>
                    </tr>
                </thead>           
        
                    <?php foreach ($report as $sm) : ?>
                    <tr>        
                        <td><?= $sm['no_notabeli']; ?></td>
                        <td><?= $sm['tgl_masuk']; ?></td>
                        <td><?= $sm['nm_supplier']; ?></td>
                        <td><?= $sm['jenis']; ?></td>
                        <td><?= $total = $sm['jumlah'] * $sm['harga_beli'];  ?></td>
                    </tr>
                    <?php endforeach; ?>
            
            </table>


</body>
</html>