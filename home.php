<?php
require "functions.php";
$rowCount = 0;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Booking";
    include "includes/head.html";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rowCount = table_Bookings('check', NULL, NULL);
        if ($rowCount == 0) {
            echo $Reference = generate_Reference();
            table_Bookings('insert', $Reference, NULL);
        }
    }
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = "New Booking";
            include "includes/header.html";
            ?>
            <main>
                <!-- booking form -->
                <div class="booking form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Booking Name:
                                <input type="text" name="Name" id="Name" placeholder="Booking Name" required>
                            </li>
                            <li>
                                Corporates:
                                <select name="CorporatesId" id="CorporatesId">
                                    <option value="0">Select</option>
                                    <?php
                                    $rows_Corporates = table_Corporates ('select', NULL, NULL);
                                    foreach ($rows_Corporates as $row_Corporates) {
                                        echo "<option value=\"$row_Corporates->Id\">".$row_Corporates->Name."</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Arrival Date:
                                <input type="date" name="ArvDate" id="ArvDate" required>
                            </li>
                            <li>
                                Number of Pers:
                                <input type="number" name="Pax" min="1" max="999" id="Pax" required>
                            </li>
                            <li>
                                Booking Status:
                                <select name="Status">
                                    <option value="Confirmed">Confirmed</option>
                                    <option value="Not Confirmed">Not Confirmed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </li>
                            <li>
                                Remark:
                                <input type="text" name="Remark" >
                            </li>
                            <li>
                                Exchange:
                                <input type="number" name="Exchange" step="0.01" placeholder="1 USD to MMK" required>
                            </li>
                            <li class="error">
                                <?php
                                if ($rowCount > 0) {
                                    echo "Duplicate Entry!";
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Name', 'ArvDate', 'Pax');">Submit</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of booking form -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
