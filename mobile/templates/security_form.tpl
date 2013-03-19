<h1>Edit <br />Your Profile</h1>
<form method="post" name="update_form" id='securityForm'>

    <!-- Security Section  -->
    <section id='securityQuestion1'>

        <label for='questionOne'>Security Question 1</label><br>
        <select id='questionOne' class='securityQuestion' title='Security Question 1' name='question1'>
            <option value='mom'>Mother's Maiden Name</option>
            <option value='dad'>Father's Middle Name</option>
            <option value='dog'>First Pet's Name</option>
        </select>

        <input class="default-value" title="Security Answer 1" type="password" pattern="[0-9]+"
               placeholder='Answer' name="answer1" value="{{#answer1}}{{ answer1 }}{{/answer1}}" onfocus="if(this.value.indexOf('*')!=-1) this.value='';"/>
        <br />

        <input class="default-value" title="Security Clue 1" type="text"
               placeholder='Clue' name="clue1" value="{{#clue1}}{{ clue1 }}{{/clue1}}" />
        <br />
    </section>

    <section id='securityQuestion2'>
        <label for='questionTwo'>Security Question 2</label><br>
        <select id='questionTwo' class='securityQuestion' title='Security Question 2' name='question2'>
            <option value=''>Select</option>
            <option value='mom'>Mother's Maiden Name</option>
            <option value='dad'>Father's Middle Name</option>
            <option value='dog'>First Pet's Name</option>
        </select>

    <input class="default-value" title="Security Answer 2" type="text"
           placeholder='Answer' name="answer2" value="{{#answer2}}{{ answer2 }}{{/answer2}}" />
    <br />

    <input class="default-value" title="Security Clue 2" type="text"
           placeholder='Clue' name="clue2" value="{{#clue2}}{{ clue2 }}{{/clue2}}" onfocus="if(this.value.indexOf('*')!=-1) this.value='';" />
    <br />
    </section>
<!-- MERGING TODO -->
    <a href='#profile_form' class='cancelLink modal local'>Back</a>
    
    <input type="submit" class="button wideButton" id="saveButton" value="OK" />
    
</form>

<script>
$selection = x$('#questionOne').find('option');
for (i=0; i<$selection.length; i++) {
    if( $selection[i].value == '{{ question1 }}'  ) {
        $selection[i].selected = true;
    }
}
$selection = x$('#questionTwo').find('option');
for (i=0; i<$selection.length; i++) {
    if( $selection[i].value == '{{ question2 }}'  ) {
        $selection[i].selected = true;
    }
}
</script>
