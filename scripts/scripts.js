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
        date2.style.background = 'red';
        alert(error);
    }
    else {
        document.getElementById('buttonSubmit').type = 'submit';
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
        alert('Check-out date must be later than the check-in date!');
    }
}

//function to calculate selling prices for hotel
function calculateHotelSell() {
    var Markup = document.getElementById('Markup');
    var MarkupPC = document.getElementById('Markup').value -0;
    var Cost1_USD = document.getElementById('Cost1_USD').value -0;
    var Cost1_MMK = document.getElementById('Cost1_MMK').value -0;
    var Cost2_USD = document.getElementById('Cost2_USD').value -0;
    var Cost2_MMK = document.getElementById('Cost2_MMK').value -0;
    var Cost3_USD = document.getElementById('Cost3_USD').value -0;
    var Cost3_MMK = document.getElementById('Cost3_MMK').value -0;

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

//function to adjust the Markup
function adjustMarkup(sell, cost) {
    var sell = document.getElementById(sell);
    var cost = document.getElementById(cost);
    var Markup = document.getElementById('Markup');
    var profit = sell.value - cost.value;
    var Markup = (profit / cost.value) * 100;
    document.getElementById('Markup').value = Markup;
    calculateHotelSell();
}
