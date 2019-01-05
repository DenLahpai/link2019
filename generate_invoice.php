<?php
require_once "functions.php";

//getting invoice data
$InvoiceNo = $_REQUEST['InvoiceNo'];

//getting data from the table Invoices
$rows_Invoices = table_Invoices('select_one', $InvoiceNo, NULL);
foreach ($rows_Invoices as $row_Invoices) {
    $BookingsId = $row_Invoices->BookingsId;
}

//getting data from the table Bookings
$rows_Bookings = table_Bookings('select_one', $BookingsId, NULL);
foreach ($rows_Bookings as $row_Bookings) {
    // code...
}

//getting data from the table InvoiceHeader
$rows_InvoiceHeader = table_InvoiceHeader('select_one', $InvoiceNo, NULL);
foreach ($rows_InvoiceHeader as $row_InvoiceHeader) {
    // code...
}

$rows_InvoiceDetails = table_InvoiceDetails('select_one', $InvoiceNo, NULL);
foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
    print_r($row_InvoiceDetails);
    // TODO Resume Here
}
?>
