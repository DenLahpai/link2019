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
                                Service:
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
