<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_Services_booking ('insert_hotel', $BookingsId, $ServicesId);
}
?>
<!-- service form -->
<div class="service form">
    <form action="#" method="post" id="myForm">
        <ul>
            <li class="bold">
                Hotel:
                <? echo $row_Services->Name; ?>
            </li>
            <li>
                Room Type:
                <? echo $row_Services->Service; ?>
            </li>
            <li>
                Check-in:
                <input type="date" name="Date_in" id="Date_in" value="<? echo $Date_in; ?>">
            </li>
            <li>
                Check-out:
                <input type="date" name="Date_out" id="Date_out" onchange="getQuantity();">
            </li>
            <li>
                Night(s):
                <input type="number" name="Quantity" id="Quantity">
            </li>
            <li>
                Number of Rooms:
            </li>
            <li>
                Single:
                <input type="number" name="Sgl" id="Sgl" value="0">
            </li>
            <li>
                Double:
                <input type="number" name="Dbl" id="Dbl" value="0">
            </li>
            <li>
                Twin:
                <input type="number" name="Twn" id="Twn" value="0">
            </li>
            <li>
                Triple:
                <input type="number" name="Tpl" id="Tpl" value="0">
            </li>
            <li class="bold">
                Cost
            </li>
            <li>
                Single Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost2_USD" id="Cost2_USD" value="<? echo $row_Services->Cost2_USD; ?>" readonly>
                MMK:
                <input type="number" name="Cost2_MMK" id="Cost2_MMK" value="<? echo $row_Services->Cost2_MMK; ?>" readonly>
            </li>
            <li>
                Double / Twin Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="<? echo $row_Services->Cost1_USD; ?>">
                MMK:
                <input type="number" step="0.01" name="Cost1_MMK" id="Cost1_MMK" value="<? echo $row_Services->Cost1_MMK; ?>">
            </li>
            <li>
                Triple Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost3_USD" id="Cost3_USD" value="<? echo $row_Services->Cost3_USD; ?>">
                MMK:
                <input type="number" step="0.01" name="Cost3_MMK" id="Cost3_MMK" value="<? echo $row_Services->Cost3_MMK; ?>">
            </li>
            <li>
                Markup %:
                <input type="number" name="Markup" id="Markup" step="0.01" onchange="calculateHotelSell();">
            </li>
            <li class="bold">
                Sell
            </li>
            <li>
                Single Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Sell2_USD" id="Sell2_USD" onchange="adjustMarkup('Sell2_USD', 'Cost2_USD')">
                MMK:
                <input type="number" name="Sell2_MMK" id="Sell2_MMK" onchange="adjustMarkup('Sell2_MMK', 'Cost2_MMK');">
            </li>
            <li>
                Double / Twin Room
            </li>
            <li>
                USD:
                <input type="number" name="Sell1_USD" id="Sell1_USD" step="0.01" onchange="adjustMarkup('Sell1_USD', 'Cost1_USD');">
                MMK:
                <input type="number" name="Sell1_MMK" id="Sell1_MMK" onchange="adjustMarkup('Sell1_MMK', 'Cost1_MMK');">
            </li>
            <li>
                Triple Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Sell3_USD" id="Sell3_USD" onchange="adjustMarkup('Sell3_USD', Cost3_USD);">
                MMK:
                <input type="number" name="Sell3_MMK" id="Sell3_MMK" onchange="adjustMarkup('Sell3_MMK', 'Cost3_MMK');">
            </li>
            <li class="error"></li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkHotel();">Submit</button>
            </li>
        </ul>
    </form>
</div>
<!-- end of service form -->
