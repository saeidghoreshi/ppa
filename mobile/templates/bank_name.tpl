<h1>Name on Card</h1>
<form method="post" name="name_form" id='bankNameForm'>

    <!-- Personal Information Section -->
    <section id="identity">
        <input class="default-value" title="Name (on card)" type="text"
               placeholder='Name (on card)' name="cardname" />
        <br />

        <label for='userPrefix'>Prefix</label>
        <select id='userPrefix' title='Prefix' name='prefix'>
            <option value='mr'>Mr.</option>
            <option value='ms'>Ms.</option>
            <option value='mrs'>Mrs.</option>
        </select>
        <br />

    <!-- Address Section  -->
    <section id="address">
        <input class="default-value" title="Street Address" type="text"
               placeholder='Street Address' name="street" />
        <br />

        <input class="default-value" title="City" type="text"
               placeholder='City' name="city" />
        <br />

        <input class="default-value" title="State/Province" type="text"
               placeholder='State/Province' name="state" />
        <br />

        <input class="default-value" title="Zip" type="text"
               placeholder='Zip/Postal Code' name="zip" />
     </section>

    <a href='#' class='cancelLink'>Back</a>
    <input type="submit" class="button wideButton slim" id="bankSaveButton" value="OK" />
</form>
