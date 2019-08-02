<?php
require_once "functions.php";
//gettting data from the table Bookings
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // codes...
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Flights Confirmations - '.$row_Bookings->Reference;
    include "includes/head.html";
    ?>
    <body>
        <!-- print -->
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
            <!-- Confirmation -->
            <div class="confirmation">
                <h3>Flights Confirmation: <? echo $row_Bookings->Reference." - ".$row_Bookings->Name." X ".$row_Bookings->Pax; ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sector</th>
                            <th>Flight</th>
                            <th>ETD</th>
                            <th>ETA</th>
                            <th>Status</th>
                            <th>Cfn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows_flights = table_Services_booking ('select_flights', $BookingsId, NULL);
                        foreach ($rows_flights as $row_flights) {
                            echo "<tr>";
                            echo "<td>".date('d-M-y', strtotime($row_flights->Date_in))."</td>";
                            echo "<td>".$row_flights->Pick_up." - ".$row_flights->Drop_off."</td>";
                            echo "<td>".$row_flights->Flight_no."</td>";
                            echo "<td>".date('H:i', strtotime($row_flights->Pick_up_time))."</td>";
                            echo "<td>".date('H:i', strtotime($row_flights->Drop_off_time))."</td>";
                            echo "<td>".$row_flights->StatusCode."</td>";
                            echo "<td>".$row_flights->Cfm_no."</td>";
                            echo "</tr>";
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
