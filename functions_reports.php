<?php
require_once "functions.php";

############################# REPORTS #################################

// functions to get reports from the table Invoices
function report_Invoices() {
    $database = new Database();

    //getting data from the form
    $InvoiceDate1 = $_REQUEST['InvoiceDate1'];
    $InvoiceDate2 = $_REQUEST['InvoiceDate2'];
    $CorporatesId = $_REQUEST['CorporatesId'];
    $InvoicesStatus = $_REQUEST['InvoicesStatus'];
    $search = trim($_REQUEST['search']);
    $mySearch = '%'.$search.'%';

    if ($InvoiceDate2 == NULL || $InvoiceDate2 == "" ) {
        $InvoiceDate2 = $InvoiceDate1;
    }

    if ($InvoiceDate1 == NULL && $CorporatesId == NULL && $InvoicesStatus == NULL  && $search == NULL) {
        $n = 0000;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
        ;";
        $database->query($query);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId == NULL & $InvoicesStatus == NULL && $search != NULL) {
        $n = 0001;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 0010;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search == NULL) {
        $n = 0100;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search == NULL) {
        $n = 1000;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId == NULL && $InvoicesStatus != NULL & $search != NULL) {
        $n = 0011;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search != NULL) {
        $n = 0101;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 0110;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
            AND Invoices.Status <= :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search != NULL) {
        $n = 1001;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 1010;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 != NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search == NULL) {
        $n = 1100;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 == NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search != NULL) {
        $n = 0111;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Corporates.Id = :CorporatesId
            AND Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 != NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search != NULL) {
        $n = 1011;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 != NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search != NULL) {
        $n = 1101;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,:created2
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }

    elseif ($InvoiceDate1 != NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 1110;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
            AND Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        return $r = $database->resultset();
    }

    else {
        $n = 1111;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.USD,
            Invoices.MMK,
            Invoices.PaidOn,
            Invoices.Status,
            PaymentMethods.Method,
            Bookings.Reference,
            Bookings.Name As BookingsName,
            Corporates.Name AS CorporatesName
            FROM Invoices LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN PaymentMethods ON
            Invoices.MethodId = PaymentMethods.Id
            WHERE Invoices.InvoiceDate >= :InvoiceDate1
            AND Invoices.InvoiceDate <= :InvoiceDate2
            AND Corporates.Id = :CorporatesId
            AND Invoices.Status = :InvoicesStatus
            AND CONCAT(
            Invoices.InvoiceNo,
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':InvoiceDate1', $InvoiceDate1);
        $database->bind(':InvoiceDate2', $InvoiceDate2);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':mySearch', $mySearch);
        return $r = $database->resultset();
    }
}

