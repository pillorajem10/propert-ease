<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Chat</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Pusher JavaScript SDK -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
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
        }

        .chatlist-container {
            width: 30%;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
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
            position: absolute;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 20px;
            cursor: pointer;
        }

        .toggle-chat i {
            line-height: 40px;
        }
    </style>
</head>
<body>
<div class="container customcontainer">
    <div class="chatlist-container">
        <div class="chatlist-item active" data-landlord="Landlord 1">
            <div>
                <span>Landlord 1</span>
                <br>
                <small class="latest-message">Latest message preview...</small>
            </div>
            <div>
                <span class="unread">1</span>
                <div class="status online"></div>
            </div>
        </div>
        <div class="chatlist-item" data-landlord="Landlord 2">
            <div>
                <span>Landlord 2</span>
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
                    <label for="landlordSelectModal" class="form-label">Select Landlord</label>
                    <select class="form-select" id="landlordSelectModal">
                        <!-- Options will be dynamically loaded here -->
                    </select>
                </div>
                <button type="button" class="btn btn-primary" id="startNewMessage">Start Chat</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7/zAwPqMk65s5B+b5p1pVvD4/7nGvA7Jdke4oAV51IoanN9m8mP5IdsgcHBQ0a6t" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9FL1jdGyw3kUbj1pqn95sTIxvANqF5J79BZmlFS65I1wA3PKm6p+25E" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
    var pusher = new Pusher('501b026dfa7fa71d224d', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('chat-channel');

    function fetchLatestMessagePreviews() {
        $.get('fetch_latest_previews.php', function(data) {
            $('.chatlist-item').each(function() {
                var landlord = $(this).data('landlord');
                var preview = data[landlord];
                $(this).find('.latest-message').text(preview);
            });
        });
    }

    function fetchLandlords() {
        $.get('fetch_landlords.php', function(response) {
            try {
                var landlords = JSON.parse(response);
                var landlordSelectModal = $('#landlordSelect');
                landlordSelectModal.html('');
                
                landlords.forEach(function(landlord) {
                    var optionItem = '<option value="' + landlord.landlord_id + '">' + landlord.landlord_fname + '</option>';
                    landlordSelectModal.append(optionItem);
                });
            } catch (e) {
                console.error('Failed to parse JSON:', e, response);
                alert('Failed to fetch landlords.');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Failed to fetch landlords:', textStatus, errorThrown);
            alert('Failed to fetch landlords.');
        });
    }

    $('#newMessageModal').on('show.bs.modal', function () {
        fetchLandlords();
    });

    $('#startNewMessage').click(function() {
        var selectedLandlord = $('#landlordSelect').val();
        if (selectedLandlord) {
            $('#newMessageModal').modal('hide');
            switchLandlord(selectedLandlord);
        }
    });

    fetchLatestMessagePreviews();

    channel.bind('new-message', function (data) {
        var chatMessage = '<div class="chat-message"><div class="message-text">' + data.message + '</div><div class="message-time">' + getCurrentTime() + '</div></div>';
        $('.chatbox').append(chatMessage);
        $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
        
        var landlord = data.landlord;
        var latestMessagePreview = data.message;
        $('.chatlist-item[data-landlord="' + landlord + '"] .latest-message').text(latestMessagePreview);
    });

    $('#messageForm').submit(function (e) {
        e.preventDefault();
        var message = $('#message').val();
        var landlord = $('.chatlist-item.active').data('landlord');
        $.post('chat-function.php', {action: 'sendmessage', landlord: landlord, message: message}, function (response) {
            $('#message').val('');
            var chatMessage = '<div class="chat-message me"><div class="message-text">' + message + '</div><div class="message-time">' + getCurrentTime() + '</div></div>';
            $('.chatbox').append(chatMessage);
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
        });
    });

    $('#toggleChat').click(function () {
        $('.chatbox-container, .chatlist-container').slideToggle();
    });

    $('#newMessage').click(function () {
        $('#newMessageModal').modal('show');
    });

    $('#startNewMessage').click(function () {
        var landlord = $('#landlordSelect').val();
        if (!$('.chatlist-item[data-landlord="' + landlord + '"]').length) {
            $('.chatlist-container').append('<div class="chatlist-item" data-landlord="' + landlord + '"><div><span>' + landlord + '</span><br><small class="latest-message">Latest message preview...</small></div><div><div class="status online"></div></div></div>');
        }
        $('#newMessageModal').modal('hide');
        switchLandlord(landlord);
    });

    $(document).on('click', '.chatlist-item', function () {
        var landlord = $(this).data('landlord');
        switchLandlord(landlord);
    });

    function loadChatMessages(landlord) {
        $('.chatbox').html('');
        $.get('load_messages.php', {landlord: landlord}, function (data) {
            $('.chatbox').html(data);
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
        });
    }
    
    function switchLandlord(landlord) {
        $('.chatlist-item').removeClass('active');
        $('.chatlist-item[data-landlord="' + landlord + '"]').addClass('active');
        loadChatMessages(landlord);
    }

    function getCurrentTime() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        return hours + ':' + minutes + ' ' + ampm;
    }

    $('.chatbox-container, .chatlist-container').hide();
});
</script>

</script>
</body>
</html>