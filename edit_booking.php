<?php
require_once "functions.php";

//getting BookingsId
$BookingsId = trim($_REQUEST['BookingsId']);

//getting data from the table Bookings
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rowCount = table_Bookings('check_before_update', $BookingsId, NULL);

    if ($rowCount == 0) {
        table_Bookings ('update', $BookingsId, NULL);
    }
    else {
        $error = "Duplicate Entry!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Edit Booking: '.$row_Bookings->Reference;
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            include "includes/nav.html";
            $header = $page_title;
            include "includes/header.html";
            ?>
            <main>
                <!-- booking form -->
                <div class="booking form">
                    <form action="#" method="post">
                        <ul>
                            <li>
                                Booking Name:
                                <input type="text" name="Name" id="Name" value="<? echo $row_Bookings->Name; ?>" required>
                            </li>
                            <li>
                                Corporates:
                                <select id="CorporatesId" name="CorporatesId">
                                    <?php
                                    $rows_Corporates = table_Corporates ('select_all', NULL, NULL);
                                    foreach ($rows_Corporates as $row_Corporates) {
                                        if ($row_Corporates->Id == $row_Bookings->CorporatesId) {
                                            echo "<option value=\"$row_Corporates->Id\" selected>".$row_Corporates->Name."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_Corporates->Id\">".$row_Corporates->Name."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Arrival Date:
                                <input type="date" name="ArvDate" id="ArvDate" value="<? echo $row_Bookings->ArvDate; ?>">
                            </li>
                            <li>
                                Number of Pers:
                                <input type="number" name="Pax" min="1" max="999" id="Pax" value="<? echo $row_Bookings->Pax; ?>">
                            </li>
                            <li>
                                Booking Status:
                                <select name="Status">
                                    <?php
                                    switch ($row_Bookings->Status) {
                                        case 'Confirmed':
                                            echo "<option value=\"Confirmed\" selected>Confirmed</option>";
                                            echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                            echo "<option value=\"Cancelled\">Cancelled</option>";
                                            break;

                                        case 'Not Confirmed':
                                        echo "<option value=\"Confirmed\">Confirmed</option>";
                                        echo "<option value=\"Not Confirmed\" selected>Not Confirmed</option>";
                                        echo "<option value=\"Cancelled\">Cancelled</option>";
                                            break;

                                        case 'Cancelled':
                                        echo "<option value=\"Confirmed\">Confirmed</option>";
                                        echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                        echo "<option value=\"Cancelled\" selected>Cancelled</option>";
                                            break;

                                        default:
                                            // code...
                                            break;
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                Remark:
                                <input type="text" name="Remark" value="<? echo $row_Bookings->Remark; ?>">
                            </li>
                            <li>
                                Exchange:
                                <input type="number" name="Exchange" step="0.01" value="<? echo $row_Bookings->Exchange; ?>">
                            </li>
                            <li class="error">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" class="button submit" id="buttonSubmit" name="buttonSubmit" onclick="checkThreeFields('Name', 'ArvDate', 'Pax');">Update</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of booking form -->
            </main>
            <?php include "includes/footer.html"; ?>
        </div>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
