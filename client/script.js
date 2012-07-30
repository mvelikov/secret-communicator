$(document).ready(function() {
    var channel = '5004174b41075da575000000',
    userObj = {},
    page = 1, count = 0, per_page = 10, skip = 0,
    base_href = 'http://velikov-chat.phpfogapp.com/';

    $("#login-submit").live('click', function (e) {
        e.preventDefault();
        var user = $("#user").val(),
        pass = $("#pass").val();
        if (user != '' && pass != '') {
            $("#overlay").show();
            $.ajax({
                url : base_href + 'user/index',
                type: 'post',
                data: {
                    'user' : user,
                    'pass' : pass
                },
                success : function (data) {
                    if (typeof data !== 'undefined'
                        && data.success === true
                        && data.failed === false) {
                        userObj = {
                            'user' : user,
                            'pass' : data.pass
                        };

                        loadChannelsList();

                    } else {
                        $("#error-message").html(data.message).show();
                        $("#overlay").hide();
                    }
                },
                error : function (error, type) {
                    console.log(error, type);
                    userObj = {};
                }
            });
        } else {
            $("#error-message").html('Please, fill in user and password').show();
        }
    });
    $("body").append('<div pub-key="pub-0fe3be58-2601-4fba-b4b9-86af7844be5b" sub-key="sub-62ca94b0-b883-11e1-b535-e7b64b0eaf0b" ssl="on" origin="pubsub.pubnub.com" id="pubnub"></div><script src="http://cdn.pubnub.com/pubnub-3.1.min.js"></script>');
    $("#message").live('keypress', function (e) {
        if (e.ctrlKey && e.keyCode == 10) {
            e.preventDefault();
            $("#send").trigger('click');
        }
    });
    //        .focusin(function() {
    //           $(this) .key
    //        })
    //        .focusout(function () {
    //
    //        });

    $("#send").live('click', function () {
        var text = $("#message").val(), escaped_text = escape(text);
        $("#message").val('');
        if (text != '') {
            if (text.match(/https?:\/\/(www\.)?([a-zA-Z0-9_%\-]*)\b\.[a-z]{2,4}(\.[a-z]{2})?(.*)?/gi)) {
                var title = prompt('Enter title for the link', ''),
                link = prompt('Enter name for the link', '');
                if (title !== '' && link !== '') {
                    text = '<a href="' + text + '" title="' + title + '" target="_blank">' + link + '</a>';
                } else if (title === '') {
                    text = '<a href="' + text + '" target="_blank">' + link + '</a>';
                } else if (link === '') {
                    text = '<a href="' + text + '" target="_blank">' + escaped_text + '</a>';
                } else {
                    return;
                }
            } else {
                text = escaped_text;
            }
            $.ajax({
                url : base_href + 'message/insert',
                type: 'post',
                data : {
                    'message' : text,
                    'channel' : userObj.channel,
                    'pass' : userObj.pass
                },
                success : function (data) {
                    if (typeof data !== 'undefined'
                        && data.success === true) {
                        PUBNUB.publish({
                            channel : userObj.channel,
                            message : text
                        });
                    } else {
                        console.log(data);
                    }
                    if (skip !== null) {
                        skip++;
                    }
                },
                error : function () {
                    alert('error sending single message');
                }
            })

        }
    });
    $("#load-last-messages").live('click', function(e){
        e.preventDefault();

        $.ajax({
            url: base_href + 'message/get_many',
            type: 'post',
            data: {
                'channel' : userObj.channel,
                'number' : 10,
                'page' : page,
                'pass' : userObj.pass,
                'skip' : skip
            },
            success : function(data) {
                skip = null;
                var html = '';
                if (typeof data !== 'undefined'
                    && data.success === true
                    && typeof data.list == 'object') {
                    for (var i in data.list) {
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
                $("#load-last-messages").before(html);
                if ((data.page) * per_page >= count) {
                    $("#load-last-messages").remove();
                }
            }
        })
    });
    $("#submit-channel").live('click', function (e) {
        e.preventDefault();
        var channel = $("#channel-name").val(),
        escaped_channel = escape(channel);
        if (channel != '' && escaped_channel != '') {
            $.ajax({
                url : base_href + 'channel/insert',
                type: 'post',
                data : {
                    'pass': userObj.pass,
                    'channel' : escaped_channel
                },
                success : function (data) {
                    console.log(data);
                    var html = '';
                    if (typeof data === 'object') {
                        html = '<li><a href="#" class="channels" data-channel-id="' + data.$id + '" title="' + escaped_channel + '">' + escaped_channel + '</a></li>'
                    }
                    $("#channels-list").append(html);
                },
                error : function (a,b) {
                    console.log(a,b);
                }
            });
        }
    });
    $(".channels").live('click', function(e) {
        e.preventDefault();
        $("#overlay").show();
        userObj.channel = $(this).attr('data-channel-id');
        uploader.setData({
            'pass' : userObj.pass,
            'channel' : userObj.channel
        });
        subscribe();
        $("#channels-list-page").css({display: 'none'});
        $("#chat-room-page").css({display: 'block'});
    });
    function loadChannelsList() {
        $.ajax({
            url : base_href + 'channel/index',
            type : 'post',
            data : {
                'pass': userObj.pass
            },
            success : function (data) {
                var html = '';
                if (typeof data === 'object') {
                    for (var i in data) {
                        html += '<li><a href="#" class="channels" data-channel-id="' + data[i]._id + '" title="' + data[i].name + '">' + data[i].name + '</a></li>'
                    }
                }
                $("#channels-list").html(html);
                $("#login-form").css({display: 'none'});
                $("#channels-list-page").css({display: 'block'});
                $("#overlay").hide();
            },
            error : function (a, b) {
                console.log(a,b);
            }
        })
    }
    //setTimeout(subscribe, 2000);

    function subscribe (){

        // LISTEN FOR MESSAGES
        PUBNUB.subscribe({
            channel    : userObj.channel,      // CONNECT TO THIS CHANNEL.

            restore    : false,              // STAY CONNECTED, EVEN WHEN BROWSER IS CLOSED
            // OR WHEN PAGE CHANGES.

            callback   : function(message) { // RECEIVED A MESSAGE.
                var msg = '<div class="message"><span class="author">' + userObj.user + '</span> said: <br />';
                msg += message;
                msg += '<br />' + (new Date).toUTCString() + '<br /></div>';
                $('#message-box').prepend(msg);
            },

            disconnect : function() {        // LOST CONNECTION.
                setTimeout(function () {
                    alert(
                        "Connection Lost." +
                        "Will auto-reconnect when Online."
                        );
                }, 2000);
            },

            reconnect  : function() {        // CONNECTION RESTORED.
                alert("And we're Back!");
            },

            connect    : function() {        // CONNECTION ESTABLISHED.
                $("#overlay").hide();
            //					PUBNUB.publish({             // SEND A MESSAGE.
            //						channel : "hello_homework",
            //						message : "Hi Homework."
            //					});

            }
        })

    }
    var htmlEscapes = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#x27;',
        '/': '&#x2F;'
    };

    // Regex containing the keys listed immediately above.
    var htmlEscaper = /[&<>"'\/]/g;

    // Escape a string for HTML interpolation.
    escape = function(string) {
        return ('' + string).replace(htmlEscaper, function(match) {
            return htmlEscapes[match];
        });
    };

    var uploader = new AjaxUpload('userfile', {
        action: base_href + 'file/index',
        name: 'userfile',
        responseType: 'json',
        data: {},
        onComplete : function(file, data){
            if (typeof data === 'object' && data.message) {
                PUBNUB.publish({
                    channel : userObj.channel,
                    message : data.message
                });
            }
            $("#send").prop('disabled', false);
            this.enable();
            $("#overlay").hide();
        },
        onSubmit : function (file, extension) {
            $("#overlay").show();
            this.disable();
            $("#send").prop('disabled', true);
        }
    });
//    $('#userfile').live('change', function(e){
//        $(this).prop('disabled', true);
//        console.log("click");
//    });
/*$('#userfile').fileupload({
    url: base_href + 'file/index',
    maxFileSize: 5000000,
    dataType: 'json',
    done: function (e, data) {
        console.log(e, data);
        $.each(data.result, function (index, file) {
            $('<p/>').text(file.name).appendTo(document.body);
        });
    }
});*/
/*$("#upload-file").submit(function (e) {
    e.preventDefault();
    $.ajaxFileUpload({
        url: base_href + 'file/alt',
        secureuri:true,
        fileElementId:'userfile',
        dataType: 'json',
        data:{'pass' : userObj.pass},
        success: function (data, status)
        {
            console.log(data, status);
            if(typeof(data.error) != 'undefined')
            {
                if(data.error != '')
                {
                    alert(data.error);
                }else
                {
                    alert(data.msg);
                }
            }
        },
        error: function (data, status, e)
        {
            console.log('error ', data, status, e);
        }
    });
    return false;
});*/
});
//jQuery.handleError = function (a,b,c) {console.log(a,b,c); return true;}