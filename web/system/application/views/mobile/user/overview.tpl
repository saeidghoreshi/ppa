<h2>Overview</h2>
{if $user}
    <a href="{$site_url}/user/logout">Logout</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{$site_url}/user/edit">Add Account</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{$site_url}/user/edit">Edit Profile</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{$site_url}/user/edit_passcode">Edit Passcode</a>
    <br/>
    <br/>
    <b>First Name:</b> {$user.firstname}
    <br/>
    <b>Last Name:</b> {$user.lastname}
    <br/>
    <b>Prefix:</b> {$user.prefix}
    <br/>
    <b>Date of Birth:</b> {$user.dob}
    <br/>
    <br/>
    <br/>
    <b>Street Address:</b> {$user.street}
    <br/>
    <b>City:</b> {$user.city}
    <br/>
    <b>State/Province:</b> {$user.state}
    <br/>
    <b>Zip/Postal Code:</b> {$user.zip}
    <br/>
    <b>Country:</b> {$user.country}
    <br/>
    <br/>
    <br/>
    <b>Email:</b> {$user.email}
    <br/>
    <b>Phone:</b> {$user.phone}
    <br/>
    <br/>
    <br/>
    <b>Security Question 1:</b> {$user.question1}
    <br/>
    <b>Security Answer 1:</b> {$user.answer1}
    <br/>
    <b>Security Clue 1:</b> {$user.clue1}
    <br/>
    <br/>
    <b>Security Question 2:</b> {$user.question2}
    <br/>
    <b>Security Answer 2:</b> {$user.answer2}
    <br/>
    <b>Security Clue 2:</b> {$user.clue2}
{else}
    User not found.
{/if}
