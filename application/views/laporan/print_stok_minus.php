<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Stok Minus</title>
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
    <center>
    <table>
        <thead style="text-align: center;">
            <tr style="text-align: center; background-color: tomato;">
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($report as $sm) : ?>
            <tr>
                <td style="background-color: #FFEFD5;"><?= $sm['idbarang']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['nm_barang']; ?></td>
                <td style="background-color: #FFEFD5;"><?= $sm['hrg_modal']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['hrg_satuan']; ?></td>
                <td style="background-color: #FFEFD5;"><?= $sm['stok']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['nm_kategori']; ?></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>

    </table>
        </center>


</body>

</html>