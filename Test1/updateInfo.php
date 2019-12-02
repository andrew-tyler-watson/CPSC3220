<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <link rel='stylesheet' type='text/css' href='table.css'>
</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <script src="" async defer></script>



    <?php
    $firstName = $_GET['firstName'];
    $lastName = $_GET['lastName'];
    $phoneNumber = $_GET['phoneNumber'];
    $emailAddress = $_GET['emailAddress'];
    $fileName = "userInfo.txt";

    function validateEmail($emailAddress)
    {
        if(strlen($emailAddress) > 30 || strlen($emailAddress) < 6){
            print("<p>Error!! email address must conform to \"___@__.com\"</p>");
            exit();
        }
        $end = substr($emailAddress, -4);
        $atIndex = strpos($emailAddress, '@');
        $name = substr($emailAddress, 0, $atIndex);
        $domain = substr($emailAddress, $atIndex + 1, -4);
        if(ctype_alnum($name) == false){
            
                print("<p>Error!! email address name must be alphanumeric</p>");
                exit();
            
        }
        if(ctype_alpha($domain) == false){
            
                print("<p>Error!! email address domain must contain only letters</p>");
                exit();
            
        }
        if(strcmp($end, ".com") != 0 && strcmp($end, ".edu") != 0){
            print("<p>Error!! email address must conform to \"___@__.com (or .edu)\"</p>");
            exit();
        }
    }
    function validateName($firstName, $lastName)
    {
        if (ctype_alpha($firstName) == false || ctype_alpha($lastName)==false) {
            print("<p>Error!! lastname and firstname must be letters only.</p>");
            exit();
        }
        if (strlen($firstName) == 0 || strlen($lastName) == 0) {
            print("<p>Error!! lastname and firstname must be specified.</p>");
            exit();
        }
        if (strlen($lastName) > 20 || strlen($firstName) > 20) {
            print("<p>Error!! lastname, firstname must be less than 20 characters</p>");
            exit();
        }
    }

    function validatePhoneNumber($phoneNumber)
    {
        if(strlen($phoneNumber) != 12){
            print("<p>Error!! Phone Number should be of form xxx-xxx-xxxx where x is a number 0-9</p>");
            exit();
        }
        $numbersOnly = str_replace("-", "", $phoneNumber);
        if (ctype_digit($numbersOnly) == false) {
            print("<p>Error!! Phone Number should be of form xxx-xxx-xxxx where x is a number 0-9</p>");
            exit();
        }
        $phoneArray = str_split($phoneNumber);
        if (strcmp(($phoneArray[3] . $phoneArray[7]), "--") != 0) {
            print("<p>Error!! Phone Number should be of form xxx-xxx-xxxx where x is a number 0-9</p>" );
            exit();
        }
    }

    function fileToAssociativeArray($fileName)
    {
        $output = array();
        $records = explode("\n", file_get_contents($fileName), -1);
        for ($i = 0; $i < count($records); $i += 1) {
            $recordParsed = explode(":", $records[$i]);
            $output[$recordParsed[0]] = [$recordParsed[1], $recordParsed[2], $recordParsed[3]];
        }
        return $output;
    }

    function associativeArrayToFile($array, $fileName)
    {
        file_put_contents($fileName, "");

        $file = fopen($fileName, 'a');
        foreach ($array as $key => $value) {
            $recordString = $key . ":" . $value[0] . ":" . $value[1] . ":" . $value[2] . "\n";
            fwrite($file, $recordString);
        }
        fclose($file);
    }

    validateEmail($emailAddress);
    validateName($firstName, $lastName);
    validatePhoneNumber($phoneNumber);

    $records = fileToAssociativeArray($fileName);
    $records[$lastName] = [$firstName, $phoneNumber, $emailAddress];

    ksort($records);
    associativeArrayToFile($records, $fileName);

    print("<table> ");

    //print headers
    print("<tr> <th> Last Name</th><th>First Name</th><th>Phone #</th><th>Email Address</th></tr>");
    foreach ($records as $key => $value) {
        print("<tr>");
        print("<td>" . $key . "</td>");

        for ($i = 0; $i < count($value); $i += 1) {
            print("<td>" . $value[$i] . "</td>");
        }

        print("</tr>");
    }
    print("<tr>");

    print("</tr>");
    print("</table>");



    ?>

    <a href="userInfo.html">Go Back!</a>


</body>

</html>