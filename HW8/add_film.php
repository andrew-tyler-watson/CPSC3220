<?php 

    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_year = $_POST['release_year'];
    $language_id = $_POST['language_id'];
    $rental_duration = $_POST['rental_duration'];
    $rental_rate = $_POST['rental_rate'];
    $length = $_POST['length'];
    $replacement_cost = $_POST['replacement_cost'];
    $rating = $_POST['rating'];
    $special_feature = $_POST['special_feature'];

    $db = new mysqli("127.0.0.1", "andrew", "9072752a", "sakila", "3306");
    if($db->connect_error) {
        exit('Error connecting to database'); //Should be a message a typical user could understand in production
    }


    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db->set_charset("utf8mb4");
    $statement = $db->prepare("INSERT INTO sakila.film 
                                (
                                    title,
                                    description,
                                    release_year,
                                    language_id,
                                    rental_duration,
                                    rental_rate,
                                    length,
                                    replacement_cost,
                                    rating,
                                    special_features
                                ) 
                                VALUES 
                                (
                                    ?,?,?,?,?,?,?,?,?,?
                                );");
    $statement->bind_param("ssiiididss", $_GET['title'], $_GET['description'], $_GET['release_year'], 
                                         $_GET['language_id'], $_GET['rental_duration'], $_GET['rental_rate'], 
                                         $_GET['length'], $_GET['replacement_cost'], $_GET['rating'], $_GET['special_feature']);
    $statement->execute();
    $customers = $statement->get_result();

    print($response);
    print("<form action=\"manager.html\">
                <button type=\"submit\">Manager</button>
            </form>");

?>