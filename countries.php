<?php
require_once "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //checking for duplication
    $rowCount = table_Countries ('check', NULL, NULL);

    if ($rowCount == 0) {
        table_Countries ('insert', NULL, NULL);
    }
    else {
        $error = 'Duplicate Entry!';
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Countries";
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
                <!-- countries form -->
                <div class="countries form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Country Code:
                                <input type="text" name="Code" id="Code" size="2" maxlength="2">
                            </li>
                            <li>
                                Country:
                                <input type="text" name="Country" id="Country" placeholder="Country Name" required>
                            </li>
                            <li>
                                Region:
                                <input type="text" name="Region" id="Region" placeholder="Region" >
                            </li>
                            <li class="error">
                                <?php 
                                if (!empty($error)) {
                                    echo $error;
                                }   
                                ?>                             
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Code', 'Country', 'Region');">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of countries form -->
                <!-- report table -->
                <div class="report table">
                    <table>
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Country</th>
                                <th>Region</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //getting data from the table Countries
                            $rows_Countries = table_Countries('select_all', NULL, NULL);
                            foreach ($rows_Countries as $row_Countries) {
                                echo "<tr>";
                                echo "<td>".$row_Countries->Code."</td>";
                                echo "<td>".$row_Countries->Country."</td>";
                                echo "<td>".$row_Countries->Region."</td>";
                                echo "<td><a href=\"edit_countries.php?CountriesId=$row_Countries->Id\">Edit</a></td>";
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
