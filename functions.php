<?php
require_once "conn.php";

// checking if the user is logged in
if (empty($_SESSION['UsersId'])) {
    header("location: index.php");
    $_SESSION['msg_error'] = 'Session Expired!';
}

//function to use data from the table Users
function table_Users($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_one':
            $query = "SELECT * FROM Users WHERE Id = :Id ;";
            $database->query($query);
            $database->bind(':Id', $var1);
            return $r = $database->resultset();
            break;

        default:
            //code...
            break;
    }
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

        case 'check_before_update':
            //getting data to check for duplicated entry
            $Name = trim($_REQUEST['Name']);
            $ArvDate = $_REQUEST['ArvDate'];
            $Pax = $_REQUEST['Pax'];

            $query = "SELECT * FROM Bookings
                WHERE Name = :Name
                AND ArvDate = :ArvDate
                AND Pax = :Pax
                AND Id != :BookingsId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':ArvDate', $ArvDate);
            $database->bind(':Pax', $Pax);
            $database->bind(':BookingsId', $var1);
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
                ORDER BY Bookings.Id DESC
            ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            $query =  "SELECT
                Bookings.Id,
                Bookings.Reference,
                Bookings.Name,
                Bookings.CorporatesId,
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

        case 'update':
            // getting data from the form
            $Name = trim($_REQUEST['Name']);
            $CorporatesId = $_REQUEST['CorporatesId'];
            $ArvDate = $_REQUEST['ArvDate'];
            $Pax = $_REQUEST['Pax'];
            $Status = $_REQUEST['Status'];
            $Remark = trim($_REQUEST['Remark']);
            $Exchange = trim($_REQUEST['Exchange']);

            $query = "UPDATE Bookings SET
                Name = :Name,
                CorporatesId = :CorporatesId,
                ArvDate = :ArvDate,
                Pax = :Pax,
                Status = :Status,
                Remark = :Remark,
                Exchange = :Exchange
                WHERE Id = :var1

            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':CorporatesId', $CorporatesId);
            $database->bind(':ArvDate', $ArvDate);
            $database->bind(':Pax', $Pax);
            $database->bind(':Status', $Status);
            $database->bind(':Remark', $Remark);
            $database->bind(':Exchange', $Exchange);
            $database->bind(':var1', $var1);
            if ($database->execute()) {
                header("location: bookings.php");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use the table Countries
function table_Countries ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_all':
            $query = "SELECT * FROM Countries ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            $query = "SELECT * FROM Countries WHERE Id = :CountriesId ;";
            $database->query($query);
            $database->bind(':CountriesId', $var1);
            return $r = $database->resultset();
            break;

        case 'check':
            //getting data from the form
            $Code = $_REQUEST['Code'];
            $Country = trim($_REQUEST['Country']);

            $query = "SELECT * FROM Countries
                WHERE Code = :Code
                OR Country = :Country
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':Country', $Country);
            return $r = $database->rowCount();
            break;


        case 'insert':
            //getting data from the form
            $Code = $_REQUEST['Code'];
            $Country = trim($_REQUEST['Country']);
            $Region = trim($_REQUEST['Region']);

            $query = "INSERT INTO Countries (
                Code,
                Country,
                Region
                ) VALUES (
                :Code,
                :Country,
                :Region
                )
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':Country', $Country);
            $database->bind(':Region', $Region);
            $database->execute();
            break;

        case 'check_before_update':
            //getting data from the form
            $Code = $_REQUEST['Code'];
            $Country = trim($_REQUEST['Country']);

            $query = "SELECT * FROM Countries
                WHERE (Code = :Code
                OR Country = :Country)
                AND Id != :CountriesId
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':Country', $Country);
            $database->bind(':CountriesId', $var1);
            return $r = $database->rowCount();
            break;


        case 'update':
            //getting data from the form
            $Code = $_REQUEST['Code'];
            $Country = trim($_REQUEST['Country']);
            $Region = trim($_REQUEST['Region']);

            $query = "UPDATE Countries SET
                Code = :Code,
                Country = :Country,
                Region = :Region
                WHERE Id = :CountriesId
            ;";
            $database->query($query);
            $database->bind(':Code', $Code);
            $database->bind(':Country', $Country);
            $database->bind(':Region', $Region);
            $database->bind(':CountriesId', $var1);
            if ($database->execute()) {
                header("location: countries.php");
            }
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
            $query = "SELECT
                Cities.Id,
                Cities.AirportCode,
                Cities.City,
                Countries.Country
                FROM Cities
                LEFT OUTER JOIN Countries
                ON Cities.CountryCode = Countries.Code
            ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            $query = "SELECT
                Cities.Id,
                Cities.AirportCode,
                Cities.City,
                Cities.CountryCode,
                Countries.Country
                FROM Cities
                LEFT OUTER JOIN Countries
                ON Cities.CountryCode = Countries.Code
                WHERE Cities.Id = :CitiesId
            ;";
            $database->query($query);
            $database->bind(':CitiesId', $var1);
            return $r = $database->resultset();
            break;

        case 'check':
                // getting data from the form
                $AirportCode = trim($_REQUEST['AirportCode']);

                $query = "SELECT * FROM Cities WHERE AirportCode = :AirportCode ;";
                $database->query($query);
                $database->bind(':AirportCode', $AirportCode);
                return $r = $database->rowCount();
                break;

        case 'insert':
            // getting data from the form
            $AirportCode = trim($_REQUEST['AirportCode']);
            $City = trim($_REQUEST['City']);
            $CountryCode = $_REQUEST['CountryCode'];

            $query = "INSERT INTO Cities (
                AirportCode,
                City,
                CountryCode
                ) VALUES (
                :AirportCode,
                :City,
                :CountryCode
                )
            ;";
            $database->query($query);
            $database->bind(':AirportCode', $AirportCode);
            $database->bind(':City', $City);
            $database->bind(':CountryCode', $CountryCode);
            $database->execute();
            break;

        case 'check_before_update':
            $AirportCode = trim($_REQUEST['AirportCode']);

            $query = "SELECT * FROM Cities
                WHERE AirportCode = :AirportCode
                AND Id != :CitiesId
            ;";
            $database->query($query);
            $database->bind(':AirportCode', $AirportCode);
            $database->bind(':CitiesId', $var1);
            return $r = $database->rowCount();
            break;

        case 'update':
            //getting data from the form
            $AirportCode = trim($_REQUEST['AirportCode']);
            $City = trim($_REQUEST['City']);
            $CountryCode = $_REQUEST['CountryCode'];

            $query = "UPDATE Cities SET
                AirportCode = :AirportCode,
                City = :City,
                CountryCode = :CountryCode
                WHERE Id = :CitiesId
            ;";
            $database->query($query);
            $database->bind(':AirportCode', $AirportCode);
            $database->bind(':City', $City);
            $database->bind(':CountryCode', $CountryCode);
            $database->bind(':CitiesId', $var1);
            if ($database->execute()) {
                header("location: cities.php");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use the table Suppliers
function table_Suppliers ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'check':
            //getting data from the form
            $Name = trim($_REQUEST['Name']);
            $City = trim($_REQUEST['City']);

            $query = "SELECT * FROM Suppliers
                WHERE Name = :Name
                AND City = :City
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':City', $City);
            return $r = $database->rowCount();
            break;

        case 'check_before_update':
            // getting data from the form
            $Name = trim($_REQUEST['Name']);
            $City = trim($_REQUEST['City']);

            $query = "SELECT * FROM Suppliers
                WHERE Name = :Name
                AND City = :City
                AND Id != :SuppliersId
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':City', $City);
            $database->bind(':SuppliersId', $var1);
            return $r = $database->rowCount();

            break;


        case 'insert':
            // getting data from the form
            $Name = trim($_REQUEST['Name']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
            $Email = trim($_REQUEST['Email']);
            $Phone = trim($_REQUEST['Phone']);
            $Fax = trim($_REQUEST['Fax']);
            $Website = trim($_REQUEST['Website']);

            $query = "INSERT INTO Suppliers (
                Name,
                Address,
                City,
                Email,
                Phone,
                Fax,
                Website
                ) VALUES (
                :Name,
                :Address,
                :City,
                :Email,
                :Phone,
                :Fax,
                :Website
                )
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Address', $Address);
            $database->bind(':City', $City);
            $database->bind(':Email', $Email);
            $database->bind(':Phone', $Phone);
            $database->bind(':Fax', $Fax);
            $database->bind(':Website', $Website);
            if ($database->execute()) {
                header("location: suppliers.php");
            }
            break;

        case 'select':
            $query = "SELECT * FROM Suppliers ORDER BY Name ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'select_one':
            $query = "SELECT * FROM Suppliers
                WHERE Id = :SuppliersId
            ;";
            $database->query($query);
            $database->bind(':SuppliersId', $var1);
            return $r = $database->resultset();
            break;

        case 'select_Suppliers':
            // selecting Suppliers for a specific Service Type
            $query = "SELECT
                Suppliers.Id AS SupplierId,
                Suppliers.Name,
                Services.Service,
                Services.MaxPax,
                Services.Cost1_USD,
                Services.Cost1_MMK,
                Services.StartDate,
                Services.EndDate
                FROM Suppliers
                LEFT OUTER JOIN Services
                ON Suppliers.Id = Services.SupplierId
                WHERE Services.ServiceTypeId = :ServiceTypeId
            ;";
            $database->query($query);
            $database->bind(':ServiceTypeId', $var1);
            return $r = $database->resultset();
            break;

        case 'select_distinct_Suppliers':
            $query = "SELECT DISTINCT
                Suppliers.Id AS SupplierId,
                Suppliers.Name
                FROM Suppliers
                LEFT OUTER JOIN Services
                ON Suppliers.Id = Services.SupplierId
                WHERE Services.ServiceTypeId = :ServiceTypeId
            ;";
            $database->query($query);
            $database->bind(':ServiceTypeId', $var1);
            return $r = $database->resultset();
            break;

        default:
            # code...
            break;
    }
}

