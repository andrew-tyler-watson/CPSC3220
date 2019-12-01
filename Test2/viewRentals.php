<?php

$db = new mysqli("127.0.0.1", "andrew", "9072752a", "sakila", "3306");
if($db->connect_error) {
    exit('Error connecting to database'); //Should be a message a typical user could understand in production
}


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db->set_charset("utf8mb4");
$statement = $db->prepare("SELECT c.first_name as firstName, c.last_name as lastName, f.title as Title,
                                    i.inventory_id as InventoryNumber, r.rental_date as RentalDate, r.return_date as ReturnDate
                            FROM rental as r
                                INNER JOIN customer c on r.customer_id = c.customer_id
                                INNER JOIN inventory i on r.inventory_id = i.inventory_id
                                INNER JOIN film f on i.film_id = f.film_id
                            ORDER BY c.last_name");
// $statement->bind_param("ssiiididss", $_GET['title'], $_GET['description'], $_GET['release_year'], 
//                                      $_GET['language_id'], $_GET['rental_duration'], $_GET['rental_rate'], 
//                                      $_GET['length'], $_GET['replacement_cost'], $_GET['rating'], $_GET['special_feature']);

// try {
//     $statement->execute();
//     print("Success!!");
// } catch (Exception $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "\n";
//     print("<p>Please try harder.</p>");
// }

$statement->execute();
$films = $statement->get_result();

print("<h1>Table of Rentals</h1>");
print("<table border='1'>");
print("<tr>
            <th>First Name</th><th>Last Name</th>
            <th>Title</th><th>Inventory Number</th>
            <th>Rental Date</th><th>Return Date</th>
        </tr>");

        while($row = $films->fetch_assoc()) {
            print("<tr>");
            print ("<td>".$row['firstName']."</td>");
            print("<td>".$row['lastName']."</td>");
            print ("<td>".$row['Title']."</td>");
            print("<td>".$row['InventoryNumber']."</td>");
            print ("<td>".$row['RentalDate']."</td>");
            print ("<td>".$row['ReturnDate']."</td>");
            print("</tr>");
        }

print("</table>");

print("<form action=\"tasks.html\">
<button type=\"submit\">Tasks</button>
</form>");
?>