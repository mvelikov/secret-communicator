$(document).ready(function() {
    var base_href = 'http://localhost/velikov-chat.phpfogapp.com/';
    $("#login-submit").click(function (e) {
        e.preventDefault();
        var user = $("#user").val(),
        pass = $("#pass").val();

        if (user != '' && pass != '') {
            $.ajax({
                url : base_href + 'user/index',
                type: 'post',
                data: {
                    'user' : user,
                    'pass' : pass
                },
                success : function (data) {
                    console.log(data);
                },
                error : function (error, type) {
                    console.log(error, type);
                }
            });
        }
    });
    $("body").append('<div pub-key="pub-0fe3be58-2601-4fba-b4b9-86af7844be5b" sub-key="sub-62ca94b0-b883-11e1-b535-e7b64b0eaf0b" ssl="on" origin="pubsub.pubnub.com" id="pubnub"></div><script src="http://cdn.pubnub.com/pubnub-3.1.min.js"></script>');

    $("#send").click(function () {
        var text = $("#message").val();
        $("#message").val('');
        if (text != '') {
            PUBNUB.publish({
                channel : 'hello_homework',
                message : text
            });
        }

    });
    setTimeout(subscribe, 1000);

    function subscribe (){

        // LISTEN FOR MESSAGES
        PUBNUB.subscribe({
            channel    : "hello_homework",      // CONNECT TO THIS CHANNEL.

            restore    : false,              // STAY CONNECTED, EVEN WHEN BROWSER IS CLOSED
            // OR WHEN PAGE CHANGES.

            callback   : function(message) { // RECEIVED A MESSAGE.
                var msg = 'Message recieved: <br />';
                msg += message;
                msg += '<br />' + (new Date).toUTCString() + '<br />';
                $('#message-box').prepend(msg);
            },

            disconnect : function() {        // LOST CONNECTION.
                console.log(
                    "Connection Lost." +
                    "Will auto-reconnect when Online."
                    );
            },

            reconnect  : function() {        // CONNECTION RESTORED.
                console.log("And we're Back!");
            },

            connect    : function() {        // CONNECTION ESTABLISHED.

            //					PUBNUB.publish({             // SEND A MESSAGE.
            //						channel : "hello_homework",
            //						message : "Hi Homework."
            //					});

            }
        })

    }

});