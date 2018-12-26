<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // codes...
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Services: $row_Bookings->Reference";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = "Services: $row_Bookings->Reference";
            include "includes/header.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <h3>
                    Flights
                    <button class="button modal" id="New Flight">Add New</button>
                </h3>                
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_flights = table_Services_booking('select_flights', $row_Bookings->Id, NULL);
                    foreach ($rows_flights as $row_flights) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        // echo "<li class=\"invisible\">Id:".$row_flights->Services_bookingId."</li>";
                        echo "<li>Airline: <span class=\"bold\">".$row_flights->SuppliersName."</span></li>";
                        echo "<li>Flight: ".$row_flights->Pick_up." - ".$row_flights->Drop_off."</li>";
                        echo "<li>Flight No: ".$row_flights->Flight_no." ".date("H:i", strtotime($row_flights->Pick_up_time))." - ".date('H:i', strtotime($row_flights->Drop_off_time));
                        echo "<li>Status: ".$row_flights->Status." Cfm: ".$row_flights->Cfm_no."</li>";
                        echo "<li><button class=\"link button\" id=\"$row_flights->Services_bookingId\" onclick=\"openModalEditFlight($row_flights->Services_bookingId);\">Edit</button>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
        <?php
        // including the modals for edit
        include "includes/edit_services_booking_flight.php";
        ?>
    </body>
    <script type="text/javascript" src="scripts/modals.js"></script>
</html>
