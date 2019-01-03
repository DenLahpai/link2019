<?php
require_once "functions.php";

//getting one data from the table Services_booking
$Services_bookingId = trim($_REQUEST['Services_bookingId']);
$rows_Services_booking = table_Services_booking('select_one', $Services_bookingId, NULL);
foreach ($rows_Services_booking as $row_Services_booking) {
    $BookingsId = $row_Services_booking->BookingsId;
    $ServiceTypeId =$row_Services_booking->ServiceTypeId;
}



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Edit Service';
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = $page_title;
            include "includes/header.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <?php
                switch ($ServiceTypeId) {
                    case '1':
                        // code...
                        break;
                    case '2':
                        include "includes/edit_services_booking_flight.php";
                        break;

                    default:
                        // code...
                        break;
                }
                ?>
            </main>
        </div>
        <!-- end of content -->
    </body>
    <?php include "includes/footer.html"; ?>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