// function the get data from the table Corporates
function table_Corporates ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_all':
            $query = "SELECT
                Corporates.Id,
                Corporates.Name,
                Corporates.Chain,
                Corporates.Type,
                Corporates.CountryCode,
                Countries.Country,
                Corporates.Email,
                Corporates.Website
                FROM Corporates
                LEFT OUTER JOIN Countries
                ON Corporates.CountryCode = Countries.Code
                ORDER BY Corporates.Name
            ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'check':
            //getting data form the form
            $Name = trim($_REQUEST['Name']);

            $query = "SELECT * FROM Corporates
                WHERE Name = :Name
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            return $r = $database->rowCount();
            break;

        case 'insert':
            //getting data from the form
            $Name = trim($_REQUEST['Name']);
            $Chain = trim($_REQUEST['Chain']);
            $Type = trim($_REQUEST['Type']);
            $CountryCode = $_REQUEST['CountryCode'];
            $Email = trim($_REQUEST['Email']);
            $Website = trim($_REQUEST['Website']);

            $query = "INSERT INTO Corporates (
                Name,
                Chain,
                Type,
                CountryCode,
                Email,
                Website
                ) VALUES (
                :Name,
                :Chain,
                :Type,
                :CountryCode,
                :Email,
                :Website
                )
            ;";
            $database->query($query);
            $database->bind(':Name', $Name);
            $database->bind(':Chain', $Chain);
            $database->bind(':Type', $Type);
            $database->bind(':CountryCode', $CountryCode);
            $database->bind(':Email', $Email);
            $database->bind(':Website', $Website);
            if ($database->execute()) {
                header ("location: corporates.php");
            }
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

        case 'select_one':
            $query = "SELECT * FROM Invoices WHERE InvoiceNo = :InvoiceNo ;";
            $database->query($query);
            $database->bind(':InvoiceNo', $var1);
            return $r = $database->resultset();
            break;

        case 'generate_InvoiceNo':
            $query = "SELECT * FROM Invoices ;";
            $database->query($query);
            $r = $database->rowCount() + 1;
            if ($r <= 9) {
                $InvoiceNo = '2019'.'-000'.$r;
            }
            elseif ($r <= 99) {
                $InvoiceNo = '2019'.'-00'.$r;
            }
            elseif ($r <= 999) {
                $InvoiceNo = '2019'.'-0'.$r;
            }
            else {
                $InvoiceNo = '2019'.'-'.$r;
            }
            return $InvoiceNo;
            break;

        case 'insert':
            //getting data from the form
            $InvoiceDate = $_REQUEST['InvoiceDate'];
            $currency = $_REQUEST['currency'];

            //getting the sum
            $rows_sum = table_InvoiceDetails('get_sum', $var1, $currency);
            foreach ($rows_sum as $row_sum) {
                if ($currency === 'USD') {
                    $sum = $row_sum->USD;
                }
                else {
                    $sum = $row_sum->MMK;
                }
            }
            $query = "INSERT INTO Invoices(
                InvoiceNo,
                BookingsId,
                InvoiceDate,
                $currency,
                Status
                ) VALUES(
                :InvoiceNo,
                :BookingsId,
                :InvoiceDate,
                :sum,
                :Status
                )
            ;";
            $database->query($query);
            $database->bind(':InvoiceNo', $var1);
            $database->bind(':BookingsId', $var2);
            $database->bind(':InvoiceDate', $InvoiceDate);
            $database->bind(':sum', $sum);
            $database->bind(':Status', 'Invoiced');
            if ($database->execute()) {
                header("location: edit_booking_invoice.php?InvoiceNo=$var1");
            }
            break;

            case 'update':
                //getting data from the form
                $InvoiceDate = $_REQUEST['InvoiceDate'];
                $currency = $_REQUEST['currency'];

                //getting the sum
                $rows_sum = table_InvoiceDetails('get_sum', $var1, $currency);
                foreach ($rows_sum as $row_sum) {
                    if ($currency === 'USD') {
                        $sum = $row_sum->USD;
                    }
                    else {
                        $sum = $row_sum->MMK;
                    }
                }

                $query = "UPDATE Invoices SET
                    InvoiceDate = :InvoiceDate,
                    $currency = :sum
                    WHERE InvoiceNo = :InvoiceNo;
                ;";
                $database->query($query);
                $database->bind(':InvoiceDate', $InvoiceDate);
                $database->bind(':sum', $sum);
                $database->bind(':InvoiceNo', $var1);
                $database->execute();
                break;

            case 'update_receipt':
                //getting data from the form
                $Method = $_REQUEST['Method'];
                $PaidOn = date('Y-m-d');
                $query = "UPDATE Invoices SET
                    MethodId = :Method,
                    PaidOn = :PaidOn,
                    Status = 'Paid'
                    WHERE InvoiceNo = :InvoiceNo
                ;";
                $database->query($query);
                $database->bind(':Method', $Method);
                $database->bind(':PaidOn', $PaidOn);
                $database->bind(':InvoiceNo', $var1);
                if ($database->execute()) {
                    header("location: receipt_booking_invoice.php?InvoiceNo=$var1");
                }
                break;

        default:
            // code...
            break;
    }
}

