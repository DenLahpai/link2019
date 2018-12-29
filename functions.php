<?php
require_once "conn.php";

// checking if the user is logged in
if (empty($_SESSION['UsersId'])) {
    header("location: index.php");
    $_SESSION['msg_error'] = 'Session Expired!';
}

//function to generate Reference for booking
function generate_Reference () {
    $database = new Database();
    $query = "SELECT * FROM Bookings ;";
    $database->query($query);
    $r = $database->rowCount() + 1;
    if ($r <= 9 ) {
		$zeros = '00';
    	}
    	elseif ($r <= 99) {
    		$zeros = '0';
    	}
    	else {
    		$zeros = '';
    	}
	return $reference = 'LNK'.$zeros.$r;
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
                Reference,
                Name,
                CorporatesId,
                ArvDate,
                Pax,
                Status,
                Remark,
                Exchange,
                UserId
                ) VALUES (
                :Reference,
                :Name,
                :CorporatesId,
                :ArvDate,
                :Pax,
                :Status,
                :Remark,
                :Exchange,
                :UserId
                )
            ;";
            $database->query($query);
            $database->bind(':Reference', $var1);
            $database->bind(':Name', $Name);
            $database->bind(':CorporatesId', $CorporatesId);
            $database->bind(':ArvDate', $ArvDate);
            $database->bind(':Pax', $Pax);
            $database->bind(':Status', $Status);
            $database->bind(':Remark', $Remark);
            $database->bind(':Exchange', $Exchange);
            $database->bind(':UserId', $_SESSION['UsersId']);
            if ($database->execute()) {
                header("location: bookings.php");
            }
            break;

        case 'select':
            $query = "SELECT
                Bookings.Id,
                Bookings.Reference,
                Bookings.Name,
                Corporates.Name AS CorporatesName,
                Bookings.ArvDate,
                Bookings.Pax,
                Bookings.Status,
                Bookings.Remark,
                Bookings.Exchange,
                Users.Username,
                Users.Fullname,
                Bookings.created
                FROM Bookings
                LEFT JOIN Corporates
                ON Bookings.CorporatesId = Corporates.Id
                LEFT JOIN Users
                ON Bookings.UserId = Users.Id
            ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

            case 'select_one':
                $query =  "SELECT
                    Bookings.Id,
                    Bookings.Reference,
                    Bookings.Name,
                    Corporates.Name AS CorporatesName,
                    Bookings.ArvDate,
                    Bookings.Pax,
                    Bookings.Status,
                    Bookings.Remark,
                    Bookings.Exchange,
                    Users.Username,
                    Users.Fullname,
                    Bookings.created
                    FROM Bookings
                    LEFT JOIN Corporates
                    ON Bookings.CorporatesId = Corporates.Id
                    LEFT JOIN Users
                    ON Bookings.UserId = Users.Id
                    WHERE Bookings.Id = :BookingsId
                ;";
                $database->query($query);
                $database->bind(':BookingsId', $var1);
                return $r = $database->resultset();
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

// function to get data from the table Invoices
function table_Invoices ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_by_BookingsId':
            $query = "SELECT * FROM Invoices WHERE BookingsId = :BookingsId ;";
            $database->query($query);
            $database->bind(':BookingsId', $var1);
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}

// function to get data from the table Services_booking
function table_Services_booking ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_flights':
            $query = "SELECT
                Services_booking.Id AS Services_bookingId,
                Services_booking.ServicesId,
                Services_booking.Date_in,
                Services_booking.Pax,
                Services_booking.Flight_no,
                Services_booking.Pick_up,
                Services_booking.Drop_off,
                Services_booking.Pick_up_time,
                Services_booking.Drop_off_time,
                Services_booking.StatusId,
                Services_booking.Cfm_no,
                Services.Id AS ServicesId,
                Suppliers.Name AS SuppliersName,
                ServiceStatus.Status AS Status
                FROM Services_booking
                LEFT OUTER JOIN Services
                ON Services_booking.ServicesId = Services.Id
                LEFT OUTER JOIN Suppliers
                ON Services.SupplierId = Suppliers.Id
                LEFT OUTER JOIN ServiceStatus
                ON Services_booking.StatusId = ServiceStatus.Id
                WHERE Services.ServiceTypeId = '2'
                AND Services_booking.BookingsId = :BookingsId
            ;";

            $database->query($query);
            $database->bind(':BookingsId', $var1);
            return $r = $database->resultset();
            break;

        case 'select_one':
            $query = "SELECT
                Services_booking.BookingsId AS BookingsId,
                Services_booking.ServicesId,
                Services_booking.Date_in,
                Services_booking.Pax,
                Services_booking.Flight_no,
                Services_booking.Pick_up,
                Services_booking.Drop_off,
                Services_booking.Pick_up_time,
                Services_booking.Drop_off_time,
                Services_booking.StatusId,
                Services_booking.Cfm_no,
                Services_booking.StatusId,
                Services.Id AS ServicesId,
                Services.ServiceTypeId AS ServiceTypeId,
                Suppliers.Name AS SuppliersName,
                ServiceStatus.Status AS Status
                FROM Services_booking
                LEFT OUTER JOIN Services
                ON Services_booking.ServicesId = Services.Id
                LEFT OUTER JOIN Suppliers
                ON Services.SupplierId = Suppliers.Id
                LEFT OUTER JOIN ServiceStatus
                ON Services_booking.StatusId = ServiceStatus.Id
                WHERE Services_booking.Id = :Services_bookingId
            ;";
            $database->query($query);
            $database->bind(':Services_bookingId', $var1);
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}

//function to use the table Cities
function table_Cities ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_all':
            $query = "SELECT * FROM Cities ORDER BY Id ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}

// function to use the table ServiceStatus
function table_ServiceStatus ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_all':
            $query = "SELECT * FROM ServiceStatus ORDER BY Id ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}

?>
