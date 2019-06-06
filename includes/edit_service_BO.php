<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Services('check_before_update_BO', $ServicesId, $row_Services->ServiceTypeId);
    if ($rowCount == 0) {
        table_Services('update_BO', $ServicesId, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}
?>
<!-- boat form -->
<div class="boat form">
    <form action="#" method="post">
        <ul>
            <li>
                Supplier:
                <select name="SupplierId" id="SupplierId">
                    <option value="">Select One</option>
                    <?php
                    $rows_Suppliers = table_Suppliers ('select', NULL, NULL);
                    foreach ($rows_Suppliers as $row_Suppliers) {
                        if ($row_Services->SupplierId == $row_Suppliers->Id) {
                            echo "<option value=\"$row_Suppliers->Id\" selected>".$row_Suppliers->Name."</option>";
                        }
                        else {
                            echo "<option value=\"$row_Suppliers->Id\">".$row_Suppliers->Name."</option>";
                        }
                    }
                    ?>
                </select>
            </li>
            <li>
                Service:
                <input type="text" name="Service" id="Service" value="<? echo $row_Services->Service; ?>">
            </li>
            <li>
                Max pax:
                <input type="number" name="MaxPax" id="MaxPax" value="<? echo $row_Services->MaxPax; ?>">
            </li>
            <li>
                Valid From:
                <input type="date" name="StartDate" id="StartDate" value="<? echo $row_Services->StartDate; ?>"onchange="compareDates('StartDate', 'EndDate');" onchange="compareDates('StartDate', 'EndDate');" required>
                &nbsp;
                Valid Until:
                <input type="date" name="EndDate" id="EndDate" value="<? echo $row_Services->EndDate?>" onchange="compareDates('StartDate', 'EndDate');" required>
            </li>
            <li class="bold">
                Cost
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_MMK" value="<? echo $row_Services->Cost1_USD; ?>">
                MMK:
                <input type="number" name="Cost1_MMK" id="Cost1_MMK" value="<? echo $row_Services->Cost1_MMK; ?>">
            </li>
            <li class="error">
                <?php
                if (!empty($error)) {
                    echo $error;
                }
                ?>
            </li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkThreeFields('SupplierId', 'Service', 'StartDate');">Submit</button>
            </li>
        </ul>
    </form>
</div>
<!-- end of boat form -->
