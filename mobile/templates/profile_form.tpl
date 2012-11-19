<h1>Edit <br />Your Profile</h1>
<form method="post" name="update_form" id='profileForm'>

    <!-- Personal Information Section -->
    <section id="identity">
        <input class="default-value" title="First Name" type="text"
               placeholder='First Name' name="firstname" value="{{#firstname}}{{ firstname }}{{/firstname}}" />
        <br />

        <input class="default-value" title="Last Name" type="text"
               placeholder='Last Name' name="lastname" value="{{#lastname}}{{ lastname }}{{/lastname}}" />
        <br />

        <select id='userPrefix' title='Prefix' name='prefix'>
            <option value='mr'>Mr.</option>
            <option value='ms'>Ms.</option>
            <option value='mrs'>Mrs.</option>
        </select>               
        <br />

        <input class="default-value" title="Date of Birth" type="date"
               placeholder='Date of Birth' name="dob" value="{{#dob}}{{ dob }}{{/dob}}" />
        <br />
    </section>

    <section id="contact">
        <input class="default-value required" title="Email" type="email"
               placeholder='Email*' name="email" value="{{#email}}{{ email }}{{/email}}" />
        <br />

        <input class="default-value required" title="Phone Number"
               placeholder='Phone Number*' name="phone" type="tel" value="{{#phone}}{{ phone }}{{/phone}}" />
        <br />
    </section>

    <!-- Address Section  -->
    <section id="address">
        <input class="default-value" title="Street Address" type="text" autocorrect="off"
               placeholder='Street Address' name="street" value="{{#street}}{{ street }}{{/street}}" />
        <br />

        <input class="default-value" title="City" type="text"
               placeholder='City' name="city" value="{{#city}}{{ city }}{{/city}}" />
        <br />

        <input class="default-value" title="State/Province" type="text"
               placeholder='State/Province' name="state" value="{{#state}}{{ state }}{{/state}}" />
        <br />

        <input class="default-value" title="Zip" type="text"
               placeholder='Zip/Postal Code' name="zip" value="{{#zip}}{{ zip }}{{/zip}}" />
        <br />

        <input class="default-value" title="Country" type="text"
               placeholder='Country' name="country" value="{{#country}}{{ country }}{{/country}}" />
     </section>
    
    <a class="cancelLink" href="javascript:showTemplate('profile', '#modalWrapper');">Back</a>
    
    <input type="submit" class="button wideButton" id="saveButton" value="OK" />
</form>
