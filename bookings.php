<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Bookings";
    include "includes/head.html";
    ?>
    <body>
        <!-- content  -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = "Bookings";
            include "includes/header.html";
            ?>
            <main>
                <!-- grid-div -->
                <div class="grid-div">
                    <?php
                    $rows_Bookings = table_Bookings('select', NULL, NULL);
                    foreach ($rows_Bookings as $row_Bookings) {
                        echo "<!-- grid-item -->";
                        echo "<div class='grid-item'>";
                        echo "<ul>";
                        echo "<li class=\"bold\"><a href=\"booking_summary.php?BookingsId=$row_Bookings->Id\">".$row_Bookings->Reference."</a></li>";
                        echo "<li class=\"bold\">".$row_Bookings->Name." X ".$row_Bookings->Pax."</li>";
                        echo "<li>".$row_Bookings->CorporatesName."</li>";
                        echo "<li class=\"bold\">".date("d-M-Y", strtotime($row_Bookings->ArvDate))."</li>";
                        echo "<li>".$row_Bookings->Status."</li>";
                        echo "<li>By ".$row_Bookings->Username."</li>";
                        echo "<li><a href=\"edit_booking.php?BookingsId=$row_Bookings->Id\"><button type=\"button\" class=\"link button\">Edit</button></a></li>";
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
    </body>
</html>
