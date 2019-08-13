// function to check for 3 empty fields
function checkThreeFields(field1, field2, field3) {
    var field1 = document.getElementById(field1);
    var field2 = document.getElementById(field2);
    var field3 = document.getElementById(field3);

    if (field1.value == null || field1.value == 0 || field1.value == " ") {
        field1.style.background = 'red';
    }

    if (field2.value == null || field2.value == 0 || field2.value == " ") {
        field2.style.background = 'red';
    }

    if (field3.value == null || field3.value == 0 || field3.value == " ") {
        field3.style.background = 'red';
    }

    if (field1.value == null || field1.value == 0 || field1.value == " " || field2.value == null || field2.value == 0 || field2.value == " " || field3.value == null || field3.value == 0 || field3.value == " " ) {
        document.getElementsByClassName('error')[0].innerHTML = "Please fill out the empty field(s) in red!";
    }
    else {
        document.getElementById('buttonSubmit').type = 'submit';
    }
}

// function to display selected Currency
function selectCurrency() {
    var currency = document.getElementById('currency');
    var USD = document.getElementsByClassName('USD');
    var MMK = document.getElementsByClassName('MMK');

    if (currency.value === 'USD') {
        var m = 0;
        var u = 0;
        //showing the USD
        while (u < USD.length) {
            USD[u].style.display = 'block';
            u++;
        }
        //hiding the MMK
        while (m < MMK.length) {
            MMK[m].style.display = 'none';
            m++;
        }
    }
    else if (currency.value === 'MMK') {
        var m = 0;
        var u = 0;
        // showing the MMK
        while (m < MMK.length) {
            MMK[m].style.display = 'block';
            m++;
        }
        //hiding the USD
        while (u < USD.length) {
            USD[u].style.display = 'none';
            u++;
        }
    }
    else {
        var m = 0;
        var u = 0;
        //hiding the USD
        while (u < USD.length) {
            USD[u].style.display = 'none';
            u++;
        }
        //hiding the MMK
        while (m < MMK.length) {
            MMK[m].style.display = 'none';
            m++;
        }
    }
}

// function to fill date2
function autoFillSecondDate(date1, date2) {
    var date1 = document.getElementById(date1).value;
    document.getElementById(date2).value = date1;
}

//function to check 2 dates
function compareDates(date1, date2) {
    var date1 = document.getElementById(date1);
    var date2 = document.getElementById(date2);

    if (date1.value > date2.value) {
        var error = 'Please ensure that your dates are in order!';
        date1.style.background = 'brown';
        date2.style.background = 'brown';

        document.getElementsByClassName('error')[0].innerHTML = error;
        document.getElementById('buttonSubmit').disabled = true;
    }
    else {
        date1.style.background = 'white';
        date2.style.background = 'white';

        document.getElementsByClassName('error')[0].innerHTML = '';
        document.getElementById('buttonSubmit').disabled = false;
    }
}

//function to get number of nights for accommodations
function getQuantity () {
    var Date_in = document.getElementById('Date_in');
    var Date_out = document.getElementById('Date_out');
    if (Date_out.value > Date_in.value) {
        var date1 = new Date(Date_in.value);
        var date2 = new Date(Date_out.value);
        var diffTime = Math.abs(date2.getTime() - date1.getTime());
        var diffDay = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        document.getElementById('Quantity').value = diffDay;
        Date_out.style.background = 'none';
    }
    else {
        Date_out.style.background = 'brown';
        document.getElementsByClassName('error')[0].innerHTML = 'Check-out date must be later than the check-in date!';        
    }
}

//function to get checkout date
function getDate_out () {
    var checkin = new Date(document.getElementById('Date_in').value);
    var nights = document.getElementById('Quantity').value;
    var checkout = checkin.setTime(checkin.getTime() + (nights * 24 * 60 * 60 * 1000));
    var checkoutDate = new Date(checkout);
    var formatCheckoutDate = checkoutDate.getFullYear() + "-0" + (checkoutDate.getMonth() + 1) + "-" + checkoutDate.getDate();
    document.getElementById('Date_out').value = formatCheckoutDate ;

}

