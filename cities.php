<?php
require_once "functions.php";

//getting data from the table Coutries
$rows_Countries = table_Countries('select_all', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking for duplicate entry
    $rowCount = table_Cities ('check', NULL, NULL);

    if ($rowCount == 0) {
        table_Cities ('insert', NULL, NULL);
    }
    else {
        $error = 'Duplicate Entry!';
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Cities";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/nav.html";
            include "includes/header.html";
            ?>
            <main>
                <!-- cities form -->
                <div class="cities form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Airport Code:
                                <input type="text" name="AirportCode" id="AirportCode" size="3" maxlength="3">
                            </li>
                            <li>
                                City:
                                <input type="text" name="City" id="City" placeholder="City">
                            </li>
                            <li>
                                Country:
                                <select name="CountryCode" id="CountryCode">
                                    <option>Select One</option>
                                    <?php
                                    foreach ($rows_Countries as $row_Countries) {
                                        echo "<option value=\"$row_Countries->Code\">".$row_Countries->Country."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li class="error">
                                <?php 
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </li>
                            <li>
                                <button type="submit" class="button submit" id="buttonSubmit" name="buttonSubmit" 
                                onclick="checkThreeFields('AirportCode', 'City', 'CountryCode');">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of cities form -->
                <!-- report table -->
                <div class="report table">
                    <table>
                        <thead>
                            <tr>
                                <th>Airport Code</th>
                                <th>City Name</th>
                                <th>Country</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // getting data from the table Cities
                            $rows_Cities = table_Cities ('select_all', NULL, NULL);
                            foreach ($rows_Cities as $row_Cities) {
                                echo "<tr>";
                                echo "<td>".$row_Cities->AirportCode."</td>";
                                echo "<td>".$row_Cities->City."</td>";
                                echo "<td>".$row_Cities->Country."</td>";
                                echo "<td><a href=\"edit_cities.php?CitiesId=$row_Cities->Id\">Edit</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of report table -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
