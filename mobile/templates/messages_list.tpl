    <!-- headerData = {"title": "Messages", "detail":"" } -->
<div id='modalStage' class="list">
    <div id="messagesList">
        <div class="listView" id="messagesListList">
            {{#messages}}
            <a href='#messages.detail' class='receiptsListItem modal' data-message_id='{{ message_id }}'>
                <span class='cost'>{{ merchant_name }}</span><br>
                <span class='time'>{{ message_title }}</span><br>
                <span class='vendor'>{{ message_date }}</span>
            </a>
            {{/messages}}
        </div>
    </div>
</div>