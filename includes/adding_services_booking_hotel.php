<?php

?>
<!-- service form -->
<div class="service form">
    <form action="#" method="post" id="myForm">
        <ul>
            <li class="bold">
                Hotel:
                <? echo $row_Services->Name; ?>
            </li>
            <li>
                Room Type:
                <? echo $row_Services->Service; ?>
            </li>
            <li>
                Check-in:
                <input type="date" name="Date_in" id="Date_in" value="<? echo $Date_in; ?>">
            </li>
            <li>
                Check-out:
                <input type="date" name="Date_out" id="Date_out" value="">
            </li>
            <li>
                Number of Rooms:
            </li>
            <li>
                Single:
                <input type="number" name="Sgl" id="Sgl">
            </li>
            <li>
                Double:
                <input type="number" name="Dbl" id="Dbl">
            </li>
            <li>
                Twin:
                <input type="number" name="Twn" id="Twn">
            </li>
            <li>
                Triple:
                <input type="number" name="Tpl" id="Tpl">
            </li>
            <li class="error"></li>
            <li>
                <button type="button" name="buttonSubmit" id="buttonSubmit" onclick="checkHotel();">Submit</button>
            </li>
        </ul>
    </form>
</div>
<!-- end of service form -->
<script type="text/javascript">
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
        else {
            document.getElementById('buttonSubmit').type = 'submit';
        }
    }
</script>