//function to calculate selling prices for hotel
function calculateHotelSell() {
    var Markup = document.getElementById('Markup');
    var MarkupPC = document.getElementById('Markup').value -0;
    var Cost1_USD = document.getElementById('Cost1_USD').value - 0;
    var Cost1_MMK = document.getElementById('Cost1_MMK').value - 0;
    var Cost2_USD = document.getElementById('Cost2_USD').value - 0;
    var Cost2_MMK = document.getElementById('Cost2_MMK').value - 0;
    var Cost3_USD = document.getElementById('Cost3_USD').value - 0;
    var Cost3_MMK = document.getElementById('Cost3_MMK').value - 0;

    Sell1_USD = (Cost1_USD * MarkupPC / 100) + Cost1_USD;
    Sell1_MMK = (Cost1_MMK * MarkupPC / 100) + Cost1_MMK;
    Sell2_USD = (Cost2_USD * MarkupPC / 100) + Cost2_USD;
    Sell2_MMK = (Cost2_MMK * MarkupPC / 100) + Cost2_MMK;
    Sell3_USD = (Cost3_USD * MarkupPC / 100) + Cost3_USD;
    Sell3_MMK = (Cost3_MMK * MarkupPC / 100) + Cost3_MMK;

    document.getElementById('Sell1_USD').value = Sell1_USD;
    document.getElementById('Sell1_MMK').value = Sell1_MMK;
    document.getElementById('Sell2_USD').value = Sell2_USD;
    document.getElementById('Sell2_MMK').value = Sell2_MMK;
    document.getElementById('Sell3_USD').value = Sell3_USD;
    document.getElementById('Sell3_MMK').value = Sell3_MMK;
}

//funtion to calculate selling princes for group
function calculateGroupServiceSell () {
    var Markup = document.getElementById('Markup');
    var MarkupPC = document.getElementById('Markup').value - 0;
    var Cost1_USD = document.getElementById('Cost1_USD').value - 0;
    var Cost1_MMK = document.getElementById('Cost1_MMK').value - 0;
    var Sell_USD = (Cost1_USD * MarkupPC / 100) + Cost1_USD;
    var Sell_MMK = (Cost1_MMK * MarkupPC / 100) + Cost1_MMK;
    document.getElementById('Sell_USD').value = Sell_USD;
    document.getElementById('Sell_MMK').value = Sell_MMK;
}

//function to adjust the Markup
function adjustMarkup(sell, cost) {
    var sell = document.getElementById(sell);
    var cost = document.getElementById(cost);
    var Markup = document.getElementById('Markup');
    var profit = sell.value - cost.value;
    var Markup = (profit / cost.value) * 100;
    var MarkupValue = Math.ceil(Markup * 100) / 100;
    document.getElementById('Markup').value = MarkupValue;
    // calculateHotelSell(); Need to recheck!!!
}

//function to check and submit accommodation service
function checkHotel() {
    var Date_in = document.getElementById('Date_in');
    var Date_out = document.getElementById('Date_out');
    var Sgl = document.getElementById('Sgl');
    var Dbl = document.getElementById('Dbl');
    var Twn = document.getElementById('Twn');
    var Tpl = document.getElementById('Tpl');
    var num0 = Sgl.value - 0;
    var num1 = Dbl.value - 0;
    var num2 = Twn.value - 0;
    var num3 = Tpl.value - 0;
    var rooms = num0 + num1 + num2 + num3;
    var Markup = document.getElementById('Markup');

    if (Date_out.value == "") {
        Date_out.style.background = 'red';
        document.getElementsByClassName('error')[0].innerHTML = 'Please input a check-out date!';
    }
    else if (Date_out.value < Date_in.value) {
        Date_out.style.background = 'red';
        document.getElementsByClassName('error')[0].innerHTML = 'Check-out date cannot be earlier than check-in date!';
    }
    else if (rooms === 0) {
        Sgl.style.background = 'brown';
        Dbl.style.background = 'brown';
        Twn.style.background = 'brown';
        Tpl.style.background = 'brown';
        document.getElementsByClassName('error')[0].innerHTML = 'Please input a proper number of room(s)!';
    }
    else if (Markup.value == 0 || Markup.value === null || Markup.value === "") {
        Markup.style.background = 'brown';
        document.getElementsByClassName('error')[0].innerHTML = 'Please input a proper markup!';
    }
    else {
        document.getElementById('buttonSubmit').type = 'submit';
    }
}

//function to generate Receipt
function generateReceipt () {
    var Method = document.getElementById('Method');
    if (Method.value == 0) {
        alert('Please select a proper payment method');
    }
    else {
        var myForm = document.getElementById('myForm');
        myForm.submit();
    }
}

//function to check if the value meets minimum requirement
function requireMininumValue (value, min, max) {
    var value = document.getElementById(value);

    if (value.value < min) {
        var error = 'The value entered is below limit! The value must be between '+min+' & '+max+'!';
        document.getElementById('buttonSubmit').disabled = true;
    }
    else if (value.value > max) {
        var error = 'The value entered is above limit!';
        document.getElementById('buttonSubmit').disabled = true;
    }
    else {
        var error = "";
        document.getElementById('buttonSubmit').disabled = false;
    }
    document.getElementsByClassName('error')[0].innerHTML = error;
}
