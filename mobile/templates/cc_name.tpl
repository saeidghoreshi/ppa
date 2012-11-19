<h1>Name<br /> on Card</h1>
<form method="post" name="name_form" id='ccNameForm'>

    <!-- Personal Information Section -->
    <section id="identity">
        
        <input class="default-value" title="Account Name" type="text" autocorrect="off"
               placeholder='Account Name' name="nickname" />
        <br />
        
        <input class="default-value" title="First Name" type="text" autocorrect="off"
               placeholder='First Name' name="firstname" />
        <br />
        
        <input class="default-value" title="Last Name" type="text" autocorrect="off"
               placeholder='Last Name' name="lastname" />

        <!--label for='userPrefix'>Prefix</label>
        <select id='userPrefix1' title='Prefix' name='prefix1'>
            <option value='mr'>Mr.</option>
            <option value='ms'>Ms.</option>
            <option value='mrs'>Mrs.</option>
        </select-->
        <input id='userPrefix' class="default-value" title="Prefix" type="hidden"
               placeholder='Prefix' name="prefix" value=""/>

    <!-- Address Section  -->
    <section id="address">
        <input class="default-value" title="Street Address" type="text" autocorrect="off"
               placeholder='Street Address' name="street"/>
        <br />

        <input class="default-value" title="City" type="text" autocorrect="off"
               placeholder='City' name="city" />
        <br />

        <input class="default-value" title="State/Province Code" autocorrect="off" type="text"
               placeholder='State/Province Code' name="state" />
        <br />

        <input class="default-value" title="Country" type="text" autocorrect="off"
               placeholder='Country' name="country"/>
        <br />

        <input class="default-value" title="Zip/Postal Code" type="text" autocorrect="off"
               placeholder='Zip/Postal Code' name="zip" />
        <br />

        <input class="default-value" title="Security Number on Card" type="tel" pattern="[0-9]+" 
               placeholder='Security Number on Card' name="securitynumber" onBlur="this.type='password';" onFocus="if(this.value.indexOf('*')!=-1) this.value='';this.type='number';"/>

        <input class="default-value" title="PIN for this Account" type="tel" pattern="[0-9]+"
               placeholder='PIN for this Account' name="securitypin" onBlur="this.type='password';" onFocus="if(this.value.indexOf('*')!=-1) this.value='';this.type='number';"/>

    <a class="cancelLink modal local" href="#cc_details">Back</a>
    <input type="submit" class="button wideButton slim" id="ccSaveButton" value="OK" />

     </section>
</form>
