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
    $page_title = "Hotels Confirmations - ".$row_Bookings->Reference;
    include "includes/head.html";
    ?>
    <body>
        <!-- print  -->
        <div class="print">
            <!-- pageHeader -->
            <div class="pageHeader">
                <table>
                    <thead>
                        <tr>
                            <td>
                                <img src="images/LinkLogo.jpg" alt="Link Logo">
                            </td>
                            <td>
                                <ul>
                                    <li class="bold">Link In Myanmar Travel Co Ltd.</li>
                                    <li>No. 72, Tayoke Kyaung Street</li>
                                    <li>Sanchaung, Township, Yangon</li>
                                    <li>Tel: 95-9402590317</li>
                                    <li>Email: <a href="mailto:infor@linkinmyanmar.com">info@linkinmyanmar.com</a></li>
                                    <li>Website: <a href="http://www.linkinmyanmar.com">www.linkinmyanmar.com</a></li>
                                </ul>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- end of pageHeader -->
            <!-- Confirmation  -->
            <div class="confirmation">
                <h3>Hotels Confirmation: <? echo $row_Bookings->Reference." - ".$row_Bookings->Name." X ".$row_Bookings->Pax; ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Hotel</th>
                            <th>Room Type</th>
                            <th>Room(s)</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Night(s)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows_hotels = table_Services_booking ('select_hotels', $BookingsId, NULL);
                        foreach ($rows_hotels as $row_hotels) {
                            echo "<tr>";
                            echo "<td>".$row_hotels->City."</td>";
                            echo "<td>".$row_hotels->SuppliersName."</td>";
                            echo "<td>".$row_hotels->Service."</td>";
                            echo "<td>";
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
                                echo $row_hotels->Tpl." Tpl";
                            }
                            echo "</td>";
                            echo "<td>".date("d-M-y", strtotime($row_hotels->Date_in))."</td>";
                            echo "<td>".date("d-M-y", strtotime($row_hotels->Date_out))."</td>";
                            echo "<td>".$row_hotels->Quantity."</td>";
                            echo "<td>".$row_hotels->Code."</td>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- end of Confirmation -->
        </div>
        <!-- end of print -->
    </body>
</html>