//functions to get report from the table Bookings
function report_Bookings() {
    $database = new Database();
    $CorporatesId = $_REQUEST['CorporatesId'];
    $Status = $_REQUEST['Status'];
    $ArvDate1 = $_REQUEST['ArvDate1'];
    $ArvDate2 = $_REQUEST['ArvDate2'];
    $created1 = $_REQUEST['created1'];
    $created2 = $_REQUEST['created2'];
    $search = trim($_REQUEST['search']);
    $mySearch = '%'.$search.'%';

    if ($ArvDate2 == NULL) {
        $ArvDate2 = $ArvDate1;
    }

    if ($created2 == NULL) {
        $created2 = date('Y-m-d', strtotime($created1.'+'.'1'.'days'));
    }

    if ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL && $created1 == NULL && $search == NULL) {
        $num =  "00000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
        ;";
        $database->query($query);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL && $created1 == NULL && $search != NULL) {
        $num = "00001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL && $created1 != NULL && $search == NULL) {
        $num = "00010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL && $created1 == NULL && $search == NULL) {
        $num = "00100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL && $created1 == NULL && $search == NULL) {
        $num = "01000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL && $created1 == NULL && $search == NULL) {
        $num = "10000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "00011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind('created1', $created1);
        $database->bind('created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "00101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "00110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL & $created1 == NULL && $search != NULL) {
        $num = "01001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search == NULL) {
        $num = "01010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search == NULL) {
        $num = "01100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL & $created1 == NULL && $search != NULL) {
        $num = "10001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL & $created1 != NULL && $search == NULL) {
        $num = "10010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 == NULL && $search == NULL) {
        $num = "10100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 == NULL && $search == NULL) {
        $num = "11000";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
    }

    elseif ($CorporatesId == NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search != NULL) {
        $num = "00111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "01011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "01101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "01110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "10011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "10101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "10110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 == NULL && $search != NULL) {
        $num = "11001";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search == NULL) {
        $num = "11010";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search == NULL) {
        $num = "11100";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
    }

    elseif ($CorporatesId == NULL && $Status != NULL && $ArvDate1 != NULL & $created1 != NULL && $search != NULL) {
        $num = "01111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status == NULL && $ArvDate1 != NULL & $created1 != NULL && $search != NULL) {
        $num = "10111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 == NULL & $created1 != NULL && $search != NULL) {
        $num = "11011";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 != NULL & $created1 == NULL && $search != NULL) {
        $num = "11101";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($CorporatesId != NULL && $Status != NULL && $ArvDate1 != NULL & $created1 != NULL && $search == NULL) {
        $num = "11110";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
    }

    else {
        $num = "11111";
        $query = "SELECT
            Bookings.Id AS BookingsId,
            Bookings.Reference,
            Bookings.Name AS BookingsName,
            Corporates.Name AS CorporatesName,
            Bookings.ArvDate,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username,
            Bookings.created
            FROM Bookings LEFT OUTER JOIN Corporates ON
            Bookings.CorporatesId = Corporates.Id
            LEFT OUTER JOIN Users ON
            Bookings.UserId = Users.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND Bookings.Status = :Status
            AND Bookings.ArvDate >= :ArvDate1
            AND Bookings.ArvDate <= :ArvDate2
            AND Bookings.created >= :created1
            AND Bookings.created <= :created2
            AND CONCAT(
            Bookings.Reference,
            Bookings.Name,
            Corporates.Name,
            Bookings.Pax,
            Bookings.Status,
            Bookings.Remark,
            Users.Username
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Status', $Status);
        $database->bind(':ArvDate1', $ArvDate1);
        $database->bind(':ArvDate2', $ArvDate2);
        $database->bind(':created1', $created1);
        $database->bind(':created2', $created2);
        $database->bind(':mySearch', $mySearch);
    }
    return $r = $database->resultset();
}

//function to get report of Invoice Details
function report_Invoice_Details () {
    $database = new Database();

    $Date1 = $_REQUEST['Date1'];
    $Date2 = $_REQUEST['Date2'];
    $CorporatesId = $_REQUEST['CorporatesId'];
    $InvoicesStatus = $_REQUEST['InvoicesStatus'];
    $search = trim($_REQUEST['search']);
    $mySearch = '%'.$search.'%';

    if ($Date2 == NULL) {
        $Date2 = $Date1;
    }

    if ($Date1 == NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search == NULL) {
        $n = 0000;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
        ;";
        $database->query($query);
    }
    elseif ($Date1 == NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search != NULL) {
        $n = 0001;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($Date1 == NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 0010;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
    }

    elseif ($Date1 == NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search == NULL) {
        $n = 0100;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE Bookings.CorporatesId = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
    }

    elseif ($Date1 != NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search == NULL) {
        $n = 1000;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':Date1', $Date1);
        $database->bind(':Date2', $Date2);
    }

    elseif ($Date1 == NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search != NULL) {
        $n = 0011;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
            AND Invoices.Status = :InvoicesStatus
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
    }

    elseif ($Date1 == NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search != NULL) {
        $n = 0101;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
            AND Bookings.CorporatesId = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':CorporatesId', $CorporatesId);
    }

    elseif ($Date1 == NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 0110;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE Invoices.Status = :InvoicesStatus
            AND Bookings.CorporatesId = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':CorporatesId', $CorporatesId);
    }

    elseif ($Date1 != NULL && $CorporatesId == NULL && $InvoicesStatus == NULL && $search != NULL) {
        $n = 1001;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
            AND InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind('Date1', $Date1);
        $database->bind('Date2', $Date2);
    }

    elseif ($Date1 != NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 1010;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE Inovices.Status = :InvoicesStatus
            AND InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':Date1', $Date1);
        $database->bind(':Date2', $Date2);
    }

    elseif ($Date1 != NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search == NULL) {
        $n = 1100;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE Bookings.CorporatesId = :CorporatesId
            AND InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Date1', $Date1);
        $database->bind(':Date2', $Date2);
    }

    elseif ($Date1 == NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search != NULL) {
        $n = 0111;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
            AND Invoices.Status = :InvoicesStatus
            AND Bookings.CorporatesId = :CorporatesId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':CorporatesId', $CorporatesId);
    }

    elseif ($Date1 != NULL && $CorporatesId == NULL && $InvoicesStatus != NULL && $search != NULL) {
        $n = 1011;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
            AND Invoices.Status = :InvoicesStatus
            AND InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':Date1', $Date1);
        $database->bind(':Date2', $Date2);
    }

    elseif ($Date1 != NULL && $CorporatesId != NULL && $InvoicesStatus == NULL && $search != NULL) {
        $n = 1101;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
            AND Bookings.CorporatesId = :CorporatesId
            AND InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Date1', $Date1);
        $database->bind(':Date2', $Date2);
    }
    elseif ($Date1 != NULL && $CorporatesId != NULL && $InvoicesStatus != NULL && $search == NULL) {
        $n = 1110;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE Invoices.Status = :InvoicesStatus
            AND Bookings.CorporatesId = :CorporatesId
            AND InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Date1', $Date1);
        $database->bind(':Date2', $Date2);
    }

    else {
        $n = 1111;
        $query = "SELECT
            Invoices.InvoiceNo,
            Invoices.InvoiceDate,
            Invoices.Status,
            Invoices.MethodId,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Date,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK,
            PaymentMethods.Method
            FROM InvoiceDetails
            LEFT OUTER JOIN Invoices
            ON Invoices.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN InvoiceHeader
            ON InvoiceHeader.InvoiceNo = InvoiceDetails.InvoiceNo
            LEFT OUTER JOIN PaymentMethods
            ON Invoices.MethodId = PaymentMethods.Id
            LEFT OUTER JOIN Bookings
            ON Invoices.BookingsId = Bookings.Id
            WHERE CONCAT(
            Invoices.InvoiceNo,
            Bookings.Name,
            Bookings.Reference,
            InvoiceHeader.Addressee,
            InvoiceHeader.Attn,
            InvoiceDetails.Description,
            InvoiceDetails.USD,
            InvoiceDetails.MMK
            ) LIKE :mySearch
            AND Invoices.Status = :InvoicesStatus
            AND Bookings.CorporatesId = :CorporatesId
            AND InvoiceDetails.Date >= :Date1
            AND InvoiceDetails.Date <= :Date2
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':InvoicesStatus', $InvoicesStatus);
        $database->bind(':CorporatesId', $CorporatesId);
        $database->bind(':Date1', $Date1);
        $database->bind(':Date2', $Date2);
    }

    return $r = $database->resultset();
}

