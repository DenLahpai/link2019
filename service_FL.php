<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Service Flight";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Serivce: Flight";
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- flight form -->
                <div class="flight form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Airline:
                                <select id="SupplierId" name="SupplierId">
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
                                Sector:
                                <input type="text" name="Service" id="Service" value="Manual Entry" readonly>
                            </li>
                            <li>
                                Valid From:
                                <input type="date" name="StartDate" id="StartDate" required>
                            </li>
                            <li>
                                Valid Until:
                                <input type="date" name="EndDate" id="EndDate" required>
                            </li>
                            <li>
                                Note: The cost would have to be entered manually in booking.
                            </li>
                            <li class="error">
                                <?php if (!empty($error)) { echo $error ;} ?>
                            </li>
                            <li>
                                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="insertServiceFlight();">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of flight form -->
            </main>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scritps.js"></script>
    <script type="text/javascript">

    </script>
</html>
