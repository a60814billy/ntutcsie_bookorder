<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
        <link rel="stylesheet" type="text/css" href="<?=WEB_ROOT?>/default.css" />
    </head>
    <body>
        <div id="wrap">
            <div id="main">
                <div id="header"><a href="<?=conver_url("./?controller=book&action=main")?>"><h1><?=$data['title']?></h1></a></div>
                <div id="menu">
                    <h2>選單</h2>
                    <p><?=$_SESSION['user']['username']?> 你好</p>
                    <ul>
                    <? foreach($data['menu'] as $key => $value):?>
                        <li><a href="<?=$value?>"><?=$key?></a></li>
                    <?endforeach?>
                    </ul>
                </div>
                <div id="content">
                    <?if(isset($data['message'])):?><div id="message"><?=$data['message']?></div><?endif?>
                    <form style="width: 300px;" action="<?=$data['form_url']?>" method="post">
                        <div><label><span>account</span><input type="text" name="account_id" /></label></div>
                        <input type="submit" value="change user" />
                        <input type="hidden" value="<?=$tmp['id']?>" name="shop_id" />
                    </form>
                </div>     
            </div>
        </div>
    </body>
</html>
