<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table CSV</title>
    <style type="text/css">
        .headings {
     background: grey;
        }

        .data {
            background: whitesmoke;
        }
    </style>
</head>

<body>

    <header>Quotes from CSV data</header>
 </br>
    <section class="tableCSV">
        <table>
            <thead>
                <td class="headings">quote</td>
                <td class="headings">source</td>
                <td class="headings">dob-dod</td>
                <td class="headings">wplink</td>
                <td class="headings">category</td>
            </thead>
            <?php
            $file = fopen("quotes.csv", "r");
            if ($file !== false) {
                fgetcsv($file, 1000, "|");
            }
            while (!feof($file)) {
                $data = fgetcsv($file, 1000, "|");
                if (!empty($data)) {
                    ?>
                    <tr>
                        <td class="data">
                            <?php echo $data[0]; ?>
                        </td>
                        <td class="data">
                            <?php echo $data[1]; ?>
                        </td>
                        <td class="data">
                            <?php echo $data[2]; ?>
                        </td>
                        <td class="data">
                            <a href=<?php echo $data[3]; ?> target="_blank"> <?php echo $data[3]; ?> </a>
                        </td>
                        <td class="data">
                            <img src=<?php echo $data[4]; ?> width=120px height="150px">
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </section>
</body>

</html>