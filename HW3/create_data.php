<!DOCTYPE html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title></title>
    <meta name='description' content=''>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='table.css'>
</head>

<body>
    <?php

    // Grab basic arrayss
    $first_names = explode(",", trim(file_get_contents("first_names.csv")));
    $last_names = explode(":", str_replace("\n", ":", file_get_contents("last_names.txt")), -1);
    $street_types = explode("..;", trim(file_get_contents("street_types.txt")));
    $street_names = explode(":", str_replace("\r", "", str_replace("\n", ":", file_get_contents("street_names.txt"))), -1);
    $domains_full_split = explode(".", trim(file_get_contents("domains.txt")));



    //recombine domains
    $domains_joined = [];

    for ($i = 0; $i < count($domains_full_split); $i += 2) {
        array_push($domains_joined, $domains_full_split[$i] . "." . $domains_full_split[$i + 1]);
    }

    $data = array($first_names, $last_names,$street_names, $street_types, $domains_joined);

    //A bunch of functions for making unique entries in our table
    function GetUniqueNameCombination($nameEntries, $first_names, $last_names){
        $nameCombo = [];
        while(true){
            $firstNameIndex = random_int(0, count($first_names)-1);
            $lastNameIndex = random_int(0, count($last_names)-1);
            $concatenatedName = $first_names[$firstNameIndex] . "." . $last_names[$lastNameIndex];
            if(!in_array($concatenatedName, $nameEntries)){
                break;
            }
        }
        return trim($concatenatedName);
    }
    function GetUniqueStreetCombination($streetEntries, $street_names, $street_types){
        $nameCombo = [];
        while(true){
            $streetNameIndex = random_int(0, count($street_names)-1);
            $streetTypeIndex = random_int(0, count($street_types)-1);
            $concatenatedName = $street_names[$streetNameIndex] . " " . $street_types[$streetTypeIndex];
            if(!in_array($concatenatedName, $streetEntries)){
                break;
            }
        }
        $randomStreetNumber = random_int(0, 10000);
        return $randomStreetNumber . " " . trim($concatenatedName);
    }

    function GetRandomDomain($domains){
        return $domains[random_int(0, count($domains) - 1)];
    }

    print("<h2>First Names</h2>");
    print("<pre>");
    print_r($first_names);
    print("</pre>");

    print("<h2>Last Names</h2>");
    print("<pre>");
    print_r($last_names);
    print("</pre>");

    print("<h2>Street Names</h2>");
    print("<pre>");
    print_r($street_names);
    print("</pre>");

    print("<h2>Street Types</h2>");
    print("<pre>");
    print_r($street_types);
    print("</pre>");

    print("<h2>Domains</h2>");
    print("<pre>");
    print_r($domains_joined);
    print("</pre>");

    print("<table> ");

    //print headers
    print("<tr> <th>First Name</th><th>Last Name</th><th>Address</th><th>Email Address</th></tr>");

    $nameEntries = array();
    $streetEntries = array();

    $output = fopen("customers.txt", "wb");
    for ($j = 0; $j < 25; $j++) {
        $currentName = GetUniqueNameCombination($nameEntries, $first_names, $last_names);
        $currentAddress = GetUniqueStreetCombination($streetEntries, $street_names, $street_types);

        array_push($nameEntries, $currentName);
        array_push($streetEntries, $currentAddress);

        $firstNameLastName = explode(".", $currentName);
        $firstName = $firstNameLastName[0];
        $lastName = $firstNameLastName[1];
        $emailAddress = $currentName . "@" . GetRandomDomain($domains_joined);
        $record = $firstName . ":" . $lastName . ":" . $currentAddress . ":" . $emailAddress . "\n";

        fwrite($output, $record);

        print("<tr>");
            print("<td>");
                print($firstName);
            print("</td>");
            print("<td>");
                print($lastName);
            print("</td>");
            print("<td>");
                print($currentAddress);
            print("</td>");
            print("<td>");
                print($emailAddress);
            print("</td>");
        print("</tr>");
    }

    print("</table>");

    ?>
</body>
</html>