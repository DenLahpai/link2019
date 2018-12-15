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
