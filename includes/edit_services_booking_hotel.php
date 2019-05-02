<?php
?>
<!-- service form -->
<div class="service form">
    <form action="#" method="post">
        <ul>
            <li class="bold">
                Hotel:
                <? echo $row_Services_booking->SuppliersName; ?>
            </li>
            <li>
                Room Type:
                <? echo $row_Services_booking->Service; ?>
            </li>
            <li>
                Check-in:
                <input type="date" name="Date_in" id="Date_in" value="<? echo $row_Services_booking->Date_in; ?>">
            </li>
            <li>
                Check-out:
                <input type="date" name="Date_out" id="Date_out" value="<? echo $row_Services_booking->Date_out; ?>" onchange="getQuantity();">
            </li>
            <li>
                Night(s):
                <input type="number" name="Quantity" id="Quantity" value="<? echo $row_Services_booking->Quantity; ?>">
            </li>
            <li>
                Number of Rooms:
            </li>
            <li>
                Single:
                <input type="number" name="Sgl" id="Sgl" value="<? echo $row_Services_booking->Sgl; ?>">
            </li>
            <li>
                Double:
                <input type="number" name="Dbl" id="Dbl" value="<? echo $row_Services_booking->Dbl; ?>">
            </li>
            <li>
                Twin:
                <input type="number" name="Twn" id="Twn" value="<? echo $row_Services_booking->Twn; ?>">
            </li>
            <li>
                Triple:
                <input type="number" name="Tpl" id="Tpl" value="<? echo $row_Services_booking->Tpl; ?>">
            </li>
            <li>
                Cost
            </li>
            <li>
                Double / Twin Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="<? echo $row_Services_booking->Cost1_USD; ?>">
                MMK:
                <input type="number" name="Cost1_MMK" id="Cost1_MMK" value="<? echo $row_Services_booking->Cost1_MMK; ?>">
            </li>

        </ul>
    </form>
</div>
<!-- end of service form -->