//function to use the table InvoiceHeader
function table_InvoiceHeader($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'insert':
            // getting data from the form
            $Addressee = trim($_REQUEST['Addressee']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
            $Attn = trim($_REQUEST['Attn']);

            $query = "INSERT INTO InvoiceHeader (
                InvoiceNo,
                Addressee,
                Address,
                City,
                Attn
                ) VALUES (
                :InvoiceNo,
                :Addressee,
                :Address,
                :City,
                :Attn
                )
            ;";
            $database->query($query);
            $database->bind(':InvoiceNo', $var1);
            $database->bind(':Addressee', $Addressee);
            $database->bind(':Address', $Address);
            $database->bind(':City', $City);
            $database->bind(':Attn', $Attn);
            $database->execute();
            break;
        case 'select_one':
            $query = "SELECT * FROM InvoiceHeader WHERE InvoiceNo = :InvoiceNo ;";
            $database->query($query);
            $database->bind(':InvoiceNo', $var1);
            return $r = $database->resultset();
            break;

        case 'update':
            //getting data from the form
            $Addressee = trim($_REQUEST['Addressee']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
            $Attn = trim($_REQUEST['Attn']);
            $query = "UPDATE InvoiceHeader SET
                Addressee = :Addressee,
                Address = :Address,
                City = :City,
                Attn = :Attn
                WHERE InvoiceNo = :InvoiceNo
            ;";
            $database->query($query);
            $database->bind(':Addressee', $Addressee);
            $database->bind(':Address', $Address);
            $database->bind(':City', $City);
            $database->bind(':Attn', $Attn);
            $database->bind(':InvoiceNo', $var1);
            $database->execute();
            break;

        default:
            # code...
            break;
    }
}

// function to use the data from the table InvoiceDetails
function table_InvoiceDetails ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'insert':
            // inserting data of 20 rows
            $i = 1;
            while ($i <= 20) {
                $Date = $_REQUEST["Date$i"];
                $Description = trim($_REQUEST["Description$i"]);
                $amount = $_REQUEST["amount$i"];

                $query = "INSERT INTO InvoiceDetails (
                    InvoiceNo,
                    Date,
                    Description,
                    $var2
                    ) VALUES(
                    :InvoiceNo,
                    :Date,
                    :Description,
                    :amount
                    )
                ;";
                $database->query($query);
                $database->bind(':InvoiceNo', $var1);
                $database->bind(':Date', $Date);
                $database->bind(':Description', $Description);
                $database->bind(':amount', $amount);
                $database->execute();
                $i++;
            }
            break;
        case 'select_one':
            $query = "SELECT * FROM InvoiceDetails WHERE InvoiceNo = :InvoiceNo ;";
            $database->query($query);
            $database->bind(':InvoiceNo', $var1);
            return $r = $database->resultset();
            break;

        case 'get_sum':
            $query = "SELECT SUM($var2) AS $var2 FROM InvoiceDetails WHERE InvoiceNo = :InvoiceNo ;";
            $database->query($query);
            $database->bind(':InvoiceNo', $var1);
            return $r = $database->resultset();
            break;

        case 'update':
            //getting data from the form
            $i = 1;
            $currency = $_REQUEST['currency'];
            while ($i <= 20) {
                $Id = $_REQUEST["Id$i"];
                $Date = $_REQUEST["Date$i"];
                $Description = trim($_REQUEST["Description$i"]);
                $amount = $_REQUEST["amount$i"];
                $query = "UPDATE InvoiceDetails SET
                    Date = :Date,
                    Description = :Description,
                    $currency = :amount
                    WHERE Id = :Id
                ;";
                $database->query($query);
                $database->bind(':Date', $Date);
                $database->bind(':Description', $Description);
                $database->bind(':amount', $amount);
                $database->bind(':Id', $Id);
                $database->execute();
                $i++;
            }
            break;

        default:
            # code...
            break;
    }
}

