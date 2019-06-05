<?php
require_once "functions.php";

//getting the ServicesId
$ServicesId = trim($_REQUEST['ServicesId']);
if (!is_numeric($ServicesId)) {
    echo "There was an error! Please go back and try again!";
    die();
}
//getting data from the table Services
$rows_Services = table_Services('select_one', $ServicesId, NULL);
foreach ($rows_Services as $row_Services) {
    // code...
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Service";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Service: Hotel";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <?php
                switch ($row_Services->ServiceTypeId) {
                    case '1':
                        // getting the form for AC
                        include "includes/edit_service_AC.php";
                        break;
                    case '2':
                        // getting the form for FL
                        include "includes/edit_service_FL.php";
                        break;
                    case '3':
                        // getting the form for LT
                        include "includes/edit_service_LT.php";
                        break;
                    default:
                        // code...
                        break;
                }
                ?>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
