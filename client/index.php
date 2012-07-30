<?php header("Cache-Control: no-cache"); ?><!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="description" content="Chat application developer using cloud solutions and technologies by Mihail Velikov" />
        <meta name="keywords" content="HTML,CSS,JavaScript,PHP,Cloud,JSON,MongoDb" />
        <meta name="author" content="Mihail Velikov" />
        <meta charset="UTF-8" />
        <!--        <link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.8.21/themes/base/jquery-ui.css"  media="all"/>
                <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all">-->
        <link type="text/css" rel="stylesheet" href="css/style.css"  media="all" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <!--        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>-->
<!--         <script src="js/vendor/jquery.ui.widget.js"></script>
        <script src="js/jquery.iframe-transport.js"></script> -->
        <script src="js/ajaxupload.js"></script>
        <script src="script.js"></script>

    </head>
    <body>
        <div id="main-wrapper">
            <header>
                <div id="header">
                    <h1>Mihail Velikov Chat Application</h1>
                    <h2>Mihail Velikov Cloud Developer</h2>
                </div>
            </header>
            <section>
                <div id="login-page" class="page ">
                    <div class="wrapper">
                        <div class="form-wrapper">
                            <form name="login_form" id="login-form" method="post" action="#">
                                <div class="row">
                                    <label class="label" for="user">User:</label>
                                    <input type="text" name="user" id="user" class="field" />
                                </div>
                                <div class="row">
                                    <label class="label" for="pass">Password:</label>
                                    <input type="password" name="pass" id="pass" class="field" />
                                </div>
                                <div class="row">
                                    <label class="label" for="login-submit">&nbsp;</label>
                                    <input name="login_submit" class="field" id="login-submit" type="submit" value="Submit" />
                                </div>
                                <div class="row">
                                    <div id="error-message"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="channels-list-page" class="page invisible">
                    <div class="wrapper">
                        <h3>Channels List</h3>
                        <ul id="channels-list" class="list box">
                        </ul>
                        <form action="#" id="channel-form" method="post" name="channel_form">
                            <div class="row">
                                <h4>Insert New Channel</h4>
                                <label for="channel-name">Name:</label>
                                <input type="text" name="channel_name" id="channel-name" />
                                <input type="submit" value="Submit" id="submit-channel" name="submit_channel" />
                            </div>
                        </form>
                    </div>
                </div>
                <div id="chat-room-page" class="page invisible">
                    <div class="wrapper">
                        <div class="form-wrapper">
                            <form action="#" name="message_form" id="message-form" method="post">
                                <div class="row">
                                    <label id="message-label" for="message" class="label">Message:</label>
                                    <textarea name="message" id="message" cols="20" rows="4" class="field"></textarea>
                                    <input type="button" id="send" name="send" value="Send" class="field" />
                                </div>
                                <!--                                <div class="row">
                                                                    <label for="send" class="label">&nbsp;</label>-->

                                <!--                                </div>-->
                            </form>
                            <p class="tips">Use Ctrl + Enter to send the message!</p>
                            <div class="row">
                                <form action="#" name="upload_file" id="upload-file" method="post" enctype="multipart/form-data">
                                    <input id="userfile" type="file" name="userfile" class="field" />
                                </form>
                            </div>
                        </div>
                        <div id="message-box" class="box">
                            <a id="load-last-messages" href="#" title="Load last 10 messages">Load last 10 messages</a>
                        </div>

                    </div>
                </div>
                <div id="overlay"><img id="loader" src="images/loading.gif" alt="Loading..." /></div>
            </section>
            <footer id="footer">
                <h3>Developed by Mihail Velikov</h3>
                <a href="http://mihailvelikov.eu" target="_blank" title="Mihail Velikov Cloud Developer">http://mihailvelikov.eu</a>
            </footer>
        </div>
    </body>
</html>
