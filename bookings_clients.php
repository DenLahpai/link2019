<?php
require_once "functions.php";

//getting the BookingsId
$BookingsId = trim($_REQUEST['BookingsId']);

//getting data from the table Bookings
$rows_Bookings = table_Bookings ('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Clients - ".$row_Bookings->Reference;
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/header.html";
            include "includes/nav.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <a href="<? echo "add_new_client.php?BookingsId=$BookingsId"; ?>"><button type="button" name="button">Add New Client</button></a>
                <a href="<? echo "add_existing_client.php?BookingId=$BookingsId"; ?>"><button type="button" name="button">Add Existing Client</button></a>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    //getting data from the table Booking_Clients
                    $rows_Bookings_Clients = table_Bookings_Clients ('select_for_booking', $BookingsId, NULL);
                    foreach ($rows_Bookings_Clients as $row_Bookings_Clients) {
                        echo "<!-- grid-item -->";
                        echo "<div class=\"grid-item\">";
                        echo "<ul>";
                        echo "<li class=\"bold\">".$row_Bookings_Clients->Title." ".$row_Bookings_Clients->FirstName." ".$row_Bookings_Clients->LastName."</li>";
                        echo "<li>Passport: ".$row_Bookings_Clients->PassportNo." Expiry Date: ".date("d-M-Y", strtotime($row_Bookings_Clients->PassportExpiry))."</li>";
                        echo "<li>NRC: ".$row_Bookings_Clients->NRCNo."</li>";
                        echo "<li>Country: ".$row_Bookings_Clients->Country."</li>";
                        echo "<li>Frequent Flyer: ".$row_Bookings_Clients->FrequentFlyer."</li>";
                        echo "<li>Company: ".$row_Bookings_Clients->Company."</li>";
                        echo "<li>Phone: ".$row_Bookings_Clients->Phone."</li>";
                        echo "<li>Email: ".$row_Bookings_Clients->Email."</li>";
                        echo "<li>Website: ".$row_Bookings_Clients->Website."</li>";
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
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>