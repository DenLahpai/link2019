<?php
require_once "functions.php";

//getting data from the table corporates
$rows_Corporates = table_Corporates ('select_all', NULL, NULL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Corporates ('check', NULL, NULL);

    if ($rowCount == 0) {
        table_Corporates ('insert', NULL, NULL);
    }
    else {
        $error = 'Duplicate Entry!';
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Corporates";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- corporates form -->
                <div class="corporates form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Corporate Name:
                                <input type="text" name="Name" id="Name" placeholder="Corporate Name">
                            </li>
                            <li>
                                Chain:
                                <input type="text" name="Chain" id="Chain" placeholder="Chain Name">
                            </li>
                            <li>
                                Type:
                                <input type="text" name="Type" id="Type" placeholder="NGO or Company">
                            </li>
                            <li>
                                Country:
                                <select id="CountryCode" name="CountryCode">
                                    <option value="">Select One</option>
                                    <?php
                                    //getting data from the table Countries
                                    $rows_Countries = table_Countries ('select_all', NULL, NULL);
                                    foreach ($rows_Countries as $row_Countries) {
                                        echo "<option value=\"$row_Countries->Code\">".$row_Countries->Country."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Email:
                                <input type="email" name="Email" id="Email" placeholder="Email@email.com">
                            </li>
                            <li>
                                Website:
                                <input type="text" name="Website" id="Website" placeholder="www.website.com">
                            </li>
                            <li class="error">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Name', 'CountryCode', 'Type');">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of corporates form -->
                <!-- report table -->
                <div class="report table">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Chain</th>
                                <th>Type</th>
                                <th>Country</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //getting data from the table Corporates
                            $rows_Corporates = table_Corporates ('select_all', NULL, NULL);
                            foreach ($rows_Corporates as $row_Corporates) {
                                echo "<tr>";
                                echo "<td>".$row_Corporates->Name."</td>";
                                echo "<td>".$row_Corporates->Chain."</td>";
                                echo "<td>".$row_Corporates->Type."</td>";
                                echo "<td>".$row_Corporates->Country."</td>";
                                echo "<td>".$row_Corporates->Email."</td>";
                                echo "<td>".$row_Corporates->Website."</td>";
                                echo "<td><a href=\"edit_corporates.php?CorporatesId=$row_Corporates->Id\">Edit</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of report table -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
