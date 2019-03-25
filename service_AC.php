<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Serice Hotel";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Service: Hotel";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- hotel form -->
                <div class="hotel form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Supplier:
                                <select name="SupplierId">
                                    <option value="">Select One</option>
                                    <?php
                                    $rows_Suppliers = table_Suppliers ('select', NULL, NULL);
                                    foreach ($rows_Suppliers as $row_Suppliers) {
                                        echo "<option value=\"$row_Suppliers->Id\">".$row_Suppliers->Name."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Room Type:
                                <input type="text" name="Service" id="Service">
                            </li>
                            <li>
                                Valid From:
                                <input type="date" name="StartDate" id="StartDate">
                            </li>
                            <li>
                                Valid Until:
                                <input type="date" name="EndDate" id="EndDate">
                            </li>
                            <li class="bold">
                                Cost for Double / Twin Room
                            </li>
                            <li>
                                USD: <input type="number" name="Cost1_USD" id="Cost1_USD" step="0.01a">
                                MMK: <input type="number" name="Cost1_MMK" id="Cost1_MMK">
                            </li>
                            <li class="bold">
                                Cost for Single Room
                            </li>
                            <li>
                                USD: <input type="number" name="Cost2_USD" id="Cost2_USD" step="0.01">
                                MMK: <input type="number" name="Cost2_MMK" id="Cost2_MMK">
                            </li>
                            <li class="bold">
                                Cost for Triple Room
                            </li>
                            <li>
                                USD: <input type="number" name="Cost3_USD" id="Cost3_USD" step="0.01">
                                MMK: <input type="number" name="Cost3_MMK" id="Cost3_MMK">
                            </li>
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of hotel form -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
