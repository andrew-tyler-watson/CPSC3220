<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>arrayDemo</title>
        <style> 
            table td{
                margin: 10;
                border: 1px solid black;
            }
        </style>
    </head>
    <body>

<?php 

    $rows = $_GET['rows'];
    $columns = $_GET['columns'];
    $min = $_GET['min'];
    $max = $_GET['max'];
    $numbers = array();

    //Fill in a 2 dimensional array with random numbers
    for($j = 0; $j<$rows; $j++){
        $nextRow = array();
        $numbers[$j] = $nextRow;
        for($k = 0; $k<$columns; $k++){
            $ran = random_int($min, $max);
            $numbers[$j][$k] = $ran;
        }
        
    }
    for($j = 0; $j<$rows; $j++){
        $nextRow = array();
        $numbers[$j] = $nextRow;
        for($k = 0; $k<$columns; $k++){
            $numbers[$j][$k] = random_int($min, $max);
        }
        
    }


    print("<table>");
    for($j = 0; $j<$rows; $j++){
        print('<tr>');
        for($k = 0; $k<$columns; $k++){
            print('<td>' . $numbers[$j][$k] . '</td>');
        }
        print('</tr> <br/>');
    }
    print("</table>");

?>

</body>
