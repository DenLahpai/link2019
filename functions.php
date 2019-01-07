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
        
        default:
            # code...
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
                Services_booking.Cost1_USD,
                Services_booking.Cost1_MMK,
                Services_booking.Markup,
                Services_booking.Sell_USD,
                Services_booking.Sell_MMK,
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
			
        case 'update_one':
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

            $sellPerUSD = $_REQUEST['sellPerUSD'];
            $sellPerMMK = $_REQUEST['sellPerMMK'];

            //getting Markup
            $profitUSD = $sellPerUSD - $Cost1_USD;
            $profitMMK = $sellPerMMK - $Cost2_MKK;

            if ($profitUSD == 0 && $profitMMK == 0) {
                $Markup = 0;
            } 
            elseif ($profitMMK == 0 && $profitUSD != 0) {
                $Markup = ($profitUSD / $Cost1_USD) * 100;
            }
            elseif ($profitUSD === 0 && $profitMMK != 0) {
                $Markup = ($profitMMK / $Cost1_MMK) * 100;
            }
			
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

?>
