<?php

?>
<!-- service form -->
<div class="service form">
    <form action="#" method="post" id="myForm">
        <ul>
            <li class="bold">
                Supplier:
                <? echo $row_Services_booking->SuppliersName; ?>
            </li>
            <li>
                Date:
                <input type="date" name="Date_in" id="Date_in" value="<? echo $row_Services_booking->Date_in; ?>">
            </li>
            <li>
                Service:
                <? echo $row_Services_booking->Service." | ".$row_Services_booking->Additional;?>
            </li>
            <li>
                Pick-up:
                <input type="text" name="Pick_up" id="Pick_up" value="<? echo $row_Services_booking->Pick_up; ?>">
                &nbsp; @ &nbsp;
                <input type="time" name="Pick_up_time" id="Pick_up_time" value="<? echo $row_Services_booking->Pick_up_time; ?>">
            </li>
            <li>
                Drop-off:
                <input type="text" name="Drop_off" id="Drop_off" value="<? echo $row_Services_booking->Drop_off; ?>">
                &nbsp; @ &nbsp;
                <input type="time" name="Drop_off_time" id="Drop_off_time" value="<? echo $row_Services_booking->Drop_off_time; ?>">
            </li>
            <li>
                Quantity:
                <input type="number" name="Quantity" id="Quantity" value="<? echo $row_Services_booking->Quantity; ?>">
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
                Select Currency:
                <select id="currency" name="currency" onchange="selectCurrency();">
                    <option value="0">Select One</option>
                    <option value="USD">USD</option>
                    <option value="MMK">MMK</option>
                </select>
            </li>
            <li id="costUSD" class="USD">
                Cost in USD / Pers:
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="<? echo $row_Services_booking->Cost1_USD; ?>">
            </li>
            <li id="costMMK" class="MMK">
                Cost in MMK / Pers:
                <input type="number" name="Cost1_MMK" value="<? echo $row_Services_booking->Cost1_MMK; ?>">
            </li>
            <li>
                Markup %:
                <input type="number" step="0.01" name="Markup" id="Markup" value="<? echo $row_Services_booking->Markup;?>">
            </li>
            <li class="USD">
                Sell in USD:
                <input type="number" step="0.01" name="sell_USD" id="SellUSD" value="<? echo $row_Services_booking->Sell_USD; ?>" onchange="adjustMarkup('Sell_USD', 'Cost1_USD');">
            </li>
            <li class="MMK">
                Sell in MMK:
                <input type="number" name="sell_MMK" id="Sell_MMK" value="<? echo $row_Services_booking->Sell_MMK; ?>" onchange="adjustMarkup('Sell_MMK', 'Cost1_MMK')">
            </li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkThreeFields('Date_in', 'Pick_up', 'Pick_up_time')">Update</button>
            </li>
        </ul>
    </form>
</div>
<!-- end of service form -->
