<h1>Edit Account</h1>
<form method="post" name="details_form" id='ccDetailsForm'>

    <!-- Credit Card Details Section -->
    <section id="details">
        <input type="hidden" name="id">
        <select id='cardTypeField' class='matte' title='Card Type' name='cardtype'>
            <option value=''>Select</option>
            <option value='1'>Visa</option>
            <option value='2'>MasterCard</option>
            <!--option value='3'>American Express</option>
            <option value='11'>Gift Card</option>
            <option value='12'>Gift Card</option-->
        </select>

        <input class="default-value" title="Card Number" type="tel"
               placeholder='Card Number' name="creditcardnumber"/>

        <select id='month' title='Month' name='month' class='matte expiry first'>
            <option value="select">Month</option>
            <option value='01'>01</option>
            <option value='02'>02</option>
            <option value='03'>03</option>
            <option value='04'>04</option>
            <option value='05'>05</option>
            <option value='06'>06</option>
            <option value='07'>07</option>
            <option value='08'>08</option>
            <option value='09'>09</option>
            <option value='10'>10</option>
            <option value='11'>11</option>
            <option value='12'>12</option>
        </select>

        <select id='year' title='Year' name='year' class='matte expiry'>
        	<option value="select">Year</option>
            <option value='12'>2012</option>
            <option value='13'>2013</option>
            <option value='14'>2014</option>
            <option value='15'>2015</option>
            <option value='16'>2016</option>
            <option value='17'>2017</option>
        </select>
        <br />

    </section>

    <a class="cancelLink modal" href="#accounts.list">Back</a>
    <input type="submit" class="button wideButton" id="ccDetailsSubmit" value="OK" />
</form>
