<?php
require_once "functions.php";
$BookingsId = trim($_REQUEST['BookingsId']);
if (!is_numeric($BookingsId)) {
    echo "There was a problem! Please go back and try again!";
    die();
}
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // codes...
}
?>
