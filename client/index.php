<?php
header("Cache-Control: no-cache");?><!DOCTYPE html>
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
                <div id="login-page" class="page invisible">
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
                                    <input name="login_submit" class="field" id="login-submit" type="button" value="Submit" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="channels-list-page" class="page invisible">
                    <div class="wrapper">
                        <ul id="chennels-list" class="list">
                        </ul>
                    </div>
                </div>
                <div id="chat-room-page" class="page ">
                    <div class="wrapper">
                        <div id="message-box">
                            <div class="message">
                                <span class="author">mvelikov</span> said: <br />
                                test<br />
                                Fri, 13 Jul 2012 21:20:42 GMT<br />
                            </div>
                            <a id="load-last-messages" href="#" title="Load last 10 messages">Load last 10 messages</a>
                        </div>
                        <div class="form-wrapper">
                            <form action="#" name="message_form" id="message-form" method="post">
                                <div class="row">
                                    <label for="message" class="label">Message:</label>
                                    <textarea name="message" id="message" cols="20" rows="4" class="field"></textarea>
                                </div>
                                <div class="row">
                                    <label for="send" class="label">&nbsp;</label>
                                    <input type="button" id="send" name="send" value="Send" class="field" />
                                </div>
                            </form>
                            <form action="#" name="upload_file" id="upload-file" method="post" enctype="multipart/form-data">
                                <input id="userfile" type="file" name="userfile" class="field">
<!--                                <input type="submit" id="upload-btn" name="upload-btn" value="Upload" class="field" />-->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <footer id="footer">
                <h3>Developed by Mihail Velikov</h3>
                <a href="http://mihailvelikov.eu" target="_blank" title="Mihail Velikov Cloud Developer">http://mihailvelikov.eu</a>
            </footer>
        </div>
    </body>
</html>