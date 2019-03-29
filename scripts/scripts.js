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
