<?php
require_once "functions.php";

//getting Services_bookingId
$Services_bookingId = trim($_REQUEST['Services_bookingId']);
if (!is_numeric($Services_bookingId)) {
    echo "There was a problem! Please go back and try again!";
    die();
}

// getting data from the table Services
$rows_Services = table_Services_booking ('select_one', $Services_bookingId, NULL);
foreach ($rows_Services as $row_Services) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_Services_booking ('delete', $Services_bookingId, NULL);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Delete Serivce";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Delete Service";
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <form class="" action="#" method="post">
                    <ul>
                        <li class="bold">Are you sure to delete the following services from current booking?</li>
                        <li class="invisible">
                            <input type="number" name="BookingsId" id="BookingsId" value="<? echo $row_Services->BookingsId; ?>">
                        </li>
                        <li>
                            <?php
                            echo $row_Services->SuppliersName.": ".$row_Services->Service." | ".$row_Services->Pick_up." - ".$row_Services->Drop_off;
                            ?>
                        </li>
                        <li>
                            <button type="button" name="button" onclick="this.form.submit();">Yes</button>
                            &nbsp;
                            &nbsp;
                            <button type="button" name="button" onclick=" window.history.back();">No</button>
                        </li>
                    </ul>
                </form>
            </main>
            <?php include "includes/footer.html"; ?>            
        </div>
        <!-- end of content -->
    </body>
</html>
