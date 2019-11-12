<?php 

    function getFilmsPerCustomer($firstName, $lastName, $dbClient){
        $statement = $dbClient->prepare("SELECT DISTINCT(f.title) as title FROM rental
                                            INNER JOIN customer c on rental.customer_id = c.customer_id
                                            INNER JOIN inventory i on rental.inventory_id = i.inventory_id
                                            INNER JOIN film f on i.film_id = f.film_id
                                        WHERE c.last_name = ? AND c.first_name = ?");
        $statement->bind_param("ss", $lastName, $firstName);
        $statement->execute();
        $customerFilms = $statement->get_result();
        if($customerFilms->num_rows === 0) return('No rows');
        $films = '';
        while($row = $customerFilms->fetch_assoc()) {
           $films = $films . $row['title'] . ', ';
        }
        return substr($films, 0, strlen($films)-2);
    }

    /********
     * MAIN *
     ********
     */

    $db = new mysqli("127.0.0.1", "andrew", "9072752a", "sakila", "3306");
    if($db->connect_error) {
        exit('Error connecting to database'); //Should be a message a typical user could understand in production
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db->set_charset("utf8mb4");
    $statement = $db->prepare("SELECT c.last_name as lastName, c.first_name as firstName,
                                        a.address as address, a.district as district, 
                                        city.city as city, country.country as country, a.postal_code as ZIP
                                FROM customer as c
                                INNER JOIN address a on c.address_id = a.address_id
                                INNER JOIN city on a.city_id = city.city_id
                                INNER JOIN country on city.country_id = country.country_id
                                ORDER BY lastName");
    $statement->execute();
    $customers = $statement->get_result();

    print("<h1>Table of Customers</h1>");
    print("<table border='1'>");
    print("<tr>
                <th>First Name</th><th>Last Name</th>
                <th>Address</th><th>City</th>
                <th>District</th><th>ZIP</th>
                <th>Films</th>
            </tr>");

            while($row = $customers->fetch_assoc()) {
                print("<tr>");
                print ("<td>".$row['firstName']."</td>");
                print("<td>".$row['lastName']."</td>");
                print ("<td>".$row['address']."</td>");
                print("<td>".$row['district']."</td>");
                print ("<td>".$row['city']."</td>");
                print ("<td>".$row['ZIP']."</td>");
                $filmsString = getFilmsPerCustomer($row['firstName'], $row['lastName'], $db);
                print ("<td>".$filmsString."</td>");
                print("</tr>");
            }

    print("</table>");


    print("<form action=\"manager.html\">
    <button type=\"submit\">Manager</button>
    </form>");
?>

<!-- "2)	Create the view_customers.php file.  
    This file should generate an html page that c
    ontains a table that lists all of the customers 
    from the sakila database.  You should list the following 
    information about each customer: 
        first_name, last_name, 
        address, city, district, 
        postal_code, and a list of film titles 
        that each customer has rented. 

    This page should have a button that returns you to the manager.html page.  
    The last column in your table will be a string containing all the film titles 
    … you do not need a different cell for each film title because the number of 
    films each customer has rented is not the same.  Use a comma to separate film titles.  
    You can use a concatenation of customer first and last name (last.first) as a key in an associative array.
3)	Your table should be sorted by customer last name. -->

<!-- 4)1)	Create the add_film.html file.  It should have a form with text boxes to input the 
        following information about 
            a new flim: title, description, release_year, 
            language_id, rental_duration, rental_rate, length, 
            replacement_cost, rating, special_features. 
            “rating” should be a drop down box with only the following values: G, PG, PG-13, R, NC-17.  
            “special features” should be a drop down box with only the following values: 
                Trailers, Commentaries, Deleted Scenes, Behind the Scenes.  
            You do not need to do error checking on the input (i.e. verify that cost is a number), 
            but be aware that if you don’t enter the correct data type your query may fail.  
            So use good data for testing.  
            You will need two buttons on this page, save and cancel.  
                The save button will need to insert the employee information into the database as described below 
                    (by linking to a file titled add_film.php), 
                display a message stating whether the query was successful or not, 
                and display button to return to the manager.html page.  
            The cancel button will simply need to return to the manager.html page.
" -->