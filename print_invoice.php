<?php
require_once "functions.php";

//getting the $InvoiceNo
$InvoiceNo = trim($_REQUEST['InvoiceNo']);


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
    // print_r($row_InvoiceDetails);
}

//getting the currency
if ($row_Invoices->USD == 0 || $row_Invoices->USD == NULL) {
    $currency = 'MMK';
}
elseif ($row_Invoices->MMK == 0 || $row_Invoices->MMK == NULL) {
    $currency = 'USD';
}
else {
    echo "There was an error processing! Please contact the system administrator!";
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="Shortcut icon" href="images/Logo_small.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo "Invoice No & Reference; "?></title>

    </head>
    <body>

    </body>
</html>
