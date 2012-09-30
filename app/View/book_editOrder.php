
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

                    <?if(isset($data['edit_url'])):?>
        
                    <form style="width: 650px;" action="<?=$data['edit_url']?>" method="post">
                        <input type="hidden" value="<?=$data['order']['id']?>" name="orderid" />
                        <h3><?=$data['shop']['name']?></h3>
                        <div class="books">
                            <label class="tt item">
                                <span class="sp1">.</span>
                                <span class="sp2">書名</span>
                                <span class="sp3">課名</span>
                                <span class="sp4">原價</span>
                                <span class="sp5">團購價</span>
                            </label>
                            <?foreach($data['book_list'] as $rs):?>
                            <label class="item">
                                <span class="sp1"><input type="checkbox" name="order[]" value="<?=$rs['id']?>" <?=$rs['check']?> /></span>
                                <span class="sp2"><?=$rs['name']?></span>
                                <span class="sp3"><?=$rs['class_name']?></span>
                                <span class="sp4"><?=$rs['origin_price']?></span>
                                <span class="sp5"><?=$rs['sall_price']?></span>
                                <div class="cl"></div>
                            </label>
                            <?endforeach?>
                        </div>
                        <input type="submit" value="修改" />
                    </form>
                    <?endif?>
                </div>     
            </div>
        </div>
    </body>
</html>
