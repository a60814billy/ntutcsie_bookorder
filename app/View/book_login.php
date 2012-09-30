<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
        <link rel="stylesheet" type="text/css" href="<?=WEB_ROOT?>/default.css" />
        <style type="text/css">
            #content{
                margin-top: 50px;
            }
            #login_form{
                margin: 0 auto;
                display: block;
                border: 1px solid #000;
                width: 460px;
                height: 440px;
                padding: 30px 10px;
            }
            #login_form #ti{
                font-size: 20pt;
                text-align: center;
            }
            #login_form form{
                margin: 100px auto 0px auto;
                width: 320px;
                position: relative;
            }
            #login_form input[type=submit]{
                right: 15px;
                position: absolute;
            }
            #message{
                display: block;
                z-index: 100;
            }
            #wrap{
                padding-left: 0px;
            }
        </style>
    </head>
    <body>
        <div id="wrap">
            <div id="main">
                <div id="content">
                    <div id="login_form">
                        <p id="ti">登入訂書系統</p>
                        <form action="<?=$data['login_url']?>" method="post">
                            <p><label><span>學號</span><input type="text" name="account" value="<?=$data['test_account']?>" /></label></p>
                            <p><label><span>密碼</span><input type="password" name="password" value="<?=$data['test_password']?>" /></label></p>
                            <input type="submit" value="登入" />
                        </form>
                        <?if(isset($data['message'])):?><div id="message"><?=$data['message']?></div><?endif?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
