<?php
//getting the selling prices
$Sell1_USD = $row_Services_booking->Cost1_USD + ($row_Services_booking->Cost1_USD * $row_Services_booking->Markup / 100);
$Sell1_MMK = $row_Services_booking->Cost1_MMK + ($row_Services_booking->Cost1_MMK * $row_Services_booking->Markup / 100);

$Sell2_USD = $row_Services_booking->Cost2_USD + ($row_Services_booking->Cost2_USD * $row_Services_booking->Markup / 100);
$Sell2_MMK = $row_Services_booking->Cost2_MMK + ($row_Services_booking->Cost2_MMK * $row_Services_booking->Markup / 100);

$Sell3_USD = $row_Services_booking->Cost3_USD + ($row_Services_booking->Cost3_USD * $row_Services_booking->Markup / 100);
$Sell3_MMK = $row_Services_booking->Cost3_MMK + ($row_Services_booking->Cost3_MMK * $row_Services_booking->Markup / 100);

//TODO update the data in the table Serivces_booking table

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
                Single Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost2_USD" id="Cost2_USD" value="<? echo $row_Services_booking->Cost2_USD; ?>" readonly>
                MMK:
                <input type="number" name="Cost2_MMK" id="Cost2_MMK" value="<? echo $row_Services_booking->Cost2_MMK?>" readonly>
            </li>
            <li>
                Double / Twin Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="<? echo $row_Services_booking->Cost1_USD; ?>" readonly>
                MMK:
                <input type="number" name="Cost1_MMK" id="Cost1_MMK" value="<? echo $row_Services_booking->Cost1_MMK; ?>" readonly>
            </li>
            <li>
                Triple
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost3_USD" id="Cost3_USD" value="<? echo $row_Services_booking->Cost3_USD; ?>" readonly>
                MMK:
                <input type="number" name="Cost3_MMK" id="Cost3_MMK" value="<? echo $row_Services_booking->Cost3_MMK; ?>" readonly>
            </li>
            <li>
                Markup %:
                <input type="number" step="0.01" name="Markup" id="Markup" value="<? echo $row_Services_booking->Markup; ?>" onchange="adjustSell();">
            </li>
            <li class="bold">
                Sell
            </li>
            <li>
                Single Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Sell2_USD" id="Sell2_USD" value="<? echo $Sell2_USD; ?>"  onchange="adjustMarkup('Sell2_USD', 'Cost2_USD');">
                MMK:
                <input type="number" name="Sell2_MMK" id="Sell2_MMK" value="<? echo $Sell2_MMK;?>">
            </li>
            <li>
                Double / Twin Room
            </li>
            <li>
                USD:
                <input type="number" name="Sell1_USD" id="Sell1_USD" step="0.01" value="<? echo $Sell1_USD; ?>">
                MMK:
                <input type="number" name="Sell1_MMK" id="Sell1_MMK" value="<? echo $Sell1_MMK; ?>">
            </li>
            <li>
                Triple Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Sell3_USD" id="Sell3_USD" value="<? echo $Sell3_USD; ?>">
                MMK:
                <input type="number" name="Sell3_MMK" id="Sell3_MMK" value="<? echo $Sell3_MMK; ?>">
            </li>
            <li class="error"></li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="">Update</button>
            </li>
        </ul>
    </form>
</div>
<!-- end of service form -->
<script type="text/javascript">
    //function to adjust the Markup
    function adjustMarkup(sell, cost) {

        var sell = document.getElementById(sell);
        var cost = document.getElementById(cost);
        var Markup = document.getElementById('Markup');
        var profit = sell.value - cost.value;
        var Markup = (profit / cost.value) * 100;
        document.getElementById('Markup').value = Markup;
        adjustSell();
    }

    //function to adjust selling
    function adjustSell() {
        var Cost1_USD = document.getElementById('Cost1_USD').value - 0;
        var Cost1_MMK = document.getElementById('Cost1_MMK').value - 0;
        var Cost2_USD = document.getElementById('Cost2_USD').value - 0;
        var Cost2_MMK = document.getElementById('Cost2_MMK').value - 0;
        var Cost3_USD = document.getElementById('Cost3_USD').value - 0;
        var Cost3_MMK = document.getElementById('Cost3_MMK').value - 0;

        var Markup = document.getElementById('Markup').value - 0;

        document.getElementById('Sell1_USD').value = Cost1_USD + (Cost1_USD * Markup / 100);
        document.getElementById('Sell1_MMK').value = Cost1_MMK + (Cost1_MMK * Markup / 100);
        document.getElementById('Sell2_USD').value = Cost2_USD + (Cost2_USD * Markup / 100);
        document.getElementById('Sell2_MMK').value = Cost2_MMK + (Cost2_MMK * Markup / 100);
        document.getElementById('Sell3_USD').value = Cost3_USD + (Cost3_USD * Markup / 100);
        document.getElementById('Sell3_MMK').value = Cost3_MMK + (Cost3_MMK * Markup / 100);
    }
</script>
