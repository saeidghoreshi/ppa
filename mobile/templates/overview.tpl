<a id='doneButton' class='local' href="#keypad">Done</a>

<h1 id='overviewTitle'>Overview</h1>
    <div id='sectionButtons'>
        <a class='overviewButton modal' href='#messages.list'>What's Good</a>
        <a class='overviewButton modal' href='#accounts.list'>Accounts</a>
        <a class='overviewButton modal' href='#profile'>Profile</a>
        <a class='overviewButton modal' href='#receipts.list'>Receipts</a>
        <a class='overviewButton modal' href='#shops.list'>Shops</a>
    </div>

    <form id="smsShare">
        <p onclick="return false;alert('uuid: '+(window.device?window.device.uuid:'web_id'));return false;" id='shareMsg'>Share PPA with a Friend</p>
        <input placeholder='Enter Phone Number' title='Phone Number' type='tel' name='phone' />
        <br>

        <input type='submit' class='button wideButton' value='Send' />
    </form>
