<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>arrayDemo</title>
    <style>
        table td {
            margin: 10;
            border: 1px solid black;
        }

        #sideHeader {
            margin: 10;
            border: 0px solid transparent;
        }

        #corner {
            margin: 10;
            background: black;
        }

        #hangingIndent {
            background: white;
            border: 0px solid transparent;
        }
    </style>
</head>

<body>

    <?php

    function Sum($row)
    {
        return array_sum($row);
    }

    function Average($row)
    {
        $i = 0;
        $total = 0;
        foreach ($row as $k) {
            $i++;
            $total += $k;
        }
        return number_format($total / $k, 3);
    }

    function StandardDeviation($row)
    {
        return number_format(sqrt(array_sum($row) / count($row)), 3);
    }

    $rows = $_GET['rows'];
    $columns = $_GET['columns'];
    $min = $_GET['min'];
    $max = $_GET['max'];
    $numbers = array();

    //Fill in a 2 dimensional array with random numbers
    for ($j = 0; $j < $rows; $j++) {
        $nextRow = array();
        $numbers[$j] = $nextRow;
        for ($k = 0; $k < $columns; $k++) {
            $ran = random_int($min, $max);
            $numbers[$j][$k] = $ran;
        }
    }
    for ($j = 0; $j < $rows; $j++) {
        $nextRow = array();
        $numbers[$j] = $nextRow;
        for ($k = 0; $k < $columns; $k++) {
            $numbers[$j][$k] = random_int($min, $max);
        }
    }


    print("<table>");
    print('<th id="corner"></th>');
    for ($j = 0; $j < $columns; $j++) {
        print('<th>Column ' . $j . '</th>');
    }
    for ($j = 0; $j < $rows; $j++) {
        print('<tr> <td id=\'sideHeader\'>Row ' . $j . ' </td>');
        for ($k = 0; $k < $columns; $k++) {
            print('<td>' . $numbers[$j][$k] . '</td>');
        }
        print('</tr> <br/>');
    }
    print("</table>");

    print("<table>");
    print('<th id="corner"></th>');
    print("
        <th>Sum</th>
        <th>Average</th>
        <th>Standard Deviation</th>
    ");
    for ($j = 0; $j < $rows; $j++) {
        print('<tr> <td id=\'sideHeader\'>Row ' . $j . ' </td>');

        print('<td>' . Sum($numbers[$j]) . '</td>');
        print('<td>' . Average($numbers[$j]) . '</td>');
        print('<td>' . StandardDeviation($numbers[$j]) . '</td>');

        print('</tr> <br/>');
    }
    print("</table>");

    print("<table>");
    print('<th id="corner"></th>');
    for ($j = 0; $j < $columns; $j++) {
        print('<th>Column ' . $j . '</th>');
    }
    for ($j = 0; $j < $rows; $j++) {
        print('<tr> <td id=\'sideHeader\'>Row ' . $j . ' </td>');
        for ($k = 0; $k < $columns; $k++) {
            print('<td>' . $numbers[$j][$k] . '</td>');
        }
        print('</tr> <br/>');
        print('<tr> <td id=\'hangingIndent\'></td>');
        for ($k = 0; $k < $columns; $k++) {
            if ($numbers[$j][$k] < 0) {
                print('<td>Negative</td>');
            } else if ($numbers[$j][$k] == 0) {
                print('<td>Zero</td>');
            } else {
                print('<td>Positive</td>');
            }
        }
        print('</tr> <br/>');
    }
    print("</table>");
    ?>
<a href="arrayDemo.html">Go back!</a>
</body>