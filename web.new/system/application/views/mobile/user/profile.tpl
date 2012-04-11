    <h2>Overview</h2> 

    <div id='profileData'>
    <section id='identity'>
        <span id='prefix'>{$user.prefix}</span> <span id='firstName'>{$user.firstname}</span> <span id='lastName'>{$user.lastname}</span><br>
        <span id='dob'>{$user.dob}</span>
    </section>

    <section id='address'>
        <span id='street'>{$user.street}</span><br>
        <span id='city'>{$user.city}</span><br>
        <span id='state'>{$user.state}</span><br>
        <span id='zip'>{$user.zip}</span><br>
        <span id='country'>{$user.country}</span><br>
    </section>

    <section id='contact'>
        <span id='email'>{$user.email}</span><br>
        <span id='phone'>{$user.phone}</span><br>
    </section>
    </div>

    <a href='{$site_url}/user/edit'>Edit Your Profile</a>