// function to get data from the table Services_booking
function table_Services_booking ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'insert_flight':
            //getting data from the form
            $Date_in = $_REQUEST['Date_in'];
            $Pax = $_REQUEST['Pax'];
            $Quantity = 1;
            $Flight_no = $_REQUEST['Flight_no'];
            $Pick_up = $_REQUEST['Pick_up'];
            $Drop_off = $_REQUEST['Drop_off'];
            $Pick_up_time = $_REQUEST['Pick_up_time'];
            $Drop_off_time = $_REQUEST['Drop_off_time'];
            $StatusId = $_REQUEST['StatusId'];
            $Cfm_no = trim($_REQUEST['Cfm_no']);
            $Cost1_USD = $_REQUEST['Cost1_USD'];
            $Cost1_MMK = $_REQUEST['Cost1_MMK'];
            $sellPerUSD = $_REQUEST['sellPerUSD'];
            $sellPerMMK = $_REQUEST['sellPerMMK'];

            //getting the Markup
            if ($Cost1_MMK == 0) {
                $profit = $sellPerUSD - $Cost1_USD;
                $Markup = ($profit / $Cost1_USD) * 100;
            }
            elseif ($Cost1_USD == 0) {
                $profit = $sellPerMMK = $Cost1_MMK;
                $Markup = ($profit / $Cost1_MMK) * 100;
            }
            else {
                $profit = 0;
                $Markup = 0;
            }

            $Total_cost_USD = $Cost1_USD * $Quantity * $Pax;
            $Total_cost_MMK = $Cost1_MMK * $Quantity * $Pax;

            $Sell_USD = $sellPerUSD * $Quantity * $Pax;
            $Sell_MMK = $sellPerMMK * $Quantity * $Pax;

            $query = "INSERT INTO Services_booking (
                BookingsId,
                ServicesId,
                Date_in,
                Pax,
                Quantity,
                Flight_no,
                Pick_up,
                Drop_off,
                Pick_up_time,
                Drop_off_time,
                StatusId,
                Cfm_no,
                Cost1_USD,
                Cost1_MMK,
                Total_cost_USD,
                Total_cost_MMK,
                Markup,
                Sell_USD,
                Sell_MMK
                ) VALUES(
                :BookingsId,
                :ServicesId,
                :Date_in,
                :Pax,
                :Quantity,
                :Flight_no,
                :Pick_up,
                :Drop_off,
                :Pick_up_time,
                :Drop_off_time,
                :StatusId,
                :Cfm_no,
                :Cost1_USD,
                :Cost1_MMK,
                :Total_cost_USD,
                :Total_cost_MMK,
                :Markup,
                :Sell_USD,
                :Sell_MMK
                )
            ;";
            $database->query($query);
            $database->bind(':BookingsId', $var1);
            $database->bind(':ServicesId', $var2);
            $database->bind(':Date_in', $Date_in);
            $database->bind(':Pax', $Pax);
            $database->bind(':Quantity', $Quantity);
            $database->bind(':Flight_no', $Flight_no);
            $database->bind(':Pick_up', $Pick_up);
            $database->bind(':Drop_off', $Drop_off);
            $database->bind(':Pick_up_time', $Pick_up_time);
            $database->bind(':Drop_off_time', $Drop_off_time);
            $database->bind(':StatusId', $StatusId);
            $database->bind(':Cfm_no', $Cfm_no);
            $database->bind(':Cost1_USD', $Cost1_USD);
            $database->bind(':Cost1_MMK', $Cost1_MMK);
            $database->bind(':Total_cost_USD', $Total_cost_USD);
            $database->bind(':Total_cost_MMK', $Total_cost_MMK);
            $database->bind(':Markup', $Markup);
            $database->bind(':Sell_USD', $Sell_USD);
            $database->bind(':Sell_MMK', $Sell_MMK);
            if ($database->execute()) {
                header("location: booking_services.php?BookingsId=$var1");
            }
            break;

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
                ServiceStatus.Code AS StatusCode,
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

        case 'insert_hotel':
            // getting data from the form
            //$var1 = $BookingsId
            //$var2 = $ServicesId
            $Date_in = ($_REQUEST['Date_in']);
            $Date_out = ($_REQUEST['Date_out']);
            $Quantity = $_REQUEST['Quantity'];

            $Sgl = $_REQUEST['Sgl'];
            $Dbl = $_REQUEST['Dbl'];
            $Twn = $_REQUEST['Twn'];
            $Tpl = $_REQUEST['Tpl'];
            $Cost1_USD = $_REQUEST['Cost1_USD'];
            $Cost1_MMK = $_REQUEST['Cost1_MMK'];
            $Cost2_USD = $_REQUEST['Cost2_USD'];
            $Cost2_MMK = $_REQUEST['Cost2_MMK'];
            $Cost3_USD = $_REQUEST['Cost3_USD'];
            $Cost3_MMK = $_REQUEST['Cost3_MMK'];

            //getting $Total_cost_USD
            $total_Sgl_USD = ($Sgl * $Cost2_USD * $Quantity);
            $total_Twn_USD = ($Twn * $Cost1_USD * $Quantity);
            $total_Dbl_USD = ($Dbl * $Cost1_USD * $Quantity);
            $total_Tpl_USD = ($Tpl * $Cost3_USD * $Quantity);
            $Total_cost_USD = $total_Sgl_USD + $total_Twn_USD + $total_Dbl_USD + $total_Tpl_USD;

            //getting $Total_cost_MMK
            $total_Sgl_MMK = ($Sgl * $Cost2_MKK * $Quantity);
            $total_Twn_MMK = ($Twn * $Cost1_MKK * $Quantity);
            $total_Dbl_MMK = ($Dbl * $Cost1_MMK * $Quantity);
            $total_Tpl_MMK = ($Tpl * $Cost3_MMK * $Quantity);
            $Total_cost_MMK = $total_Sgl_MMK + $total_Twn_MMK + $total_Dbl_MMK + $total_Tpl_MMK;

            $Markup = $_REQUEST['Markup'];

            $Sell1_USD = $_REQUEST['Sell1_USD'];
            $Sell1_MMK = $_REQUEST['Sell1_MMK'];
            $Sell2_USD = $_REQUEST['Sell2_USD'];
            $Sell2_MMK = $_REQUEST['Sell2_MMK'];
            $Sell3_USD = $_REQUEST['Sell3_USD'];
            $Sell3_MMK = $_REQUEST['Sell3_MMK'];

            $total_sell_Sgl_USD = ($Sell2_USD * $Sgl * $Quantity);
            $total_sell_Sgl_MMK = ($Sell2_MMK * $Sgl * $Quantity);
            $total_sell_Twn_USD = ($Sell1_USD * $Twn * $Quantity);
            $total_sell_Twn_MMK = ($Sell1_MMK * $Twn * $Quantity);
            $total_sell_Dbl_USD = ($Sell1_USD * $Dbl * $Quantity);
            $total_sell_Dbl_MMK = ($Sell1_MMK * $Dbl * $Quantity);
            $total_sell_Tpl_USD = ($Sell3_USD * $Tpl * $Quantity);
            $total_sell_Tpl_MMK = ($Sell3_MMK * $Tpl * $Quantity);

            $Sell_USD = $total_sell_Sgl_USD + $total_sell_Twn_USD + $total_sell_Dbl_USD
            + $total_sell_Tpl_USD;

            $Sell_MMK = $total_sell_Sgl_MMK + $total_sell_Twn_MMK + $total_sell_Dbl_MMK
            + $total_sell_Tpl_MMK;

            $query = "INSERT INTO Services_booking (
                BookingsId,
                ServicesId,
                Date_in,
                Date_out,
                Sgl,
                Dbl,
                Twn,
                Tpl,
                Quantity,
                Cost1_USD,
                Cost1_MMK,
                Cost2_USD,
                Cost2_MMK,
                Cost3_USD,
                Cost3_MMK,
                Total_cost_USD,
                Total_cost_MMK,
                Markup,
                Sell_USD,
                Sell_MMK
                ) VALUES (
                :BookingsId,
                :ServicesId,
                :Date_in,
                :Date_out,
                :Sgl,
                :Dbl,
                :Twn,
                :Tpl,
                :Quantity,
                :Cost1_USD,
                :Cost1_MMK,
                :Cost2_USD,
                :Cost2_MMK,
                :Cost3_USD,
                :Cost3_MMK,
                :Total_cost_USD,
                :Total_cost_MMK,
                :Markup,
                :Sell_USD,
                :Sell_MMK
                )
            ;";
            $database->query($query);
            $database->bind(':BookingsId', $var1);
            $database->bind(':ServicesId', $var2);
            $database->bind(':Date_in', $Date_in);
            $database->bind(':Date_out', $Date_out);
            $database->bind(':Sgl', $Sgl);
            $database->bind(':Dbl', $Dbl);
            $database->bind(':Twn', $Twn);
            $database->bind(':Tpl', $Tpl);
            $database->bind(':Quantity', $Quantity);
            $database->bind(':Cost1_USD', $Cost1_USD);
            $database->bind(':Cost1_MMK', $Cost1_MKK);
            $database->bind(':Cost2_USD', $Cost2_USD);
            $database->bind(':Cost2_MMK', $Cost2_MMK);
            $database->bind(':Cost3_USD', $Cost3_USD);
            $database->bind(':Cost3_MMK', $Cost3_MMK);
            $database->bind(':Total_cost_USD', $Total_cost_USD);
            $database->bind(':Total_cost_MMK', $Total_cost_MMK);
            $database->bind(':Markup', $Markup);
            $database->bind(':Sell_USD', $Sell_USD);
            $database->bind(':Sell_MMK', $Sell_MMK);
            if ($database->execute()) {
                header("location: booking_services.php?BookingsId=$var1");
            }
            break;

        case 'select_hotels':
            // $var1 = $BookingsId
            $query = "SELECT
                Services_booking.Id AS Services_bookingId,
                Services_booking.ServicesId,
                Services_booking.Date_in,
                Services_booking.Date_out,
                Services_booking.Quantity,
                Services_booking.Sgl,
                Services_booking.Dbl,
                Services_booking.Twn,
                Services_booking.Tpl,
                Services_booking.StatusId,
                Services_booking.Cfm_no,
                Services.Id AS ServicesId,
                Services.Service AS Service,
                Suppliers.Name AS SuppliersName,
                Suppliers.City,
                ServiceStatus.Code AS Code,
                ServiceStatus.Status AS Status
                FROM Services_booking
                LEFT OUTER JOIN Services
                ON Services_booking.ServicesId = Services.Id
                LEFT OUTER JOIN Suppliers
                ON Services.SupplierId = Suppliers.Id
                LEFT OUTER JOIN ServiceStatus
                ON Services_booking.StatusId = ServiceStatus.Id
                WHERE Services.ServiceTypeId = '1'
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
                Services_booking.Date_out,
                Services_booking.Quantity,
                Services_booking.Pax,
                Services_booking.Sgl,
                Services_booking.Dbl,
                Services_booking.Twn,
                Services_booking.Tpl,
                Services_booking.Flight_no,
                Services_booking.Pick_up,
                Services_booking.Drop_off,
                Services_booking.Pick_up_time,
                Services_booking.Drop_off_time,
                Services_booking.Remark,
                Services_booking.Spc_rq,
                Services_booking.StatusId,
                Services_booking.Cfm_no,
                Services_booking.Cost1_USD,
                Services_booking.Cost1_MMK,
                Services_booking.Cost2_USD,
                Services_booking.Cost2_MMK,
                Services_booking.Cost3_USD,
                Services_booking.Cost3_MMK,
                Services_booking.Markup,
                Services_booking.Sell_USD,
                Services_booking.Sell_MMK,
                Services.Id AS ServicesId,
                Services.Service AS Service,
                Services.ServiceTypeId AS ServiceTypeId,
                Services.SupplierId AS SupplierId,
                Suppliers.Name AS SuppliersName,
                ServiceStatus.Code AS Code,
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

        case 'update_flight':
            //$var1 = $Services_bookingId
            //$var2 = $BookingsId
            //getting data from the form
            $Date_in = $_REQUEST['Date_in'];
            $Flight_no = trim($_REQUEST['Flight_no']);
            $Pick_up = trim($_REQUEST['Pick_up']);
            $Pick_up_time = $_REQUEST['Pick_up_time'];
            $Drop_off = trim($_REQUEST['Drop_off']);
            $Drop_off_time = $_REQUEST['Drop_off_time'];
            $Pax = $_REQUEST['Pax'];
            $StatusId = $_REQUEST['StatusId'];
            $Cfm_no = trim($_REQUEST['Cfm_no']);
            $Cost1_USD = $_REQUEST['Cost1_USD'];
            $Cost1_MMK = $_REQUEST['Cost1_MMK'];

            $Markup = $_REQUEST['Markup'];

            $sellPerUSD = $_REQUEST['sellPerUSD'];
            $sellPerMMK = $_REQUEST['sellPerMMK'];

			//getting the total costs
			$Total_cost_USD = $Cost1_USD * $Pax;
			$Total_cost_MMK = $Cost1_MMK * $Pax;

			$Sell_USD = $sellPerUSD * $Pax;
			$Sell_MMK = $sellPerMMK * $Pax;

            $query = "UPDATE Services_booking SET
                Date_in = :Date_in,
                Flight_no = :Flight_no,
                Pick_up = :Pick_up,
                Pick_up_time = :Pick_up_time,
                Drop_off = :Drop_off,
                Drop_off_time = :Drop_off_time,
                Pax = :Pax,
                StatusId = :StatusId,
                Cfm_no = :Cfm_no,
                Cost1_USD = :Cost1_USD,
                Cost1_MMK = :Cost1_MMK,
               	Total_cost_USD = :Total_cost_USD,
				Total_cost_MMK = :Total_cost_MMK,
                Markup = :Markup,
				Sell_USD = :Sell_USD,
                Sell_MMK = :Sell_MMK
                WHERE Id = :Services_bookingId
            ;";
            $database->query($query);
            $database->bind(':Date_in', $Date_in);
            $database->bind(':Flight_no', $Flight_no);
            $database->bind(':Pick_up', $Pick_up);
            $database->bind(':Pick_up_time', $Pick_up_time);
            $database->bind(':Drop_off', $Drop_off);
            $database->bind(':Drop_off_time', $Drop_off_time);
            $database->bind(':Pax', $Pax);
            $database->bind(':StatusId', $StatusId);
            $database->bind(':Cfm_no', $Cfm_no);
            $database->bind(':Cost1_USD', $Cost1_USD);
            $database->bind(':Cost1_MMK', $Cost1_MMK);
            $database->bind(':Total_cost_USD', $Total_cost_USD);
            $database->bind(':Total_cost_MMK', $Total_cost_MMK);
            $database->bind(':Markup', $Markup);
            $database->bind(':Sell_USD', $Sell_USD);
            $database->bind(':Sell_MMK', $Sell_MMK);
            $database->bind(':Services_bookingId', $var1);
            if ($database->execute()) {
                header("location: booking_services.php?BookingsId=$var2");
            }
            break;

        case 'update_hotel':
            // $var1 = $Services_bookingId
            // $var2 = $BookingsId
            //getting data from the form
            $Date_in = $_REQUEST['Date_in'];
            $Date_out = $_REQUEST['Date_out'];
            $Quantity = $_REQUEST['Quantity'];
            $Sgl = $_REQUEST['Sgl'];
            $Dbl = $_REQUEST['Dbl'];
            $Twn = $_REQUEST['Twn'];
            $Tpl = $_REQUEST['Tpl'];
            $Remark = trim($_REQUEST['Remark']);
            $Spc_rq = trim($_REQUEST['Spc_rq']);
            $StatusId = $_REQUEST['StatusId'];
            $Cfm_no = trim($_REQUEST['Cfm_no']);
            $Markup = $_REQUEST['Markup'];
            $Cost1_USD = $_REQUEST['Cost1_USD'];
            $Cost1_MKK = $_REQUEST['Cost1_MMK'];
            $Cost2_USD = $_REQUEST['Cost2_USD'];
            $Cost2_MKK = $_REQUEST['Cost2_MMK'];
            $Cost3_USD = $_REQUEST['Cost3_USD'];
            $Cost3_MKK = $_REQUEST['Cost3_MMK'];

            $Total_cost_Dbl_USD = $Cost1_USD * $Quantity * $Dbl;
            $Total_cost_Twn_USD = $Cost1_USD * $Quantity * $Twn;
            $Total_cost_Sgl_USD = $Cost2_USD * $Quantity * $Sgl;
            $Total_cost_Tpl_USD = $Cost3_USD * $Quantity * $Tpl;

            $Total_cost_Dbl_MMK = $Cost1_MMK * $Quantity * $Dbl;
            $Total_cost_Twn_MMK = $Cost1_MMK * $Quantity * $Twn;
            $Total_cost_Sgl_MMK = $Cost2_MMK * $Quantity * $Sgl;
            $Total_cost_Tpl_MMK = $Cost3_MMK * $Quantity * $Tpl;

            $Total_cost_USD = $Total_cost_Dbl_USD + $Total_cost_Twn_USD + $Total_cost_Sgl_USD
            + $Total_cost_Tpl_USD;

            $Total_cost_MMK = $Total_cost_Dbl_MMK + $Total_cost_Twn_MMK + $Total_cost_Sgl_MMK
            + $Total_cost_Tpl_MMK;

            $Sell1_USD = $_REQUEST['Sell1_USD'];
            $Sell1_MMK = $_REQUEST['Sell1_MMK'];
            $Sell2_USD = $_REQUEST['Sell2_USD'];
            $Sell2_MMK = $_REQUEST['Sell2_MMK'];
            $Sell3_USD = $_REQUEST['Sell3_USD'];
            $Sell3_MMK = $_REQUEST['Sell3_MMK'];

            $total_sell_Dbl_USD = $Sell1_USD * $Quantity * $Dbl;
            $total_sell_Dbl_MMK = $Sell1_MMK * $Quantity * $Dbl;
            $total_sell_Twn_USD = $Sell1_USD * $Quantity * $Twn;
            $total_sell_Twn_MMK = $Sell1_MMK * $Quantity * $Twn;
            $total_sell_Sgl_USD = $Sell2_USD * $Quantity * $Sgl;
            $total_sell_Sgl_MMK = $Sell2_MMK * $Quantity * $Sgl;
            $total_sell_Tpl_USD = $Sell3_USD * $Quantity * $Tpl;
            $total_sell_Tpl_MMK = $Sell3_MMK * $Quantity * $Tpl;

            $Sell_USD = $total_sell_Dbl_USD + $total_sell_Twn_USD + $total_sell_Sgl_USD + $total_sell_Tpl_USD;

            $Sell_MMK = $total_sell_Dbl_MMK + $total_sell_Twn_MMK + $total_sell_Sgl_MMK + $total_sell_Tpl_MMK;

            $query = "UPDATE Services_booking SET
                Date_in = :Date_in,
                Date_out = :Date_out,
                Sgl = :Sgl,
                Dbl = :Dbl,
                Twn = :Twn,
                Tpl = :Tpl,
                Quantity = :Quantity,
                Remark = :Remark,
                Spc_rq = :Spc_rq,
                StatusId = :StatusId,
                Cfm_no = :Cfm_no,
                Total_cost_USD = :Total_cost_USD,
                Total_cost_MMK = :Total_cost_MMK,
                Markup = :Markup,
                Sell_USD = :Sell_USD,
                Sell_MMK = :Sell_MMK
                WHERE Id = :Services_bookingId
            ;" ;
            $database->query($query);
            $database->bind(':Date_in', $Date_in);
            $database->bind(':Date_out', $Date_out);
            $database->bind(':Sgl', $Sgl);
            $database->bind(':Dbl', $Dbl);
            $database->bind(':Twn', $Twn);
            $database->bind(':Tpl', $Tpl);
            $database->bind(':Quantity', $Quantity);
            $database->bind(':Remark', $Remark);
            $database->bind(':Spc_rq', $Spc_rq);
            $database->bind(':StatusId', $StatusId);
            $database->bind(':Cfm_no', $Cfm_no);
            $database->bind(':Total_cost_USD', $Total_cost_USD);
            $database->bind(':Total_cost_MMK', $Total_cost_MMK);
            $database->bind(':Markup', $Markup);
            $database->bind(':Sell_USD', $Sell_USD);
            $database->bind(':Sell_MMK', $Sell_MMK);
            $database->bind(':Services_bookingId', $var1);
            if ($database->execute()) {
                header("location: booking_services.php?BookingsId=$var2");
            }
            break;

        case 'delete':
            $BookingsId = $_REQUEST['BookingsId'];
            $query = "UPDATE Services_booking SET
                BookingsId = :BookingsId
                WHERE Id = :Services_bookingId
            ;";
            $database->query($query);
            $database->bind(':BookingsId', 0);
            $database->bind(':Services_bookingId', $var1);
            if ($database->execute()) {
                header("location: booking_services.php?BookingsId=$BookingsId");
            }
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

        case 'select_all':
            // code...
            break;

        default:
            // code...
            break;
    }
}

