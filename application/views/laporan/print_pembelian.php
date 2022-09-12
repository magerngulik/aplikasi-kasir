<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
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
        <h2 style="font-family: sans-serif">Laporan Pembelian</h2>
    </center>
    <h4><?= "Pekanbaru,", date('d-M-Y');  ?></h4>
    <table style="margin: auto;" padding>
        <thead style="text-align: center;">
            <tr style="text-align: center; background-color: tomato;">
                <th">Nota Beli</th>
                    <th>Tanggal Masuk</th>
                    <th>Pemasok</th>
                    <th>Jenis</th>
                    <th>Total Bayar</th>
            </tr>
        </thead>

        <?php foreach ($report as $sm) : ?>
            <tr style="text-align: center">
                <td style="background-color: #FFEFD5;"><?= $sm['no_notabeli']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['tgl_masuk']; ?></td>
                <td style="background-color: #FFEFD5;"><?= $sm['nm_supplier']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['jenis']; ?></td>
                <td style="background-color: #FFEFD5;"><?= $total = $sm['jumlah'] * $sm['harga_beli'];  ?></td>
            </tr>
        <?php endforeach; ?>

    </table>


</body>

</html>