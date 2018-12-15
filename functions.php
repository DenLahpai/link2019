<?php
require_once "conn.php";

//function to generate Reference for booking
function generate_Reference () {
    $database = new Database();

}

//function to use the data from the table Bookings
function table_Bookings ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'check':
            //getting data to check for duplicated entry
            $Name = trim($_REQUEST['Name']);
            $ArvDate = $_REQUEST['ArvDate'];
            $Pax = $_REQUEST['Pax'];

            $query = "SELECT * FROM Bookings WHERE
                Name = :Name AND
                ArvDate = :ArvDate AND
                Pax = :Pax
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':ArvDate', $ArvDate);
            $database->bind(':Pax', $Pax);
            return $r = $database->rowCount();
            break;

        case 'insert':
            $Name = trim($_REQUEST['Name']);
            $CorporatesId = $_REQUEST['CorporatesId'];
            $ArvDate = $_REQUEST['ArvDate'];
            $Pax = $_REQUEST['Pax'];
            $Status = $_REQUEST['Status'];
            $Remark = trim($_REQUEST['Remark']);
            $Exchange = trim($_REQUEST['Exchange']);

            $query = "INSERT INTO Bookings (
                Name,
                CorporatesId,
                
                ) VALUES (

                )
            ;";


            break;

        default:
            // code...
            break;
    }
}

// function the get data from the table Corporates
function table_Corporates ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select':
            $query = "SELECT * FROM Corporates ORDER BY Name ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}


?>