//function to use the table ServiceType
function table_ServiceType ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select':
            $query = "SELECT * FROM ServiceType ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}

//function to use the table Services
function table_Services ($job, $var1, $var2) {
    $database = new Database();
    switch ($job) {
        case 'select_one':
            $query = "SELECT
                Services.ServiceTypeId,
                Services.SupplierId,
                Services.Service,
                Services.Additional,
                Services.StartDate,
                Services.EndDate,
                Services.MaxPax,
                Services.Cost1_USD,
                Services.Cost1_MMK,
                Services.Cost2_USD,
                Services.Cost2_MMK,
                Services.Cost3_USD,
                Services.Cost3_MMK,
                Suppliers.Name
                FROM Services
                LEFT OUTER JOIN Suppliers
                ON Services.SupplierId = Suppliers.Id
                WHERE Services.Id = :ServicesId
            ;";
            $database->query($query);
            $database->bind(':ServicesId', $var1);
            return $r = $database->resultset();
            break;

        case 'select_to_add':
            $query = "SELECT * FROM Services WHERE
                ServiceTypeId = :ServiceTypeId
                AND SupplierId = :SupplierId
            ;";
            $database->query($query);
            $database->bind(':ServiceTypeId', $var1);
            $database->bind(':SupplierId', $var2);
            return $r = $database->resultset();
            break;

        case 'check_before_insert_AC':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $StartDate = $_REQUEST['StartDate'];
            $EndDate = $_REQUEST['EndDate'];
            $Cost1_USD = $_REQUEST['Cost1_USD'];
            $query = "SELECT Id FROM Services
                WHERE SupplierId = :SupplierId
                AND Service = :Service
                AND StartDate = :StartDate
                AND EndDate = :EndDate
                AND Cost1_USD = :Cost1_USD
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service', $Service);
            $database->bind(':Service', $Service);
            $database->bind(':StartDate', $StartDate);
            $database->bind(':EndDate', $EndDate);
            $database->bind(':Cost1_USD', $Cost1_USD);
            return $r = $database->rowCount();
            break;

        case 'insert_AC':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $StartDate = $_REQUEST['StartDate'];
            $EndDate = $_REQUEST['EndDate'];
            $currency = $_REQUEST['currency'];
            switch ($currency) {
                case 'USD':
                    $Cost1_USD = $_REQUEST['Cost1_USD'];
                    $Cost2_USD = $_REQUEST['Cost2_USD'];
                    $Cost3_USD = $_REQUEST['Cost3_USD'];
                    $query = "INSERT INTO Services (
                        ServiceTypeId,
                        SupplierId,
                        Service,
                        StartDate,
                        EndDate,
                        Cost1_USD,
                        Cost2_USD,
                        Cost3_USD
                        ) VALUES (
                        :ServiceTypeId,
                        :SupplierId,
                        :Service,
                        :StartDate,
                        :EndDate,
                        :Cost1_USD,
                        :Cost2_USD,
                        :Cost3_USD
                        )
                    ;";
                    $database->query($query);
                    $database->bind(':ServiceTypeId', 1);
                    $database->bind(':SupplierId', $SupplierId);
                    $database->bind(':Service', $Service);
                    $database->bind(':StartDate', $StartDate);
                    $database->bind(':EndDate', $EndDate);
                    $database->bind(':Cost1_USD', $Cost1_USD);
                    $database->bind(':Cost2_USD', $Cost2_USD);
                    $database->bind(':Cost3_USD', $Cost3_USD);
                    break;
                case 'MMK':
                    $Cost1_MMK = $_REQUEST['Cost1_MMK'];
                    $Cost2_MMK = $_REQUEST['Cost2_MMK'];
                    $Cost3_MMK = $_REQUEST['Cost3_MMK'];
                    $query = "INSERT INTO Services (
                        ServiceTypeId,
                        SupplierId,
                        Service,
                        StartDate,
                        EndDate,
                        Cost1_USD,
                        Cost2_USD,
                        Cost3_USD
                        ) VALUES (
                        :ServiceTypeId,
                        :SupplierId,
                        :Service,
                        :StartDate,
                        :EndDate,
                        :Cost1_MMK,
                        :Cost2_MMK,
                        :Cost3_MMK
                        )
                    ;";
                    $database->query($query);
                    $database->bind(':ServiceTypeId', 1);
                    $database->bind(':SupplierId', $SupplierId);
                    $database->bind(':Service', $Service);
                    $database->bind(':StartDate', $StartDate);
                    $database->bind(':EndDate', $EndDate);
                    $database->bind(':Cost1_MMK', $Cost1_MMK);
                    $database->bind(':Cost2_MMK', $Cost2_MMK);
                    $database->bind(':Cost3_MMK', $Cost3_MMK);
                    break;
                default:
                    // code...
                    break;
            }
            if ($database->execute()) {
                header("location:service_AC.php");
            }
            break;

        case 'check_before_insert_FL':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $query = "SELECT * FROM Services
                WHERE SupplierId = :SupplierId
                AND Service = :Service
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service', $Service);
            return $r = $database->rowCount();
            break;

        case 'insert_FL':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $StartDate = $_REQUEST['StartDate'];
            $EndDate = $_REQUEST['EndDate'];
            $query = "INSERT INTO Services (
                ServiceTypeId,
                SupplierId,
                Service,
                StartDate,
                EndDate
                ) VALUES (
                :ServiceTypeId,
                :SupplierId,
                :Service,
                :StartDate,
                :EndDate
                )
            ;";
            $database->query($query);
            $database->bind(':ServiceTypeId', 2);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service', $Service);
            $database->bind(':StartDate', $StartDate);
            $database->bind(':EndDate', $EndDate);
            if ($database->execute()) {
                header("location: service_FL.php");
            }
            break;

        case 'check_before_insert_LT':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $Additional = trim($_REQUEST['Additional']);
            $StartDate = $_REQUEST['StartDate'];
            $EndDate = $_REQUEST['EndDate'];
            $query = "SELECT * FROM Services
                WHERE SupplierId = :SupplierId
                AND Service = :Service
                AND Additional = :Additional
                AND StartDate = :StartDate
                AND EndDate = :EndDate
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service', $Service);
            $database->bind(':Additional', $Additional);
            $database->bind(':StartDate', $StartDate);
            $database->bind(':EndDate', $EndDate);
            return $r = $database->rowCount();
            break;

        case 'insert_LT':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $Additional = trim($_REQUEST['Additional']);
            $StartDate = $_REQUEST['StartDate'];
            $EndDate = $_REQUEST['EndDate'];
            $MaxPax = $_REQUEST['MaxPax'];
            $currency = $_REQUEST['currency'];

            switch ($currency) {
                case 'USD':
                    $Cost1_USD = $_REQUEST['Cost1_USD'];
                    $query = "INSERT INTO Services (
                        ServiceTypeId,
                        SupplierId,
                        Service,
                        Additional,
                        StartDate,
                        EndDate,
                        MaxPax,
                        Cost1_USD
                        ) VALUES (
                        :ServiceTypeId,
                        :SupplierId,
                        :Service,
                        :Additional,
                        :StartDate,
                        :EndDate,
                        :MaxPax,
                        :Cost1_USD
                        )
                    ;";
                    $database->query($query);
                    $database->bind(':ServiceTypeId', 3);
                    $database->bind(':SupplierId', $SupplierId);
                    $database->bind(':Service', $Service);
                    $database->bind(':Additional', $Additional);
                    $database->bind(':StartDate', $StartDate);
                    $database->bind(':EndDate', $EndDate);
                    $database->bind(':MaxPax', $MaxPax);
                    $database->bind(':Cost1_USD',$Cost1_USD);
                    if ($database->execute()) {
                        header("location: service_LT.php");
                    }
                    break;
                case 'MMK':
                    $Cost1_MMK = $_REQUEST['Cost1_MMK'];
                    $query = "INSERT INTO Services (
                        ServiceTypeId,
                        SupplierId,
                        Service,
                        Additional,
                        StartDate,
                        EndDate,
                        MaxPax,
                        Cost1_MMK
                        ) VALUES (
                        :ServiceTypeId,
                        :SupplierId,
                        :Service,
                        :Additional,
                        :StartDate,
                        :EndDate,
                        :MaxPax,
                        :Cost1_MMK
                        )
                    ;";
                    $database->query($query);
                    $database->bind(':ServiceTypeId', 3);
                    $database->bind(':SupplierId', $SupplierId);
                    $database->bind(':Service', $Service);
                    $database->bind(':Additional', $Additional);
                    $database->bind(':StartDate', $StartDate);
                    $database->bind(':EndDate', $EndDate);
                    $database->bind(':MaxPax', $MaxPax);
                    $database->bind(':Cost1_MMK',$Cost1_MMK);
                    if ($database->execute()) {
                        header("location: service_LT.php");
                    }
                    break;

                default:
                    // code...
                    break;
            }
            break;

        case 'check_before_insert_BO':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $MaxPax = $_REQUEST['MaxPax'];
            $StartDate = $_REQUEST['StartDate'];
            $EndDate = $_REQUEST['EndDate'];
            $query = "SELECT * FROM Services
                WHERE SupplierId = :SupplierId
                AND Service = :Service
                AND MaxPax = :MaxPax
                AND StartDate = :StartDate
                AND EndDate = :EndDate
            ;";
            $database->query($query);
            $database->bind(':SupplierId', $SupplierId);
            $database->bind(':Service', $Service);
            $database->bind(':MaxPax', $MaxPax);
            $database->bind(':StartDate', $StartDate);
            $database->bind(':EndDate', $EndDate);
            return $r = $database->rowCount();
            break;

        case 'insert_BO':
            $SupplierId = $_REQUEST['SupplierId'];
            $Service = trim($_REQUEST['Service']);
            $MaxPax = $_REQUEST['MaxPax'];
            $StartDate = $_REQUEST['StartDate'];
            $EndDate = $_REQUEST['EndDate'];
            $currency = $_REQUEST['currency'];
            switch ($currency) {
                case 'USD':
                    $Cost1_USD = $_REQUEST['Cost1_USD'];
                    $query = "INSERT INTO Services (
                        SupplierId,
                        Service,
                        MaxPax,
                        StartDate,
                        EndDate,
                        Cost1_USD
                        ) VALUES (
                        :SupplierId,
                        :Service,
                        :MaxPax,
                        :StartDate,
                        :EndDate,
                        :Cost1_USD
                        )
                    ;";
                    $database->query($query);
                    $database->bind(':SupplierId', $SupplierId);
                    $database->bind(':Service', $Service);
                    $database->bind(':MaxPax', $MaxPax);
                    $database->bind(':StartDate', $StartDate);
                    $database->bind(':EndDate', $EndDate);
                    $database->bind(':Cost1_USD', $Cost1_USD);
                    if ($database->execute()) {
                        header("location: service_BO.php");
                    }
                    break;

                case 'MMK':
                    $Cost1_MMK = $_REQUEST['Cost1_MMK'];
                    $query = "INSERT INTO Services (
                        SupplierId,
                        Service,
                        MaxPax,
                        StartDate,
                        EndDate,
                        Cost1_MMK
                        ) VALUES (
                        :SupplierId,
                        :Service,
                        :MaxPax,
                        :StartDate,
                        :EndDate,
                        :Cost1_MMK
                        )
                    ;";
                    $database->query($query);
                    $database->bind(':SupplierId', $SupplierId);
                    $database->bind(':Service', $Service);
                    $database->bind(':MaxPax', $MaxPax);
                    $database->bind(':StartDate', $StartDate);
                    $database->bind(':EndDate', $EndDate);
                    $database->bind(':Cost1_MMK', $Cost1_MMK);
                    if ($database->execute()) {
                        header("location: service_BO.php");
                    }
                    break;

                default:
                    // code...
                    break;
            }
            break;

        case 'select_all':
            // $var1 = ServiceTypeId
            $query = "SELECT
                Services.Id AS ServicesId,
                Suppliers.Name AS SuppliersName,
                Services.Service,
                Services.Additional,
                Services.MaxPax,
                Services.StartDate,
                Services.EndDate,
                Services.Cost1_USD,
                Services.Cost1_MMK,
                Services.Cost2_USD,
                Services.Cost2_MMK,
                Services.Cost3_USD,
                Services.Cost3_MMK
                FROM Services
                LEFT OUTER JOIN Suppliers
                ON Services.SupplierId = Suppliers.Id
                WHERE Services.ServiceTypeId = :ServiceTypeId
            ;";
            $database->query($query);
            $database->bind(':ServiceTypeId', $var1);
            return $r = $database->resultset();
            break;
        default:
            // code...
            break;
    }
}

