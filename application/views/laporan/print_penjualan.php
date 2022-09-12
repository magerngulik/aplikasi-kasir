<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        th,
        td,
        tr {
            padding-right: 15px;
            padding-left: 15px;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <center>
        <h2 style="font-family: sans-serif">Laporan Konsumen</h2>
    </center>
    <h4><?= "Pekanbaru,", date('d-M-Y');  ?></h4>
    <table>
        <thead style="text-align: center;">
            <tr style="text-align: center; background-color: tomato;">
                <th>Tgl Nota</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Laba</th>
            </tr>
        </thead>

        <?php $gtotal = 0 ?>
        <?php $glaba = 0 ?>
        <?php foreach ($report as $sm) : ?>
            <tr style="text-align: center">
                <td style="background-color: #FFEFD5;"><?= $sm['tgl_nota']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['nm_barang']; ?></td>
                <td style="background-color: #FFEFD5;"><?= $sm['harga_jual']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['jumlah']; ?></td>
                <td style="background-color: #FFEFD5;"><?= $total = $sm['jumlah'] * $sm['harga_jual'];  ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['laba']; ?></td>

                <?php $gtotal = $gtotal + $total;
                $glaba = $glaba + $sm['laba'];
                ?>
            </tr>
        <?php endforeach; ?>

    </table>
    <table border="0">
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
    </table>


</body>

</html>