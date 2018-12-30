<?php
//getting data from the form
if ($_SERVER['REQUEST_METHOD'] ==  'POST') {
    table_Services_booking('update_one', $Services_bookingId, $BookingsId);
}
?>

<form action="#" method="post">
    <ul>
        <li class="bold">
            Airline:
            <? echo $row_Services_booking->SuppliersName;?>
        </li>
        <li>
            Date:
            <input type="date" name="Date_in" id="Date_in" value="<? echo $row_Services_booking->Date_in; ?>">
        </li>
        <li>
            Flight No:
            <input type="text" name="Flight_no" value="<? echo $row_Services_booking->Flight_no; ?>">
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
            <input type="time" name="Pick_up_time" id="Pick_up_time" value="<? echo $row_Services_booking->Pick_up_time; ?>">
            ETA:
            <input type="time" name="Drop_off_time" id="Drop_off_time" value="<? echo $row_Services_booking->Drop_off_time; ?>">
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
            <input type="text" name="Cfm_no" value="<? echo $row_Services_booking->Cfm_no; ?>">
        </li>
        <li>
            <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkThreeFields('Date_in', 'Pick_up_time', 'Drop_off_time')">Update</button>
        </li>
    </ul>
</form>
