<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Services('check_before_update_FL', $ServicesId, $row_Services->ServiceTypeId);
    if ($rowCount == 0) {
        table_Services('update_FL', $ServicesId, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}
?>

<!-- flight form -->
<div class="flight form">
    <form action="#" method="post" id="myForm">
        <ul>
            <li>
                Airline:
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
                Sector:
                <input type="text" name="Service" id="Service" value="Manual Entry">
            </li>
            <li>
                Valid From:
                <input type="date" name="StartDate" id="StartDate" value="<? echo $row_Services->StartDate; ?>"onchange="compareDates('StartDate', 'EndDate');" onchange="compareDates('StartDate', 'EndDate');" required>
                &nbsp;
                Valid Until:
                <input type="date" name="EndDate" id="EndDate" value="<? echo $row_Services->EndDate?>" onchange="compareDates('StartDate', 'EndDate');" required>
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
<!-- end of flight form -->
