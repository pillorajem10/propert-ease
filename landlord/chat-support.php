<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Chat for Landlords</title>
    <!-- Include Bootstrap CSS, jQuery, and Popper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <!-- Pusher JavaScript SDK -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .customcontainer {
            width: 600px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            z-index: 100000;
        }
        .chatbox-container {
            width: 70%;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-left: 10px;
            display: none;
        }
        .chatlist-container {
            width: 30%;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            display: none;
        }
        .chatlist-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }
        .chatlist-item:hover {
            background-color: #f0f0f0;
        }
        .chatlist-item.active {
            background-color: #e0e0e0;
        }
        .chatlist-item .unread {
            background-color: #ff3b3b;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
        .chatlist-item .status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .status.online {
            background-color: #00ff00;
        }
        .status.offline {
            background-color: #ff0000;
        }
        .chatbox {
            height: 300px;
            overflow-y: auto;
            margin-bottom: 15px;
            padding-right: 10px;
        }
        .chat-message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            background-color: #f0f0f0;
        }
        .chat-message.me {
            background-color: #007bff;
            color: #fff;
        }
        .chat-message .message-time {
            font-size: 12px;
            color: #999;
        }
        .toggle-chat {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 20px;
            cursor: pointer;
        }
        .toggle-chat i {
            line-height: 50px;
        }
    </style>
</head>
<body>
<div class="container customcontainer">
    <div class="chatlist-container">
        <div class="chatlist-item active" data-tenant="Tenant 1">
            <div>
                <span>Tenant 1</span>
                <br>
                <small class="latest-message">Latest message preview...</small>
            </div>
            <div>
                <span class="unread">1</span>
                <div class="status online"></div>
            </div>
        </div>
        <div class="chatlist-item" data-tenant="Tenant 2">
            <div>
                <span>Tenant 2</span>
                <br>
                <small class="latest-message">Latest message preview...</small>
            </div>
            <div>
                <div class="status offline"></div>
            </div>
        </div>
        <!-- More chatlist items here -->
        <button class="btn btn-primary w-100 mt-3" id="newMessage">New Message</button>
    </div>
    <div class="chatbox-container" id="chatbox">
        <div class="chatbox">
            <div class="chat-message">
                <div class="message-text">Hello! How can I help you?</div>
                <div class="message-time">10:00 AM</div>
            </div>
            <!-- More chat messages here -->
        </div>
        <form id="messageForm">
            <div class="mb-3">
                <input type="text" class="form-control" id="message" placeholder="Type your message here...">
            </div>
            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>
    <button class="toggle-chat" id="toggleChat"><i class="fas fa-comment"></i></button>
</div>

<!-- New Message Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMessageModalLabel">New Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tenantSelect" class="form-label">Select Tenant</label>
                    <select class="form-select" id="tenantSelect">
                        <option value="Tenant 1">Tenant 1</option>
                        <option value="Tenant 2">Tenant 2</option>
                        <option value="Tenant 3">Tenant 3</option>
                        <!-- More tenants here -->
                    </select>
                </div>
                <button type="button" class="btn btn-primary" id="startNewMessage">Start Chat</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    var pusher = new Pusher('YOUR_PUSHER_KEY', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('chatbox');

    // Fetch and display latest message previews for each tenant
    function fetchLatestMessagePreviews() {
        $.get('fetch_latest_previews.php', function(data) {
            // Update chat list with the latest message previews
            $('.chatlist-item').each(function() {
                var tenant = $(this).data('tenant');
                var preview = data[tenant];
                $(this).find('.latest-message').text(preview);
            });
        });
    }

    // Call the function to fetch latest message previews on page load
    fetchLatestMessagePreviews();

    // Event listener for receiving new messages
    channel.bind('sendmessage', function (data) {
        var chatMessage = '<div class="chat-message"><div class="message-text">' + data.message + '</div><div class="message-time">' + getCurrentTime() + '</div></div>';
        $('.chatbox').append(chatMessage);
        $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight); // Scroll to bottom
        
        // Update message preview for the sender's tenant
        var tenant = data.tenant;
        var latestMessagePreview = data.message;
        $('.chatlist-item[data-tenant="' + tenant + '"] .latest-message').text(latestMessagePreview);
    });

    // Function to handle form submission (sending messages)
    $('#messageForm').submit(function (e) {
        e.preventDefault(); // Prevent default form submission
        var message = $('#message').val();
        var tenant = $('.chatlist-item.active').data('tenant');
        $.post('chat-function.php', {action: 'sendmessage', tenant: tenant, message: message}, function (response) {
            console.log(response);
            $('#message').val('');
            // Update message preview for the sender's tenant
            $('.chatlist-item[data-tenant="' + tenant + '"] .latest-message').text(message);
            // Update chatbox with the sent message
            var chatMessage = '<div class="chat-message me"><div class="message-text">' + message + '</div><div class="message-time">' + getCurrentTime() + '</div></div>';
            $('.chatbox').append(chatMessage);
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight); // Scroll to bottom
            
            // Update other tenant's chat preview if necessary
            $('.chatlist-item').not('.active').each(function() {
                var otherTenant = $(this).data('tenant');
                if (otherTenant !== tenant) {
                    // Fetch and update the preview for this tenant
                    $.get('fetch_latest_preview.php', {tenant: otherTenant}, function (data) {
                        $('.chatlist-item[data-tenant="' + otherTenant + '"] .latest-message').text(data);
                    });
                }
            });
        });
    });

    // Function to toggle chat box and chat list visibility
    $('#toggleChat').click(function () {
        $('.chatbox-container, .chatlist-container').slideToggle();
    });

    // Functionality for the "New Message" button
    $('#newMessage').click(function () {
        $('#newMessageModal').modal('show');
    });

    // Functionality for starting a new chat with a selected tenant
    $('#startNewMessage').click(function () {
        var tenant = $('#tenantSelect').val();
        if (!$('.chatlist-item[data-tenant="' + tenant + '"]').length) {
            $('.chatlist-container').append('<div class="chatlist-item" data-tenant="' + tenant + '"><div><span>' + tenant + '</span><br><small class="latest-message">Latest message preview...</small></div><div><div class="status online"></div></div></div>');
        }
        $('#newMessageModal').modal('hide');
        // Switch to the newly added tenant
        switchTenant(tenant);
    });

    // Functionality for switching chat based on selected tenant
    $(document).on('click', '.chatlist-item', function () {
        var tenant = $(this).data('tenant');
        switchTenant(tenant);
    });

    // Function to load chat messages for a specific tenant
    function loadChatMessages(tenant) {
        // Logic to load chat messages for the selected tenant
        $('.chatbox').html(''); // Clear current chat messages
        $.get('load_messages.php', {tenant: tenant}, function (data) {
            $('.chatbox').html(data);
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight); // Scroll to bottom
        });
    }

    // Close the new message modal when the close button is clicked
    $('.modal .btn-close').click(function() {
        $(this).closest('.modal').modal('hide');
    });

    // Function to switch chat to a specific tenant
    function switchTenant(tenant) {
        $('.chatlist-item').removeClass('active');
        $('.chatlist-item[data-tenant="' + tenant + '"]').addClass('active');
        loadChatMessages(tenant);
    }

    // Function to get current time
    function getCurrentTime() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
    
    // Hide chatbox and chatlist initially
    $('.chatbox-container, .chatlist-container').hide();
});
</script>
</body>
</html>