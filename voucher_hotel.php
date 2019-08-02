<?php
require_once "functions.php";

//getting data from the table Users
$rows_Users = table_Users('select_one', $_SESSION['UsersId'], NULL);
foreach ($rows_Users as $row_Users) {
    // code...
}

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

//getting data from the table Bookings
$rows_Bookings = table_Bookings ('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}

//getting data from the table Suppleirs
$rows_Suppliers = table_Suppliers ('select_one', $row_Services_booking->SupplierId, NULL);
foreach ($rows_Suppliers as $row_Suppliers) {
    // code...
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Hotel Voucher - ".$row_Bookings->Reference." ".$row_Services_booking->SuppliersName;
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
            <!-- Confirmation -->
            <div class="voucher-address" style="border-bottom: 1px solid gold">
                <h3>Hotel Voucher</h3>
                <ul>
                    <li>
                        To:
                        <span class="bold">
                        <? echo $row_Services_booking->SuppliersName; ?>
                        </span>
                    </li>
                    <li>
                        <?php echo $row_Suppliers->Address; ?>
                    </li>
                    <li>
                        <?php echo $row_Suppliers->City.", Myanmar"; ?>
                    </li>
                    <li>
                        <?php echo $row_Suppliers->Phone; ?>
                    </li>
                    <li>
                        <a href="<?php echo "mailto:".$row_Suppliers->Email; ?>"><?php echo $row_Suppliers->Email; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo "http://".$row_Suppliers->Website; ?>"><?php echo $row_Suppliers->Website; ?></a>
                    </li>
                </ul>
            </div>
            <!-- end of voucher-address -->
            <div class="voucher-body" style="margin-top: 30px;">
                <ul>
                    <li>
                        Booking Reference: <? echo $row_Bookings->Reference; ?>
                    </li>
                    <li>
                        Booking Name: <? echo $row_Bookings->Name." X ". $row_Bookings->Pax; ?>
                    </li>
                    <li>
                        Room Type: <? echo $row_Services_booking->Service; ?>
                    </li>
                    <li>
                        Room(s):
                        <?php
                        if ($row_Services_booking->Sgl > 0) {
                            echo $row_Services_booking->Sgl." Sgl, ";
                        }
                        if ($row_Services_booking->Dbl > 0) {
                            echo $row_Services_booking->Dbl." Dbl, ";
                        }
                        if ($row_Services_booking->Twn > 0) {
                            echo $row_Services_booking->Twn." Twn, ";
                        }
                        if ($row_Services_booking->Dbl > 0) {
                            echo $row_Services_booking->Tpl." Tpl ";
                        }
                        ?>
                    </li>
                    <li>
                        Check-in: <span class="bold"><? echo date("d-M-y", strtotime($row_Services_booking->Date_in))."&nbsp;"; ?></span>
                        Check-out: <span class="bold"><? echo date("d-M-y", strtotime($row_Services_booking->Date_out));?></span>
                    </li>
                    <li>
                        Night(s): <? echo $row_Services_booking->Quantity; ?>
                    </li>
                    <li>
                        Confirmation: <? echo $row_Services_booking->Cfm_no; ?>
                    </li>
                    <li>
                        Please note that Link In Myanmar Travel will settle the payment for room charges including breakfast only! <br>
                        Other incidental charges should be settle by the guest.
                    </li>
                </ul>
            </div>
        </div>
        <!-- end of print -->
    </body>
</html>
