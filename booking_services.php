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
                    Flights <a href="<?php echo "confirmations_flights.php?BookingsId=$BookingsId"; ?>" target="_blank">Confirmation</a>
                </h3>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_flights = table_Services_booking('select_flights', $BookingsId, NULL);
                    foreach ($rows_flights as $row_flights) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li>Airline: <span class=\"bold\">".$row_flights->SuppliersName."</span></li>";
                        echo "<li>Flight: ".$row_flights->Pick_up." - ".$row_flights->Drop_off."</li>";
                        echo "<li>Flight No: ".$row_flights->Flight_no." ".date("H:i", strtotime($row_flights->Pick_up_time))." - ".date('H:i', strtotime($row_flights->Drop_off_time));
                        echo "<li>Status: ".$row_flights->Status."</li>";
                        echo "<li>Confirmation No: ".$row_flights->Cfm_no."</li>";
                        echo "<li><a href=\"edit_services_booking.php?Services_bookingId=$row_flights->Services_bookingId\"><button class=\"button link\">Edit</button></a>&nbsp; &nbsp";
                        echo "<a href=\"delete_services_booking.php?Services_bookingId=$row_flights->Services_bookingId\"><button class=\"button link\">Delete</button></a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
                <h3>
                    Hotels <a href="<? echo "confirmations_hotels.php?BookingsId=$BookingsId"; ?>" target="_blank">Confirmation</a>
                </h3>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_hotels = table_Services_booking ('select_hotels', $BookingsId, NULL);
                    foreach ($rows_hotels as $row_hotels) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li>Hotel: <span class=\"bold\">".$row_hotels->SuppliersName."</span></li>";
                        echo "<li>Room Type: ".$row_hotels->Service."</li>";
                        echo "<li>Room(s): ";
                        if ($row_hotels->Sgl > 0) {
                            echo $row_hotels->Sgl." Sgl, ";
                        }
                        if ($row_hotels->Dbl > 0) {
                            echo $row_hotels->Dbl." Dbl, ";
                        }
                        if ($row_hotels->Twn > 0) {
                            echo $row_hotels->Twn." Twn, ";
                        }
                        if ($row_hotels->Tpl > 0) {
                            echo $row_hotels->Tpl." Tpl ";
                        }
                        echo "</li>";
                        echo "<li>Check-in: ".date('d-M-y', strtotime($row_hotels->Date_in))." | ";
                        echo "Check-out: ".date('d-M-y', strtotime($row_hotels->Date_out))."</li>";
                        echo "<li>Night(s): ".$row_hotels->Quantity."</li>";
                        echo "<li>Status: ".$row_hotels->Code."</li>";
                        echo "<li>Confirmation: ".$row_hotels->Cfm_no."</li>";
                        echo "<li><a href=\"edit_services_booking.php?Services_bookingId=$row_hotels->Services_bookingId\"><button class=\"button link\">Edit</button></a>&nbsp; &nbsp";
                        echo "<a href=\"delete_services_booking.php?Services_bookingId=$row_hotels->Services_bookingId\"><button class=\"button link\">Delete</button></a>&nbsp; &nbsp";
                        echo "<a href=\"voucher_hotel.php?Services_bookingId=$row_hotels->Services_bookingId\" target=\"_blank\"><button class=\"button link\">Voucher</button></a></li>";
                        echo "</ul>";
                        echo "</div>";
                        echo "<!-- end of grid-item -->";
                    }
                    ?>
                </div>
                <!-- end of grid-div -->
                <h3>
                    Land Transfers <a href="<? echo "confirmations_transfers.php?BookingsId=$BookingsId"; ?>" target="_blank">Confirmation</a>
                </h3>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_transfers = table_Services_booking ('select_transfers', $BookingsId, NULL);
                    foreach ($rows_transfers as $row_transfers):
                    ?>
                    <!-- grid-item -->
                    <div class="grid-item">
                        <ul>
                            <li>
                                Supplier: <span class="bold"><? echo $row_transfers->SuppliersName; ?></span>
                            </li>
                            <li>
                                Service: <? echo $row_transfers->Service; ?> | <? echo $row_transfers->Additional; ?>
                            </li>
                            <li>
                                Pickup: <? echo $row_transfers->Pick_up; ?> @ <? echo date("H:i", strtotime($row_transfers->Pick_up_time)); ?>
                            </li>
                            <li>
                                Dropoff: <? echo $row_transfers->Drop_off; ?> @ <? echo date("H:i", strtotime($row_transfers->Drop_off_time)); ?>
                            </li>
                            <li>
                                Status: <? echo $row_transfers->Status; ?>
                            </li>
                            <li>
                                <a href="<? echo "edit_services_booking.php?Services_bookingId=$row_transfers->Services_bookingId"; ?>"><button type="button" class="button link" name="button">Edit</button></a>
                                &nbsp; &nbsp;
                                <a href="<? echo "delete_services_booking.php?Services_bookingId=$row_transfers->Services_bookingId"; ?>"><button type="button" class="button link" name="button">Delete</button></a>
                                &nbsp; &nbsp;
                            </li>
                        </ul>
                    </div>
                    <!-- end of grid-item -->
                    <?php endforeach; ?>
                </div>
                <!-- end of grid-div -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
</html>
