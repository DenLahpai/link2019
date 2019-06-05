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
        </ul>
    </form>
</div>
<!-- end of boat form -->
