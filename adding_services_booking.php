<?php
require_once "functions.php";

//getting data from the table Bookings
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // codes...
}

//getting ServicesId
$ServicesId = trim($_REQUEST['ServicesId']);
$rows_Services = table_Services('select_one', $ServicesId, NULL);
foreach ($rows_Services as $row_Services) {
    // code...
}

//getting the Date_in
$Date_in = trim($_REQUEST['Date_in']);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = $row_Bookings->Reference.": Adding Service";
    include "includes/head.html";
    ?>
    <style media="screen">
        .MMK {
            display: none;
        }
        .USD {
            display: none;
        }
    </style>
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
                switch ($row_Services->ServiceTypeId) {
                    case '1':
                        include "includes/adding_services_booking_hotel.php";
                        break;
                    case '2':
                        include "includes/adding_services_booking_flight.php";
                        break;

                    case '3':
                        include "includes/adding_services_booking_transfer.php";
                        break;

                    default:
                        // code...
                        break;
                }
                ?>
            </main>
        </div>
        <?php include "includes/footer.html"; ?>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
