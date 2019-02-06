<?php
require_once "functions.php";

//getting Countries Id
$CountriesId = trim($_REQUEST['CountriesId']);

$rows_Countries = table_Countries('select_one', $CountriesId, NULL);
foreach ($rows_Countries as $row_Countries) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Countries ('check_before_update', $CountriesId, NULL);

    if ($rowCount == 0) {
        table_Countries ('update', $CountriesId, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Countries";
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
                                Code:
                                <input type="text" name="Code" id="Code" value="<? echo $row_Countries->Code; ?>">
                            </li>
                            <li>
                                Country:
                                <input type="text" name="Country" id="Country" value="<? echo $row_Countries->Country; ?>">
                            </li>
                            <li>
                                Region:
                                <input type="text" name="Region" id="Region" value="<? echo $row_Countries->Region; ?>">
                            </li>
                            <li class="error">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Code', 'Country', 'Region');">Update</button>
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
