<!-- service form -->
<div class="service form">
    <form class="#" action="#" method="post">
        <ul>
            <li class="bold">
                Airline:
                <? echo $row_Services->Name; ?>
            </li>
            <li>
                Date:
                <input type="date" name="Date_in" value="<? echo $Date_in; ?>">
            </li>
            <li>
                Pax:
                <input type="number" name="Pax" value="<? echo $row_Bookings->Pax; ?>">
            </li>
            <li>
                Flight No:
                <input type="text" name="Flight_no" id="Flight_no" value="">
            </li>
            <li>
                From:
                <select name="Pick_up">
                    <?php
                    // getting data from the table Cities
                    $rows_Cities = table_Cities('select_all', NULL, NULL);
                    foreach ($rows_Cities as $row_Cities) {
                        if ($row_Cities->City == $row_Services_booking->Pick_up) {
                            echo "<option value=\"$row_Cities->City\" selected>".$row_Cities->AirportCode." - ".$row_Cities->City."</option>";
                        }
                        else {
                            echo "<option value=\"$row_Cities->City\">".$row_Cities->AirportCode." - ".$row_Cities->City."</option>";
                        }
                    }
                    ?>
                </select>
            </li>
        </ul>
    </form>
</div>
<!-- end of service form -->
