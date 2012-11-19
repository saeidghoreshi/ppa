<h1>Add An Account</h1>
<form method="post" name="account_form" id='accountTypeForm' target="_blank">

    <!-- Account Type Section  -->
    <section id='accountType'>

        <select id='accountTypeField' class='matte' title='Account Type' name='accounttype'>
            <option value=''>Type of Account</option>
            <option value='1_visa'>Credit Card</option>
            <!--option value='10_chequing'>Chequing</option>
            <option value='10_savings'>Savings</option-->
            <!--option value='9_gc'>Gift Card</option-->
            <!--option value='9_pp'>PayPal</option-->
        </select>

    </section>

    <a class="cancelLink modal" href="#accounts.list">Back</a>
    
    <input type="submit" class="button wideButton" id="bankDetailsSubmit" value="OK">
    <input type="hidden" name="session" id="session" value="">

</form>

