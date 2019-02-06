<?php
require_once "functions.php";

//getting CitiesId
$CitiesId = trim($_REQUEST['CitiesId']);

//getting data from the table Cities
$rows_Cities = table_Cities ('select_one', $CitiesId, NULL);
foreach ($rows_Cities as $row_Cities) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Cities ('check_before_update', $CitiesId, NULL);

    if ($rowCount == 0) {
        table_Cities ('update', $CitiesId, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Cities";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = $page_title;
            include "includes/header.html";
            ?>
            <main>
                <!-- booking form -->
                <div class="booking form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Airport Code:
                                <input type="text" name="AirportCode" id="AirportCode" value="<? echo $row_Cities->AirportCode; ?>">
                            </li>
                            <li>
                                City:
                                <input type="text" name="City" id="City" value="<? echo $row_Cities->City; ?>">
                            </li>
                            <li>
                                Country:
                                <select id="CountryCode" name="CountryCode">
                                    <?php
                                    $rows_Countries = table_Countries('select_all', NULL, NULL);
                                    foreach ($rows_Countries as $row_Countries) {
                                        if ($row_Countries->Code == $row_Cities->CountryCode) {
                                            echo "<option value=\"$row_Countries->Code\" selected>".$row_Countries->Country."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_Countries->Code\">".$row_Countries->Country."</option>";
                                        }
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
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('AirportCode', 'City', 'CountryCode');">Update</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of booking form -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
