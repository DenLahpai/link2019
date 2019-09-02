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
    $page_title = "Transfers Confiration - ".$row_Bookings->Reference;
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
                <h3>Transfers Confirmation: <? echo $row_Bookings->Reference." - ".$row_Bookings->Name." X ".$row_Bookings->Pax; ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>City</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Pax</th>
                            <th>Pick-up</th>
                            <th>Drop-off</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows_transfers = table_Services_booking ('select_transfers', $BookingsId, NULL);
                        foreach ($rows_transfers as $row_transfers) :
                        ?>
                        <tr>
                            <td>
                                <? echo $row_transfers->City; ?>
                            </td>
                            <td>
                                <? echo date('d-M-y', strtotime($row_transfers->Date_in)); ?>
                            </td>
                            <td>
                                <? echo $row_transfers->Service. " | ".$row_transfers->Additional; ?>
                            </td>
                            <td>
                                <? echo $row_transfers->Pax; ?>
                            </td>
                            <td>
                                <? echo $row_transfers->Pick_up." @ ".date("H:i", strtotime($row_transfers->Pick_up_time)); ?>
                            </td>
                            <td>
                                <? echo $row_transfers->Drop_off." @ ".date("H:i", strtotime($row_transfers->Drop_off_time)); ?>
                            </td>
                            <td>
                                <? echo $row_transfers->Code; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- end of Confirmation -->
        </div>
        <!-- end of print -->
    </body>
</html>
