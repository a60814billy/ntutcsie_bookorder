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

                    <?if(isset($data['shop'])):?>
                    
                    <? foreach($data['shop'] as $tmp): ?>
                    <? if( ($data['now']>=strtotime($tmp['start_time'])) && ($data['now']<=strtotime($tmp['terr_time']))):?>
                    <? if($tmp['order_num']==0):?>
                    <form style="width: 650px;" action="<?=$data['order_url']?>" method="post">
                        <h3><?=$tmp['name']?></h3>
                        <p>截止日期：<?=$tmp['terr_time']?></p>
                        <div class="books">
                            <label class="tt item">
                                <span class="sp1">.</span>
                                <span class="sp2">書名</span>
                                <span class="sp3">課名</span>
                                <span class="sp4">原價</span>
                                <span class="sp5">團購價</span>
                            </label>
                            <?foreach($tmp['book_list'] as $rs):?>
                            <label class="item">
                                <span class="sp1"><input type="checkbox" name="order[]" value="<?=$rs['id']?>" /></span>
                                <span class="sp2"><?=$rs['name']?></span>
                                <span class="sp3"><?=$rs['class_name']?></span>
                                <span class="sp4"><?=$rs['origin_price']?></span>
                                <span class="sp5"><?=$rs['sall_price']?></span>
                                <div class="cl"></div>
                            </label>
                            <?endforeach?>
                        </div>
                        <input type="submit" value="訂購" />
                        <input type="hidden" value="<?=$tmp['id']?>" name="shop_id" />
                    </form>
                    <?endif?>
                    <?endif?>
                    <?endforeach?>
                    <?endif?>
                </div>     
            </div>
        </div>
    </body>
</html>
