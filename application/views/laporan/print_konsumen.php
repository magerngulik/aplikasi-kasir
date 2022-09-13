<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Konsumen</title>
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
                <th>ID Konsumen</th>
                <th>Nama Konsumen</th>
                <th>Alamat</th>
                <th>No Telpon</th>
            </tr>
        </thead>

        <?php foreach ($report as $sm) : ?>
            <tr style="text-align: center">
                <td style="background-color: #FFEFD5;"><?= $sm['idpelanggan']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['nm_konsumen']; ?></td>
                <td style="background-color: #FFEFD5;"><?= $sm['alamat']; ?></td>
                <td style="background-color: #FFDAB9;"><?= $sm['no_telp']; ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
    </center>
</body>

</html>