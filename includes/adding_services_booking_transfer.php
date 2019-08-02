<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_Services_booking('insert_transfer', $BookingsId, $ServicesId);
}
?>
<!-- service form -->
<div class="service form">
    <form action="#" method="post" id="myForm">
        <ul>
            <li class="bold">
                Supplier:
                <? echo $row_Services->Name; ?>
            </li>
            <li>
                Service:
                <? echo $row_Services->Service. " | ".$row_Services->Additional; ?>
            </li>
            <li>
                Date:
                <input type="date" name="Date_in" id="Date_in" value="<? echo $Date_in; ?>">
            </li>
            <li>
                Pax:
                <input type="number" name="Pax" id="Pax" value="<? echo $row_Bookings->Pax; ?>">
            </li>
            <li>
                Quantity:
                <input type="number" name="Quantity" id="Quantity" value="1" onchange="requireMininumValue ('Quantity',1, 99);">
            </li>
            <li>
                Pickup:
                <input type="text" name="Pick_up" id="Pick_up">
                @ <input type="time" name="Pick_up_time" id="Pick_up_time">
            </li>
            <li>
                Drop_off:
                <input type="text" name="Drop_off" id="Drop_off">
                @ <input type="time" name="Drop_off_time" id="Drop_off_time">
            </li>
            <li>
                Special RQ:
                <input type="text" name="Spc_rq" id="Spc_rq">
            </li>
            <li>
                Status:
                <select name="StatusId">
                    <option value="">Select One</option>
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
            <li class="bold">
                Cost
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="<? echo $row_Services->Cost1_USD; ?>" readonly>
                MMK:
                <input type="number" name="Cost1_MMK" id="Cost1_MMK" value="<? echo $row_Services->Cost1_MMK; ?>" readonly>
            </li>
                <li>
                Markup %:
                <input type="number" step="0.01" name="Markup" id="Markup" onchange="calculateGroupServiceSell();">
            </li>
            <li class="bold">
                Sell
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Sell_USD" id="Sell_USD" value="<? echo $row_Services->Sell_USD; ?>" readonly>
                MMK:
                <input type="number" name="Sell_MMK" id="Sell_MMK" value="<? echo $row_Services->Sell_MMK; ?>" readonly>
            </li>
            <li class="error"></li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkThreeFields('Date_in', 'Pick_up', 'Markup')">Submit</button>
            </li>
        </ul>
    </form>
</div>
<!-- end of service form -->
