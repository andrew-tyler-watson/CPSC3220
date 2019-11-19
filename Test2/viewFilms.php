<?php

$db = new mysqli("127.0.0.1", "andrew", "9072752a", "sakila", "3306");
if($db->connect_error) {
    exit('Error connecting to database'); //Should be a message a typical user could understand in production
}


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db->set_charset("utf8mb4");
$statement = $db->prepare("SELECT f.title as Title, f.description as Description,
                                f.rental_duration as RentalDuration, f.rental_rate as RentalRate,
                                f.length as Length, c.name as Category,
                                (SELECT count(*) FROM inventory as i where i.film_id =f.film_id) as InventoryCount
                            FROM film as f
                                INNER JOIN film_category fc on f.film_id = fc.film_id
                                INNER JOIN category c on fc.category_id = c.category_id
                            ORDER BY f.title");
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

print("<h1>Table of Films</h1>");
print("<table border='1'>");
print("<tr>
            <th>Title</th><th>Description</th>
            <th>Rental Duration</th><th>Rental Rate</th>
            <th>Length</th><th>Category</th>
            <th>Inventory Count</th>
        </tr>");

        while($row = $films->fetch_assoc()) {
            print("<tr>");
            print ("<td>".$row['Title']."</td>");
            print("<td>".$row['Description']."</td>");
            print ("<td>".$row['RentalDuration']."</td>");
            print("<td>".$row['RentalRate']."</td>");
            print ("<td>".$row['Length']."</td>");
            print ("<td>".$row['Category']."</td>");
            print ("<td>".$row['InventoryCount']."</td>");
            print("</tr>");
        }

print("</table>");

print("<form action=\"tasks.html\">
<button type=\"submit\">Tasks</button>
</form>");
?>