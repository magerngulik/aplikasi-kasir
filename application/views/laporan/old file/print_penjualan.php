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

    <h4 style="text-align:center; padding: 0px; margin: 0px;" >DAFTAR PENJUALAN</h4>
    <h4 style="text-align:center; padding: 0px; margin: 0px" >GRAHA BANGUNAN</h4>
    <br>
    <table border="1" cellpadding="10" cellspacing="0" style=" width: 100%; ">
           
                <thead>
                    <tr>
                        <th style="width: 20%; font-size: 15px;">Tgl Nota</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Harga Jual</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        <th scope="col">Laba</th>
                    </tr>
                </thead>           
        
                    <?php $gtotal =0?>
                    <?php $glaba =0?>
                    <?php foreach ($report as $sm) : ?>
                    <tr>        
                        <td><?= $sm['tgl_nota']; ?></td>
                        <td><?= $sm['nm_barang']; ?></td>
                        <td><?= $sm['harga_jual']; ?></td>
                        <td><?= $sm['jumlah']; ?></td>
                        <td><?= $total = $sm['jumlah'] * $sm['harga_jual'];  ?></td>
                        <td><?= $sm['laba']; ?></td>

                        <?php $gtotal = $gtotal + $total;
                              $glaba = $glaba + $sm['laba'];
                        ?>
                    </tr>
                    <?php endforeach; ?>
            
            </table>
            <table border="0">
                <tr>
                    <td>----------------------------</td>
                </tr>
                <tr>
                    <td style="width: 40%;">Total Penjualan</td>
                    <td> : </td>
                    <td><?= "Rp. ", $gtotal; ?></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Total Laba</td>
                    <td> : </td>
                    <td><?= "Rp. ", $glaba, " ,-"; ?></td>
                </tr>
                <tr>
                    <td>----------------------------</td>
                </tr>
            </table>


</body>
</html>