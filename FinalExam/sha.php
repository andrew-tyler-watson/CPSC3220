<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Results!!</title>
</head>
<body>
    



<?php 

    $sha = $_GET['sha'];
    $shaLength = strlen($sha);

    function getPasswordAndHashesAssociativeArray($param){
        $entry = findPassword($param);
        $algorithms = ['sha1', 'sha224', 'sha256'];

        if($entry === "No Results"){
            print('<p>Sorry But we couldn\'t find what you are looking for.</p>');
            return null;
        }
        $values = [];

        $values["Password"] = $entry[0];
        $values[$param] = $entry[1];
        unset($algorithms[$param]);

        foreach($algorithms as &$algorithm){
            $hash = findHash($values["Password"], $algorithm);
            $values[$algorithm] = $hash;
        }

        return $values;
        
    }

    function findPassword($param){
        
        $fileName = $param . "_list.txt";
        $passwordsToSearch = explode("_", str_replace("\r", "", str_replace("\n", "_", file_get_contents($fileName))));

        $output = [];

        foreach($passwordsToSearch as &$entry){
            //split entry to password and hash
            $entryArray = explode(":", $entry);

            if($entryArray[0] == null){
                break;
            }
            //if hash matches what was entered, break out and run subroutine to 
            if($entryArray[1] == $_GET['sha']){
                return $entryArray;
            }

        }

        return "No Results";

        //print_r($passwordsToSearch);
    }

    function findHash($password, $algorithm){
        
        $fileName = $algorithm . "_list.txt";
        $passwordsToSearch = explode("_", str_replace("\r", "", str_replace("\n", "_", file_get_contents($fileName))));

        $output = [];

        foreach($passwordsToSearch as &$entry){
            //split entry to password and hash
            $entryArray = explode(":", $entry);

            //if hash matches what was entered, break out and run subroutine to 
            if($entryArray[0] == $password){
                return $entryArray[1];
            }

        }

        return "No Results";
    }


    function printErrorMessage(){
        print("<h1>Sorry! You have entered a hash value that is not 40, 56, or 64 characters long. Please Try again.</h1>");
    }

    print('<h1>You searched for: </h1>');
    if($shaLength == 40){
       
        print($_GET['sha']);
        $passwordAndHashes = getPasswordAndHashesAssociativeArray("sha1");
    }
    else if($shaLength == 56){
        
        print($_GET['sha']);
        $passwordAndHashes = getPasswordAndHashesAssociativeArray("sha224");
    }
    else if($shaLength == 64){
        
        print($_GET['sha']);
        $passwordAndHashes = getPasswordAndHashesAssociativeArray("sha256");
    }
    else{
        printErrorMessage();
        exit(1);
    }

    //print_r($passwordAndHashes);

    if($passwordAndHashes != null){
        $keys = array_keys($passwordAndHashes);

        print("<h1>Password and associated hashes</h1>");
        print("<table border='1'>");
    
        print("<tr>");
        foreach($keys as &$key){
            print("<th>" . $key . "</th>");
        }
        print("</tr>");
    
        print("<tr>");
        foreach($passwordAndHashes as &$entry){
            print("<td>");
            print($entry);
            print("</td>");
        }
        print("</tr>");
        
        print("</table>");
    }
?>


<h1>Would you like to search again?</h1>
<form action="sha.php" method="GET" id="shaQuery" enctype="text/plain">
        <div>
             <label for="sha" >Enter sha value: </label>
             <input type="text" id="sha" name="sha" required>
        </div> 
       <button type="submit"> Submit </button>
    </form>

</body>
</html>