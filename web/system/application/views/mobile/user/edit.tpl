{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

<h2>Edit Your Profile</h2>
<p class="note">* Required</p>
<form action="{$site_url}/user/update" method="post"
      name="update_form" id='updateForm'>

    {* Personal Information Section*}
    <section id="identity">
        <input class="default-value" title="First Name" type="text"
               placeholder='First Name' name="firstname" value="{$user.firstname|escape}" />
        <br />

        <input class="default-value" title="Last Name" type="text"
               placeholder='Last Name' name="lastname" value="{$user.lastname|escape}" />
        <br />

        <label for='userPrefix'>Prefix</label>
        <select id='userPrefix' title='Prefix' name='prefix'>
            <option name='mr'>Mr.</option>
            <option name='ms'>Ms.</option>
            <option name='mrs'>Mrs.</option>
        </select>
        <br />

        <input class="default-value" title="Date of Birth" type="text"
               placeholder='Date of Birth' name="dob" value="{$user.dob|escape}" />
        <br />
    </section>

    <section id="contact">
        <input class="default-value required" title="Email" type="email"
               placeholder='Email*' name="email" value="{$user.email|escape}" />
        <br />

        <input class="default-value required" title="Phone Number" type="text"
               placeholder='Phone Number*' name="phone" value="{$user.phone|escape}" />
        <br />
    </section>

    {* Address Section *}
    <section id="address">
        <input class="default-value" title="Street Address" type="text"
               placeholder='Street Address' name="street" value="{$user.street|escape}" />
        <br />

        <input class="default-value" title="City" type="text"
               placeholder='City' name="city" value="{$user.city|escape}" />
        <br />

        <input class="default-value" title="State/Province" type="text"
               placeholder='State/Province' name="state" value="{$user.state|escape}" />
        <br />

        <input class="default-value" title="Zip" type="text"
               placeholder='Zip/Postal Code' name="zip" value="{$user.zip|escape}" />
        <br />

        <input class="default-value" title="Country" type="text"
               placeholder='Country' name="country" value="{$user.country|escape}" />
     </section>

    {* Security Section *}
    <section id='securityQuestion1'>

        <label for='questionOne'>Security Question 1</label><br>
        <select id='questionOne' class='securityQuestion' title='Security Question 1' name='question1'>
            <option name='mom'>Mother's Maiden Name</option>
            <option name='dad'>Father's Middle Name</option>
            <option name='dog'>First Pet's Name</option>
        </select>

        <input class="default-value" title="Security Answer 1" type="text"
               placeholder='Answer' name="answer1" value="{$user.answer1|escape}" />
        <br />

        <input class="default-value" title="Security Clue 1" type="text"
               placeholder='Clue' name="clue1" value="{$user.clue1|escape}" />
        <br />
    </section>

    <section id='securityQuestion2'>
        <label for='questionTwo'>Security Question 2</label><br>
        <select id='questionTwo' class='securityQuestion' title='Security Question 2' name='question2'>
            <option name='mom'>Mother's Maiden Name</option>
            <option name='dad'>Father's Middle Name</option>
            <option name='dog'>First Pet's Name</option>
        </select>

    <input class="default-value" title="Security Answer 2" type="text"
           placeholder='Answer' name="answer2" value="{$user.answer2|escape}" />
    <br />

    <input class="default-value" title="Security Clue 2" type="text"
           placeholder='Clue' name="clue2" value="{$user.clue2|escape}" />
    <br />
    </section>

    <a href="{$site_url}/user/" class='cancelLink'>Cancel</a>
    <input type="submit" class="button" id="saveButton" value="Save" />
</form>
