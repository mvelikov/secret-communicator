$(document).ready(function() {
    var channel = '5004174b41075da575000000';
    var userObj = {
        'user' : 'mvelikov',
        'pass' : '123456',
        'channel' : channel
    };
    var page = 1, count = 0, per_page = 10;
    var base_href = 'http://velikov-chat.phpfogapp.com/';

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
                    userObj = {
                        'user' : user,
                        'pass' : pass
                    };
                },
                error : function (error, type) {
                    console.log(error, type);
                    userObj = {};
                }
            });
        }
    });
    $("body").append('<div pub-key="pub-0fe3be58-2601-4fba-b4b9-86af7844be5b" sub-key="sub-62ca94b0-b883-11e1-b535-e7b64b0eaf0b" ssl="on" origin="pubsub.pubnub.com" id="pubnub"></div><script src="http://cdn.pubnub.com/pubnub-3.1.min.js"></script>');

    $("#send").click(function () {
        var text = $("#message").val();
        $("#message").val('');
        if (text != '') {
            if (text.match(/https?:\/\/(www\.)?([a-zA-Z0-9_%]*)\b\.[a-z]{2,4}(\.[a-z]{2})?(.*)/gi)) {
                title = prompt('Enter title for the link', '');
                link = prompt('Enter name for the link', '');
                text = '<a href="' + text + '" title="' + title + '" target="_blank">' + link + '</a>';
            }
            $.ajax({
                url : base_href + 'message/insert',
                type: 'post',
                data : {
                    'message' : text,
                    'channel' : userObj.channel
                },
                success : function (data) {
                    if (typeof data !== 'undefined'
                        && data.success === true) {
                            PUBNUB.publish({
                            channel : channel,
                            message : text
                        });
                    } else {
                        console.log(data);
                    }

                },
                error : function () {
                    alert('error sending single message');
                }
            })

        }
    });
    $("#load-last-messages").click(function(e){
        e.preventDefault();
        console.log(page);
        $.ajax({
            url: base_href + 'message/get_many',
            type: 'post',
            data: {
                'channel' : userObj.channel,
                'number' : 10,
                'page' : page,
            },
            success : function(data) {

                var html = '';
                if (typeof data !== 'undefined'
                    && data.success === true
                    && typeof data.list == 'object') {
                    for (var i in data.list) {
                        console.log(data.list[i]);
                        html += '<div class="message">';
                        html += '<span class="author">';
                        html += data.list[i].user + '</span> said: <br />';
                        html += data.list[i].message + '<br />';
                        html += (new Date(data.list[i].time * 1000)).toUTCString();
                        html += '</div>';
                    }
                }
                page++;
                count = data.count || count;
                per_page = data.per_page || per_page;
                if ((data.page - 1) * per_page >= count) {
                    $("#load-last-messages").remove();
                }
                $("#load-last-messages").before(html);
            }
        })
    });
    setTimeout(subscribe, 2000);

    function subscribe (){

        // LISTEN FOR MESSAGES
        PUBNUB.subscribe({
            channel    : channel,      // CONNECT TO THIS CHANNEL.

            restore    : false,              // STAY CONNECTED, EVEN WHEN BROWSER IS CLOSED
            // OR WHEN PAGE CHANGES.

            callback   : function(message) { // RECEIVED A MESSAGE.
                var msg = '<div class="message"><span class="author">' + userObj.user + '</span> said: <br />';
                msg += message;
                msg += '<br />' + (new Date).toUTCString() + '<br /></div>';
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
$(function () {
    $('#fileupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $('<p/>').text(file.name).appendTo(document.body);
            });
        }
    });
});