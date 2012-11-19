<h1>Add An Account</h1>
<form method="post" name="details_form" id='bankDetailsForm'>

    <!-- Bank Details Section -->
    <section id="details">
        <select id='bankTypeField' class='matte' title='Account Type' name='accounttype'>
            <option value='chequing'>Chequing</option>
            <option value='savings'>Savings</option>
        </select>

        <input class="default-value" title="Bank Name" type="text"
               placeholder='Bank Name' name="bankname" />
        <br />

        <input class="default-value" title="Transit Number (5 digits)" type="text"
               placeholder='Transit Number (5 digits)' name="transit" />
        <br />

        <input class="default-value" title="Institution Number (3 digits)" type="text"
               placeholder='Institution Number (3 digits)' name="institution" />
        <br />

        <input class="default-value" title="Account Number (1-12 digits)" type="text"
               placeholder='Account Number (1-12 digits)' name="banknumber" />
        <br />

        <input class="default-value" title="Confirm Account Number" type="text"
               placeholder='Confirm Account Number' name="banknumberconfirm" />
        <br />

    </section>
    
    <a class="cancelLink modal" href="#accounts.list">Back</a>
    <input type="submit" class="button wideButton" id="bankDetailsSubmit" value="OK">

</form>
