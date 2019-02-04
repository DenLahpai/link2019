<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_Services_booking('insert_flight', $BookingsId, $ServicesId);

}
?>
<!-- service form -->
<div class="service form">
    <form action="#" method="post" id="myForm">
        <ul>
            <li class="bold">
                Airline:
                <? echo $row_Services->Name; ?>
            </li>
            <li>
                Date:
                <input type="date" name="Date_in" id="Date_in" value="<? echo $Date_in; ?>">
            </li>
            <li>
                Pax:
                <input type="number" name="Pax" value="<? echo $row_Bookings->Pax; ?>">
            </li>
            <li>
                Flight No:
                <input type="text" name="Flight_no" id="Flight_no" value="">
            </li>
            <li>
                From:
                <select name="Pick_up">
                    <?php
                    // getting data from the table Cities
                    $rows_Cities = table_Cities('select_all', NULL, NULL);
                    foreach ($rows_Cities as $row_Cities) {
                        if ($row_Cities->City == $row_Services_booking->Pick_up) {
                            echo "<option value=\"$row_Cities->City\" selected>".$row_Cities->AirportCode." - ".$row_Cities->City."</option>";
                        }
                        else {
                            echo "<option value=\"$row_Cities->City\">".$row_Cities->AirportCode." - ".$row_Cities->City."</option>";
                        }
                    }
                    ?>
                </select>
            </li>
            <li>
                To:
                <select name="Drop_off">
                    <?php
                    // getting data from the table Cities
                    $rows_Cities = table_Cities('select_all', NULL, NULL);
                    foreach ($rows_Cities as $row_Cities) {
                        if ($row_Cities->City == $row_Services_booking->Drop_off) {
                            echo "<option value=\"$row_Cities->City\" selected>".$row_Cities->AirportCode." - ".$row_Cities->City."</option>";
                        }
                        else {
                            echo "<option value=\"$row_Cities->City\">".$row_Cities->AirportCode." - ".$row_Cities->City."</option>";
                        }
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
                    //Getting data from the table ServiceStatus
                    $rows_ServiceStatus = table_ServiceStatus('select_all', NULL, NULL);
                    foreach ($rows_ServiceStatus as $row_ServiceStatus) {
                        if ($row_ServiceStatus->Id == $row_Services_booking->StatusId) {
                            echo "<option value=\"$row_ServiceStatus->Id\" selected>".$row_ServiceStatus->Code."</option>";
                        }
                        else {
                            echo "<option value=\"$row_ServiceStatus->Id\">".$row_ServiceStatus->Code."</option>";
                        }
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
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="0.0">
            </li>
            <li id="costMMK" class="invisible">
                Cost in MMK / Pers:
                <input type="number" name="Cost1_MMK" value="0">
            </li>
            <li id="sellPerUSD" class="invisible">
                Sell in USD / Pers:
                <input type="number" step="0.01" name="sellPerUSD" id="sellPerUSD" value="0">
            </li>
            <li id="sellPerMMK" class="invisible">
                Sell in MMK / Pers:
                <input type="number" name="sellPerMMK" value="0">
            </li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkThreeFields('Date_in', 'Pick_up_time', 'Drop_off_time')">Submit</button>
            </li>
        </ul>
    </form>
</div>
<!-- end of service form -->
