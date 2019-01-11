<?php
require_once "functions.php";

//getting data from the table Corporates
$rows_Corporates = table_Corporates('select', NULL, NULL);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = 'Report: Bookings';
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = $page_title;
            include "includes/header.html";
            include "includes/nav.html";
            ?>
            <main>
                <!-- search -->
                <div class="search">
                    <form action="#" method="post">
                        <ul>
                            <li class="bold">Enter Search Criteria</li>
                            <li>
                                Bookings From:
                                <input type="date" name="BookingDate1" value="<? echo $BookingDate1; ?>">
                                &nbsp;
                                Until:
                                <input type="date" name="BookingDate2" value="<? echo $BookingDate2; ?>">
                            </li>
                            <li>
                                Corporates:
                                <select name="CorporatesId">
                                    <option value="">Select One</option>
                                    <?php
                                    foreach ($rows_Corporates as $row_Corporates) {
                                        if ($CorporatesId == $row_Corporates->Id) {
                                            echo "<option value=\"$row_Corporates->Id\" selected>".$row_Corporates->Name."</option>";
                                        }
                                        else {
                                            echo "<option value=\"$row_Corporates->Id\">".$row_Corporates->Name."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                &nbsp;
                                Status:
                                <select name="Status">
                                    <?php
                                    switch ($Status) {
                                        case 'Confirmed':
                                            echo "<option value=\"Confirmed\" selected>Confirmed</option>";
                                            echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                            break;

                                        case 'Not Confirmed':
                                            echo "<option value=\"Confirmed\">Confirmed</option>";
                                            echo "<option value=\"Not Confirmed\" selected>Not Confirmed</option>";
                                            break;

                                        default:
                                            echo "<option value=\"\">Select One</option>";
                                            echo "<option value=\"Confirmed\">Confirmed</option>";
                                            echo "<option value=\"Not Confirmed\">Not Confirmed</option>";
                                            break;
                                    }
                                    ?>
                                </select>
                            </li>
                            <li>
                                <input type="text" name="search" placeholder="Search" value="<? if (!empty($search)) { echo $search; } ?>">
                            </li>
                            <li>
                                <button type="submit" class="button submit" name="buttonSubmit">Search</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of search -->
                <!-- report table  -->
                <!-- TODO -->
                <!-- end of report table -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
