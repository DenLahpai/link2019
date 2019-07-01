<?php
require_once "functions.php";

//getting one data from the table Services_booking
$Services_bookingId = trim($_REQUEST['Services_bookingId']);
if (!is_numeric ($Services_bookingId)) {
    echo "There was a problem! Please go back and try again!";
    die ();
}
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
                        include "includes/edit_services_booking_hotel.php";
                        break;
                    case '2':
                        include "includes/edit_services_booking_flight.php";
                        break;
                    case '3':
                        include "includes/edit_services_booking_transfer.php";
                        break;

                    default:
                        // code...
                        break;
                }
                ?>
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
