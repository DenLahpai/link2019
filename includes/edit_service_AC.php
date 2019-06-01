<!-- hotel form -->
<div class="hotel form">
    <form class="" action="#" method="post">
        <ul>
            <li>
                Hotel:
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
                Room Type:
                <input type="text" name="Service" id="Service" value="<? echo $row_Services->Service; ?>" required>
            </li>
            <li>
                Valid From:
                <input type="date" name="StartDate" id="EndDate" value="<? echo $row_Services->StartDate;?>" required>
                &nbsp;
                Valid Until:
                <input type="date" name="EndDate" id="EndDate" value="<? echo $row_Services->EndDate?>" required>
            </li>
            <li class="bold">
                Cost for Double or Twin Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost1_USD" id="Cost1_USD" value="<? echo $row_Services->Cost1_USD; ?>">
                &nbsp;
                MMK:
                <input type="number" name="Cost1_MMK" id="Cost1_MMK" value="<? echo $row_Services->Cost1_MMK; ?>">
            </li>
            <li class="bold">
                Cost for Single Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost2_USD" id="Cost2_USD" value="<? echo $row_Services->Cost2_USD; ?>">
                &nbsp;
                MMK:
                <input type="number" name="Cost2_MMK" id="Cost2_MMK" value="<? echo $row_Services->Cost2_MMK; ?>">
            </li>
            <li class="bold">
                Cost for Triple Room
            </li>
            <li>
                USD:
                <input type="number" step="0.01" name="Cost3_USD" id="Cost3_USD" value="<? echo $row_Services->Cost3_USD; ?>">
                &nbsp;
                <input type="number" name="Cost3_MMK" id="Cost3_MMK" value="<? echo $row_Services->Cost3_MMK; ?>">
            </li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="<?//TODO ?>">Submit</button>
            </li>
        </ul>
    </form>
</div>
<!-- end fo hotel form -->
