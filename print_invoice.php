<?php
require_once "functions.php";

//getting data from the table Users
$rows_Users = table_Users('select_one', $_SESSION['UsersId'], NULL);
foreach ($rows_Users as $row_Users) {
    // code...
}

//getting the InvoiceNo
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //getting data from the form
    $InvoiceNo = $_REQUEST['InvoiceNo'];
    $Name = trim($_REQUEST['Name']);
    $Email = trim($_REQUEST['Email']);
    $Password = trim($_REQUEST['Password']);
    $database = new Database();
    $query = "INSERT INTO Online_payers (
            Email,
            Password,
            InvoiceNo,
            Name
        ) VALUES(
            :Email,
            :Password,
            :InvoiceNo,
            :Name
        )
    ;";
    $database->query($query);
    $database->bind(':Email', $Email);
    $database->bind(':Password', $Password);
    $database->bind(':InvoiceNo', $InvoiceNo);
    $database->bind(':Name', $Name);
    if ($database->execute()) {
        //Emailing the link with username and password to the client
        $subject = "Online Payment from Link in Myanmar Travel";
        $message = "<p>";
        $message .= "Dear Sir/Madam, <br><br>";
        $message .= "Greetings from Link In Myanmar Travel! <br><br>";
        $message .= "Please kindly find the link for payment by Visa / MasterCard below. <br><br>";
        $message .= "<a href=\"http://denlp.com/Online_Payment\">Online Payment Link In Myanmar</a><br><br>";
        $message .= "Username: ".$Email."<br>";
        $message .= "Password: ".$Password."<br><br>";
        $message .= "Please don't hesitate to contact us for more details.<br><br>";
        $message .= "Best Regards, <br><br>";
        $message .= $row_Users->Fullname;

        $headers = "FROM: Link In Myanmar <info@linkinmyanmar.com>\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($Email, $subject, $message, $headers);
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = $row_Bookings->Reference.' - '.$InvoiceNo;
    include "includes/head.html";
    ?>
    <body>
        <!-- print -->
        <div class="print">
            <!-- pageHeader -->
            <div class="pageHeader">
                <table>
                    <thead>
                        <tr>
                            <td>
                                <img src="images/LinkLogo.jpg" alt="Link Logo">
                            </td>
                            <td>
                                <ul>
                                    <li class="bold">Link In Myanmar Travel Co Ltd.</li>
                                    <li>No. 72, Tayoke Kyaung Street</li>
                                    <li>Sanchaung, Township, Yangon</li>
                                    <li>Tel: 95-9402590317</li>
                                    <li>Email: <a href="mailto:infor@linkinmyanmar.com">info@linkinmyanmar.com</a></li>
                                    <li>Website: <a href="http://www.linkinmyanmar.com">www.linkinmyanmar.com</a></li>
                                </ul>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- end of pageHeader -->
            <!-- Invoice -->
            <div class="Invoice">
                <h1>
                    Invoice
                </h1>
                <!-- InvoiceHead -->
                <div class="InvoiceHead">
                    <table>
                        <thead>
                            <tr>
                                <td>
                                    <ul>
                                        <li>
                                            Addressee:
                                            <? echo $row_InvoiceHeader->Addressee; ?>
                                        </li>
                                        <li>
                                            Address:
                                            <? echo $row_InvoiceHeader->Address; ?>
                                        </li>
                                        <li>
                                            City:
                                            <? echo $row_InvoiceHeader->City; ?>
                                        </li>
                                        <li>
                                            Attn:
                                            <? echo $row_InvoiceHeader->Attn; ?>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>
                                            Date:
                                            <? echo date('d-M-Y', strtotime($row_Invoices->InvoiceDate)); ?>
                                        </li>
                                        <li>
                                            Invoice No:
                                            <? echo $InvoiceNo; ?>
                                        </li>
                                        <li>
                                            Booking Reference:
                                            <? echo $row_Bookings->Reference; ?>
                                        </li>
                                        <li>
                                            Booking Name:
                                            <? echo $row_Bookings->Name;  ?>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- End of InvoiceHead -->
                <!-- InvoiceBody -->
                <div class="InvoiceBody">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount in <? echo $currency; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows_InvoiceDetails as $row_InvoiceDetails) {
                                $year = date('Y', strtotime($row_InvoiceDetails->Date));
                                if ($year >= 2019) {
                                    echo "<tr>";
                                    echo "<td>".date("d-M-y", strtotime($row_InvoiceDetails->Date))."</td>";
                                    echo "<td>".$row_InvoiceDetails->Description."</td>";
                                    echo "<td>";
                                    if ($currency == 'USD') {
                                        echo $row_InvoiceDetails->USD;
                                    }
                                    else {
                                        echo $row_InvoiceDetails->MMK;
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                            <tr>
                                <th colspan="2">Total in <? echo $currency; ?></th>
                                <th>
                                    <?php
                                    if ($currency == 'USD') {
                                        echo $total = $row_Invoices->USD;
                                    }
                                    elseif ($currency == 'MMK') {
                                        echo $total = $row_Invoices->MMK;
                                    }
                                    else {
                                        echo 'Please contact your administrator!';
                                    }
                                    ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        Amount in <? echo $currency." : ".ucwords(convert_number_to_words(round($total,0)))." ONLY."; ?>
                        <br>
                        Sales Person : <? echo $row_Users->Fullname; ?>
                        <br>
                        Payment Method :
                        <select name="Method" id="Method" onchange="selectPaymentMethod();">
                            <option value="0">Select One</option>
                            <option value="1">Cash</option>
                            <option value="2">UOB USD & SGD</option>
                            <option value="3">Visa/Master</option>
                            <option value="4">KBZ MMK</option>
                            <option value="5">CB MMK & USD</option>
                            <option value="6">Aya MMK</option>
                            <option value="7">DBS</option>
                            <option value="8">FOC</option>
                            <option value="9">YOMA</option>
                            <option value="10">MAB</option>
                        </select>
                    </p>
                    <div id="Cash" class="invisible">
                        <p>
                            Please let us know the time and location for payment collection.
                        </p>
                    </div>
                    <div id="UOB" class="invisible">
                        <p>
                            Beneficiary Name: Link In Asia Pte Ltd. <br>
                            Beneficiary Address: 111, North Bridge Rd, #13-01, Peninsula Plaza, Singapore 179098 <br>
                            Account No: 3549007730 (USD) <br>
                            Account No: 3483159801 (SGD) <br>
                            Bank Name: United Oversea Bank <br>
                            Bank Address: UOB Rochor, 149 Rochor Rd, #01-26 Fu Lu Shou Complex, Singapore 188425 <br>
                            Bank Code: 7375 <br>
                            Branch Code: 047 <br>
                            Swift Code: UOVBSGSG <br>
                            Please send us a copy of the bank transfer order once the remittance has been done.
                        </p>
                    </div>
                    <div id="CreditCard" class="invisible">
                        <form action="#" method="post">
                            <ul>
                                <li class="bold">Create an Online Payer</li>
                                <li>
                                    Invoice No:
                                    <input type="text" name="InvoiceNo" id="InvoiceNo" value="<? echo $InvoiceNo; ?>" readonly>
                                </li>
                                <li>
                                    Name:
                                    <input type="text" name="Name" id="Name" value="<? echo $row_InvoiceHeader->Attn; ?>">
                                </li>
                                <li>
                                    Email:
                                    <input type="email" name="Email" id="Email" placeholder="someone@email.com" required>
                                </li>
                                <li>
                                    Password:
                                    <input type="text" name="Password" id="Password" placeholder="Create a Password" required>
                                </li>
                                <li>
                                    <button type="button" id="buttonSubmit" name="buttonSubmit" class="button submit" onclick="checkThreeFields('InvoiceNo', 'Email', 'Password')">Send Email</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div id="KBZ" class="invisible">
                        <p>
                            Account Name: L Mung Den Nong, PRS(C)0004 <br>
                            Account No: 999-307-057-007-596-01 <br>
                            Bank Name: Kanbawza Bank <br>
                            Please send us a copy of the bank transfer slip once the payment has been made.
                        </p>
                    </div>
                    <div id="CB" class="invisible">
                        <p>
                            Account Name: Link In Myanmar Travel Co Ltd <br>
                            Account No: 0010101200070033 (USD) <br>
                            Account No: 0010100500010294 (MMK) <br>
                            Bank Name: CB Bank <br>
                            Please send us a copy of the bank transfer slip once the payment has been made.
                        </p>
                    </div>
                    <div id="Aya" class="invisible">
                        <p>
                            Account Name: L Mung Den Nong, 12/SaKhaNa(N)083146 <br>
                            Account No: 0144223010004909 <br>
                            Bank Name: Aya Bank <br>
                            Please send us a copy of the bank transfer slip once the payment has been made.
                        </p>
                    </div>
                    <div id="DBS" class="invisible">
                        <p>
                            Beneficiary Name: Link In Asia Pte Ltd. <br>
                            Beneficiary Address: 111, North Bridge Rd, #13-01, Peninsula Plaza, Singapore 179098 <br>
                            Account No: 0003-016672-01-7-022 (USD) <br>
                            Bank Name: DBS Bank <br>
                            Bank Address: 6 Shenton Way, DBS Building, Singapore 068809 <br>
                            Bank Code: 7171 <br>
                            Swift Code: DBSSSGSG <br>
                            Please send us a copy of the bank transfer order once the remittance has been done. <br>
                        </p>
                    </div>
                    <div id="YOMA" class="invisible">
                        <p>
                            Account Name: L Mung Den Nong, 12/SaKhaNa(N)083146 <br>
                            Account No: 002145188000473 <br>
                            Bank Name: Yoma Bank <br>
                            Please send us a copy of the bank transfer slip once the payment has been made.
                        </p>
                    </div>
                    <div id="MAB" class="invisible">
                        <p>
                            Account Name: L Mung Den Nong, 12/SaKhaNa(N)083146 <br>
                            Account No: 0430121043003128014 <br>
                            Bank Name: MAB (Myanmar Apex Bank) <br>
                            Please send us a copy of the bank transfer slip once the payment has been made.
                        </p>
                    </div>
                </div>
                <!-- End of InvoiceBody -->
            </div>
            <!-- end of Invoice -->
        </div>
        <!-- print -->
    </body>
    <script type="text/javascript">
        function selectPaymentMethod() {
            var selected = document.getElementById('Method').value;

            switch (selected) {
                case '1':
                    document.getElementById('Cash').style.display = 'block';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '2':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'block';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '3':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'block';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case  '4':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'block';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '5':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'block';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '6':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'block';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '7':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'block';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '8':
                document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '9':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'block';
                    document.getElementById('MAB').style.display = 'none';
                    break;

                case '10':
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'block';
                    break;

                default:
                    document.getElementById('Cash').style.display = 'none';
                    document.getElementById('UOB').style.display = 'none';
                    document.getElementById('CreditCard').style.display = 'none';
                    document.getElementById('KBZ').style.display = 'none';
                    document.getElementById('CB').style.display = 'none';
                    document.getElementById('Aya').style.display = 'none';
                    document.getElementById('DBS').style.display = 'none';
                    document.getElementById('YOMA').style.display = 'none';
                    document.getElementById('MAB').style.display = 'none';
                    break;
            }
        }
    </script>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</html>
