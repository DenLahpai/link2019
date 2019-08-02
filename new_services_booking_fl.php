<?php
require_once "functions.php";

//getting data from the table Bookings
$BookingsId = trim($_REQUEST['BookingsId']);
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // codes...
}

//getting Suppliers for FL
$rows_Suppliers_FL = table_Suppliers('select_Suppliers_FL', NULL, NULL);

//getting data from the table Cities
$rows_Cities = table_Cities ('select_all', NULL, NULL);

//getting data from the table ServiceStatus
$rows_ServiceStatus = table_ServiceStatus('select_all', NULL, NULL);


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = $row_Bookings->Reference.": New Flight";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/nav.html";
            include "includes/header.html";
            include "includes/booking_menu.html";
            ?>
            <main>
                <!-- service form -->
                <div class="service form">
                    <form id="myForm" action="#" method="post">
                        <ul>
                            <li class="bold">
                                Airline:
                                <select name="SupplierId" id="SupplierId">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_Suppliers_FL as $row_Suppliers_FL) {
                                        echo "<option value=\"$row_Suppliers_FL->SupplierId\">".$row_Suppliers_FL->Name."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Date:
                                <input type="date" name="Date_in" id="Date_in">
                            </li>
                            <li>
                                Pax:
                                <input type="number" name="Pax" min="1" value="<? echo $row_Bookings->Pax; ?>">
                            </li>
                            <li>
                                Flight No:
                                <input type="text" name="Flight_no" placeholder="Flight Number">
                            </li>
                            <li>
                                From:
                                <select name="Pick_up" id="Pick_up">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_Cities as $row_Cities) {
                                        echo "<option value=\"$row_Cities->Id\">".$row_Cities->City."</option>";
                                    }
                                    ?>
                                </select>
                                &nbsp;
                                To:
                                <select name="Drop_off" id="Drop_off">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_Cities as $row_Cities) {
                                        echo "<option value=\"$row_Cities->Id\">".$row_Cities->City."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                ETD:
                                <input type="time" name="Pick_up_time" id="Pick_up_time">
                                &nbsp;
                                ETA:
                                <input type="time" name="Drop_off_time" id="Drop_off_time">
                            </li>
                            <li>
                                Status:
                                <select name="StatusId">
                                    <?php
                                    foreach ($rows_ServiceStatus as $row_ServiceStatus) {
                                        echo "<option value=\"$row_ServiceStatus->Id\">".$row_ServiceStatus->Status."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Confirmation No:
                                <input type="text" name="Cfm_no">
                            </li>
                            <li>
                                Select Currency:
                                <select id="currency" name="currency" onchange="selectCurrency();">
                                    <option value="0">Select One</option>
                                    <option value="USD">USD</option>
                                    <option value="MMK">MMK</option>
                                </select>
                            </li>
                            <li id="costUSD" class="invisible">
                                Cost in USD / Pers:
                                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="<? echo $row_Services_booking->Cost1_USD; ?>">
                            </li>
                            <li id="costMMK" class="invisible">
                                Cost in MMK / Pers:
                                <input type="number" name="Cost1_MMK" value="<? echo $row_Services_booking->Cost1_MMK; ?>">
                            </li>
                            <li id="sellPerUSD" class="invisible">
                                Sell in USD / Pers:
                                <input type="number" step="0.01" name="sellPerUSD" id="sellPerUSD" value="<? echo $row_Services_booking->Sell_USD / $row_Services_booking->Pax; ?>">
                            </li>
                            <li id="sellPerMMK" class="invisible">
                                Sell in MMK / Pers:
                                <input type="number" name="sellPerMMK" value="<? echo $row_Services_booking->Sell_USD / $row_Services_booking->Pax; ?>">
                            </li>
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkThreeFields('Date_in', 'Pick_up_time', 'Drop_off_time')">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of service form -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->        
    </body>
</html>