// report for services_booking
function report_Services_booking () {
    $database = new Database();
    $ServiceDate1 = $_REQUEST['ServiceDate1'];
    $ServiceDate2 = $_REQUEST['ServiceDate2'];
    if (empty($ServiceDate2)) {
        $ServiceDate2 = $ServiceDate1;
    }
    $ServiceTypeId = $_REQUEST['ServiceTypeId'];
    $StatusId = $_REQUEST['StatusId'];
    $SuppliersId = $_REQUEST['SuppliersId'];
    $search = trim($_REQUEST['search']);
    $mySearch = '%'.$search.'%';
    $query = "SELECT
        Bookings.Reference,
        Bookings.Name AS BookingsName,
        Bookings.ArvDate,
        ServiceType.Code AS ServiceTypeCode,
        Suppliers.Name AS SuppliersName,
        Services.Service,
        Services.Additional,
        Services_booking.Date_in,
        Services_booking.Date_out,
        Services_booking.Pax,
        Services_booking.Pick_up,
        Services_booking.Drop_off,
        Services_booking.Pick_up_time,
        Services_booking.Drop_off_time,
        Services_booking.Spc_rq,
        ServiceStatus.Code AS ServiceStatusCode,
        Services_booking.Cfm_no
        FROM Services_booking
        LEFT OUTER JOIN Bookings ON Services_booking.BookingsId = Bookings.Id
        LEFT OUTER JOIN Services ON Services_booking.ServicesId = Services.Id
        LEFT OUTER JOIN ServiceType ON Services.ServiceTypeId = ServiceType.Id
        LEFT OUTER JOIN Suppliers ON Services.SupplierId = Suppliers.Id
        LEFT OUTER JOIN ServiceStatus ON Services_booking.StatusId = ServiceStatus.Id
    ";

    if ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId == NULL && $SuppliersId == NULL && $search == NULL) {
        $n = '00000';
        $database->query($query);

    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId == NULL && $SuppliersId == NULL && $search != NULL) {
        $n = '00001';
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId == NULL && $SuppliersId != NULL && $search == NULL) {
        $n = '00010';
        $query .= " WHERE Suppliers.Id = :SuppliersId ;";
        $database->query($query);
        $database->bind(':SuppliersId', $SuppliersId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId != NULL && $SuppliersId == NULL && $search == NULL) {
        $n = '00100';
        $query .= " WHERE Services_booking.StatusId = :StatusId ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId == NULL && $search == NULL) {
        // TODO resume checking from here
        $n = 01000;
        $query .= " WHERE Services.ServiceTypeId = :ServiceTypeId ;";
        $database->query($query);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId == NULL && $search == NULL) {
        $n = 10000;
        $query .= " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_out <= :ServiceDate2
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId == NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 00011;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':SuppliersId', $SupplierId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId != NULL && $SuppliersId == NULL && $search != NULL) {
        $n = 00101;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId != NULL && $SuppliersId != NULL && $search == NULL) {
        $n = 00110;
        $query .= " WHERE
            Suppliers.Id = :SuppliersId
            AND Services_booking.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':SuppliersId', $SuppliersId);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId == NULL && $search != NULL) {
        $n = 01001;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services.ServiceTypeId = :ServiceTypeId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId != NULL && $search == NULL) {
        $n = 01010;
        $query .= " WHERE Suppliers.Id = :SuppliersId
            AND Services.ServiceTypeId = :ServiceTypeId
        ;";
        $database->query($query);
        $database->bind(':SuppliersId', $SuppliersId);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId == NULL && $search == NULL) {
        $n = 01100;
        $query .= " WHERE Services_booking.StatusId = :StatusId
            AND Services.ServiceTypeId = :ServiceTypeId
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId == NULL && $StatusId == NULL && $SuppliersId == NULL && $search != NULL) {
        $n = 10001;
        $query .= "  WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            ;";
            $database->query($query);
            $database->bind(':mySearch', $mySearch);
            $database->bind(':ServiceDate1', $ServiceDate1);
            $database->bind(':ServiceDate2', $ServiceDate2);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId == NULL && $StatusId == NULL && $SuppliersId != NULL && $search == NULL) {
        $n = 10010;
        $query .= " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_out <= :ServiceDate2
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':SuppliersId', $SuppliersId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId == NULL && $StatusId != NULL && $SuppliersId == NULL && $search == NULL) {
        $n = 10100;
        $query .= " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services_booking.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId == NULL && $search == NULL) {
        $n = 11000;
        $query .= " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId == NULL && $StatusId != NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 00111;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Suppliers.Id = :SuppliersId
            AND Services_booking.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':SuppliersId', $SuppliersId);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 01011;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Suppliers.Id = :SuppliersId
            AND Services.ServiceTypeId = :ServiceTypeId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':SuppliersId', $SuppliersId);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId == NULL && $search != NULL) {
        $n = 01101;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Suppliers.Id = :SuppliersId
            AND Services_booking.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':SuppliersId', $SuppliersId);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId != NULL && $search == NULL) {
        $n = 01110;
        $query .= " WHERE Services.ServiceTypeId = :ServiceTypeId
            AND Services_booking.StatusId = :StatusId
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':SuppliersId', $SuppliersId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId == NULL && $StatusId == NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 10011;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Suppliers.Id = :SuppliersId
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':SuppliersId', $SuppliersId);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId == NULL && $StatusId != NULL && $SuppliersId == NULL && $search != NULL) {
        $n = 10101;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.StatusId = :StatusId
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId == NULL && $search == NULL) {
        $n = 10110;
        $query = " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
            AND Services_booking.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId == NULL && $search != NULL) {
        $n = 11001;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId != NULL && $search == NULL) {
        $n = 11010;
        $query .= " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':SuppliersId', $SuppliersId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId == NULL && $search == NULL) {
        $n = 11100;
        $query .= " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
            AND Services_booking.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($ServiceDate1 == NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 01111;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services.ServiceTypeId = :ServiceTypeId
            AND Services_booking.StatusId = :StatusId
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':SuppiersId', $SupplierId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId == NULL && $StatusId != NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 10111;
        $query .=  " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services_booking.StatusId = :StatusId
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':StatusId', $StatusId);
        $database->bind('SuppliersId', $SupplierId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId == NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 11011;
        $query .=  " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':SuppliersId', $SupplierId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId == NULL && $search != NULL) {
        $n = 11101;
        $query .=  " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services_booking.StatusId = :StatusId
            AND Services.ServiceTypeId = :ServiceTypeId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId != NULL && $search == NULL) {
        $n = 11110;
        $query .=  " WHERE Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
            AND Services_booking.StatusId = :StatusId
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':SuppliersId', $SupplierId);
    }

    elseif ($ServiceDate1 != NULL && $ServiceTypeId != NULL && $StatusId != NULL && $SuppliersId != NULL && $search != NULL) {
        $n = 11111;
        $query .= " WHERE CONCAT (
            Bookings.Reference,
            Bookings.Name,
            Suppliers.Name,
            Services.Service,
            Services.Additional,
            Services_booking.Pick_up,
            Services_booking.Drop_off,
            Services_booking.Spc_rq,
            Services_booking.Cfm_no,
            Services_booking.Remark
            ) LIKE :mySearch
            AND Services_booking.Date_in >= :ServiceDate1
            AND Services_booking.Date_in <= :ServiceDate2
            AND Services.ServiceTypeId = :ServiceTypeId
            AND Services_booking.StatusId = :StatusId
            AND Suppliers.Id = :SuppliersId
        ;";
        $database->query($query);
        $database->bind(':mySearch', $mySearch);
        $database->bind(':ServiceDate1', $ServiceDate1);
        $database->bind(':ServiceDate2', $ServiceDate2);
        $database->bind(':ServiceTypeId', $ServiceTypeId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':SuppliersId', $SupplierId);
    }
    return $r = $database->resultset();
}
?>