//functions to use the table Clients
function table_Clients ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_all':
            $query = "SELECT * FROM Clients ;";
            $database->query($query);
            return $r = $database->resultset();
            break;

        case 'check_before_insert':
            //getting data from the form
            $Title = $_REQUEST['Title'];
            $FirstName = trim($_REQUEST['FirstName']);
            $Company = trim($_REQUEST['Company']);
            $query = "SELECT Id FROM Clients
                WHERE Title = :Title
                AND FirstName = :FirstName
                AND Company = :Company
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':FirstName', $FirstName);
            $database->bind(':Company', $Company);
            return $r = $database->rowCount();
            break;

        case 'insert':
            // getting data from the form
            $Title = $_REQUEST['Title'];
            $FirstName = trim($_REQUEST['FirstName']);
            $LastName = trim($_REQUEST['LastName']);
            $PassportNo = trim($_REQUEST['PassportNo']);
            $PassportExpiry = $_REQUEST['PassportExpiry'];
            $NRCNo = trim($_REQUEST['NRCNo']);
            $DOB = $_REQUEST['DOB'];
            $Country = trim($_REQUEST['Country']);
            $FrequentFlyer = trim($_REQUEST['FrequentFlyer']);
            $Company = trim($_REQUEST['Company']);
            $Phone = trim($_REQUEST['Phone']);
            $Email = trim($_REQUEST['Email']);
            $Website = trim($_REQUEST['Website']);

            $query = "INSERT INTO Clients (
                Title,
                FirstName,
                LastName,
                PassportNo,
                PassportExpiry,
                NRCNo,
                DOB,
                Country,
                FrequentFlyer,
                Company,
                Phone,
                Email,
                Website
                ) VALUES (
                :Title,
                :FirstName,
                :LastName,
                :PassportNo,
                :PassportExpiry,
                :NRCNo,
                :DOB,
                :Country,
                :FrequentFlyer,
                :Company,
                :Phone,
                :Email,
                :Website
                )
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':FirstName', $FirstName);
            $database->bind(':LastName', $LastName);
            $database->bind(':PassportNo', $PassportNo);
            $database->bind(':PassportExpiry', $PassportExpiry);
            $database->bind(':NRCNo', $NRCNo);
            $database->bind(':DOB', $DOB);
            $database->bind(':Country', $Country);
            $database->bind(':FrequentFlyer', $FrequentFlyer);
            $database->bind(':Company', $Company);
            $database->bind(':Phone', $Phone);
            $database->bind(':Email', $Email);
            $database->bind(':Website', $Website);
            $database->execute();
            break;

        case 'select_one':
            $query = "SELECT * FROM Clients WHERE Id = :ClientsId ;";
            $database->query($query);
            $database->bind(':ClientsId', $var1);
            return $r = $database->resultset();
            break;

        case 'check_before_update':
            // getting data from the form
            $FirstName = trim($_REQUEST['FirstName']);
            $LastName = trim($_REQUEST['LastName']);
            $NRCNo = trim($_REQUEST['NRCNo']);

            $query = "SELECT * FROM Clients
                WHERE FirstName = :FirstName
                AND LastName = :LastName
                AND NRCNo = :NRCNo
                AND Id != :Id
            ;";
            $database->query($query);
            $database->bind(':FirstName', $FirstName);
            $database->bind(':LastName', $LastName);
            $database->bind(':NRCNo', $NRCNo);
            $database->bind(':Id', $var1);
            return $r = $database->rowCount();
            break;

        case 'update_one':
            // getting data from the form
            $Title = $_REQUEST['Title'];
            $FirstName = trim($_REQUEST['FirstName']);
            $LastName = trim($_REQUEST['LastName']);
            $PassportNo = trim($_REQUEST['PassportNo']);
            $PassportExpiry = $_REQUEST['PassportExpiry'];
            $NRCNo = trim($_REQUEST['NRCNo']);
            $DOB = $_REQUEST['DOB'];
            $Country = trim($_REQUEST['Country']);
            $FrequentFlyer = trim($_REQUEST['FrequentFlyer']);
            $Company = trim($_REQUEST['Company']);
            $Phone = trim($_REQUEST['Phone']);
            $Email = trim($_REQUEST['Email']);
            $Website = trim($_REQUEST['Website']);

            $query = "UPDATE Clients SET
                Title = :Title,
                FirstName = :FirstName,
                LastName = :LastName,
                PassportNo = :PassportNo,
                PassportExpiry = :PassportExpiry,
                NRCNo = :NRCNo,
                DOB = :DOB,
                Country = :Country,
                FrequentFlyer = :FrequentFlyer,
                Company = :Company,
                Phone = :Phone,
                Email = :Email,
                Website = :Website
                WHERE Id = :Id
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':FirstName', $FirstName);
            $database->bind(':LastName', $LastName);
            $database->bind(':PassportNo', $PassportNo);
            $database->bind(':PassportExpiry', $PassportExpiry);
            $database->bind(':NRCNo', $NRCNo);
            $database->bind(':DOB', $DOB);
            $database->bind(':Country', $Country);
            $database->bind(':FrequentFlyer', $FrequentFlyer);
            $database->bind(':Company', $Company);
            $database->bind(':Phone', $Phone);
            $database->bind(':Email', $Email);
            $database->bind(':Website', $Website);
            $database->bind(':Id', $var1);
            if ($database->execute()) {
                header("location: edit_clients.php?ClientsId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

// function to use the table Booking_Clients
function table_Bookings_Clients ($job, $var1, $var2) {
    $database = new Database();

    switch ($job) {
        case 'select_for_booking':
            $query = "SELECT
                Bookings_Clients.ClientsId,
                Clients.Title,
                Clients.FirstName,
                Clients.LastName,
                Clients.PassportNo,
                Clients.PassportExpiry,
                Clients.NRCNo,
                Clients.DOB,
                Clients.Country,
                Clients.FrequentFlyer,
                Clients.Company,
                Clients.Phone,
                Clients.Email,
                Clients.Website
                FROM Bookings_Clients
                LEFT OUTER JOIN Clients
                ON Bookings_Clients.ClientsId = Clients.Id
                WHERE Bookings_Clients.BookingsId = :BookingsId
            ;";
            $database->query($query);
            $database->bind(':BookingsId', $var1);
            return $r = $database->resultset();
            break;

        case 'insert_new_client':
            // getting data from the form
            $Title = $_REQUEST['Title'];
            $FirstName = trim($_REQUEST['FirstName']);
            $LastName = trim($_REQUEST['LastName']);
            $PassportNo = trim($_REQUEST['PassportNo']);
            $PassportExpiry = $_REQUEST['PassportExpiry'];
            $NRCNo = trim($_REQUEST['NRCNo']);
            $DOB = $_REQUEST['DOB'];
            $Country = trim($_REQUEST['Country']);
            $FrequentFlyer = trim($_REQUEST['FrequentFlyer']);
            $Company = trim($_REQUEST['Company']);
            $Phone = trim($_REQUEST['Phone']);
            $Email = trim($_REQUEST['Email']);
            $Website = trim($_REQUEST['Website']);

            $query = "SELECT * FROM Clients
                WHERE Title = :Title
                AND FirstName = :FirstName
                AND LastName = :LastName
                AND PassportNo = :PassportNo
                AND PassportExpiry = :PassportExpiry
                AND NRCNo = :NRCNo
                AND DOB = :DOB
                AND Country = :Country
                AND FrequentFlyer = :FrequentFlyer
                AND Company = :Company
                AND Phone = :Phone
                AND Email = :Email
                AND Website = :Website
            ;";
            $database->query($query);
            $database->bind(':Title', $Title);
            $database->bind(':FirstName', $FirstName);
            $database->bind(':LastName', $LastName);
            $database->bind(':PassportNo', $PassportNo);
            $database->bind(':PassportExpiry', $PassportExpiry);
            $database->bind(':NRCNo', $NRCNo);
            $database->bind(':DOB', $DOB);
            $database->bind(':Country', $Country);
            $database->bind(':FrequentFlyer', $FrequentFlyer);
            $database->bind(':Company', $Company);
            $database->bind(':Phone', $Phone);
            $database->bind(':Email', $Email);
            $database->bind(':Website', $Website);
            return $r = $database->resultset();
            break;

        case 'insert':
            $query = "INSERT INTO Bookings_Clients (
                BookingsId,
                ClientsId
                ) VALUES (
                :BookingsId,
                :ClientsId
                )
            ;";
            $database->query($query);
            $database->bind(':BookingsId', $var1);
            $database->bind(':ClientsId', $var2);
            if ($database->execute()) {
                header("location: booking_clients.php?BookingsId=$var1");
            }
            break;
        case 'check_before_insert':
            $ClientsId = $_REQUEST['ClientsId'];
            $query = "SELECT * FROM Bookings_Clients
                WHERE ClientsId = :ClientsId
                AND BookingsId = :BookingsId
            ;";
            $database->query($query);
            $database->bind(':ClientsId', $ClientsId);
            $database->bind(':BookingsId', $var1);
            return $rowCount = $database->rowCount();
            break;

        case 'insert_existing_client':
            $ClientsId = $_REQUEST['ClientsId'];
            $query = "INSERT INTO Bookings_Clients (
                BookingsId,
                ClientsId
                ) VALUES (
                :BookingsId,
                :ClientsId
                )
            ;";
            $database->query($query);
            $database->bind(':BookingsId', $var1);
            $database->bind(':ClientsId', $ClientsId);
            if ($database->execute()) {
                header("location: booking_clients.php?BookingsId=$var1");
            }
            break;

        default:
            // code...
            break;
    }
}

//This cool function that converts number to words doesn't belong to me
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}


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
    $ServiceType = $_REQUEST['ServiceType'];
    $StatusId = $_REQUEST['StatusId'];
    $CorporatesId = $_REQUEST['CorporatesId'];
    $SuppliersId = $_REQUEST['SuppliersId'];
    $search = trim($_REQUEST['search']);
    $mySearch = '%'.$search.'%';

    if ($ServiceDate1 == NULL && $ServiceType == NULL && $Status == NULL && $CorporatesId == NULL && $SuppliersId == NULL) {
        $n = 00000;
        $query = "SELECT ;";
        //TODO Resume report_Services.php HERE.
    }
}


?>
