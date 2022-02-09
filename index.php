<?php

echo "<pre>";
$from = $_GET['from'];
$till = $_GET['till'];
$oneDay = [];

if ($from == '' && $till == '') {
    $data = json_decode(file_get_contents(
        "https://data.gov.lv/dati/lv/api/3/action/datastore_search?&resource_id=d499d2f0-b1ea-4ba2-9600-2c701b03bd4a&limit=1000"), true);
    foreach ($data['result']['records'] as $day) {
        $date = explode("T", $day["Datums"])[0];
        $allTests = $day["TestuSkaits"];
        $positiveTests = $day["ApstiprinataCOVID19InfekcijaSkaits"];
        $oneDay[] = [$date, $allTests, $positiveTests];
    }
} else if ($from = $_GET['from'] && $till = $_GET['till']) {
    $data = json_decode(file_get_contents(
        "https://data.gov.lv/dati/lv/api/3/action/datastore_search?&resource_id=d499d2f0-b1ea-4ba2-9600-2c701b03bd4a&limit=1000"), true);
    foreach ($data['result']['records'] as $day) {
        $date = explode("T", $day["Datums"])[0];
        $oneDate = implode('', explode("-", $date));
        $allTests = $day["TestuSkaits"];
        $positiveTests = $day["ApstiprinataCOVID19InfekcijaSkaits"];

        if ($oneDate >= implode('', explode("-", $_GET['from'])) &&
            $oneDate <= implode('', explode("-", $_GET['till']))) {
            $oneDay[] = [$date, $allTests, $positiveTests];
        }
    }
}
?>
<body style="background-color: lightgray;"></body>
<form method="get" action="/"  <label for="start"></label>

START DATE: <input type="date"
                   id="start" name="from"
                   style="font-size: large;"
                   min="2019-01-01"
                   max="2022-02-09"
>   END DATE:  <input type="date" id="end" name="till"
                      style="font-size: large"
                      min="2019-01-01"
>   <button type="submit"
        style="font-size: large"> See results
</button>
<div>
    <head>
        <style>
            table {
                border-collapse: collapse;
                width: 70%;
                margin-left: auto;
                margin-right: auto;
                border: 2px black;
            }

            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: center;
            }

            tr:nth-child(even) {
                background-color: whitesmoke;
            }
            tr:nth-child(odd) {
                background-color:grey;
            }
        </style>


        <table>
            <thead style="
           font-size: large">
            <th>
                Date
            </th>
            <th>
                Total tests
            </th>
            <th>
                Positive tests
            </th>
            </thead>
            <?php foreach ($oneDay as $result) { ?>
            <tr>
                <td>
                    <?php echo $result[0]; ?>
                </td>
                <td>
                    <?php echo $result[1]; ?>
                </td>
                <td>
                    <?php echo $result[2];
                    } ?>
                </td>
            </tr>
        </table>

        <form method="get" action="/">
            <button type="submit" name="back" value="<?php  ?>"> Back
            </button>
        </form>
</div>


<?php //if ($offset >= $limit): ?>
<!--    <button type="submit" name="offset" value="--><?php //echo $offset - $limit; ?><!--"> Previous-->
<!--    </button>-->
<?php //endif; ?>