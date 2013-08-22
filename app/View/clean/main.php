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
                <div id="header"><a href="<?=conver_url("./?controller=clean&action=main")?>"><h1><?=$data['title']?></h1></a></div>
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
					
                        <div class="worklist">
                            <label class="tt item">
                                <span class="sp1">組別</span>
                                <span class="sp2">日期</span>
                                <span class="sp4">成員</span>
                                <span class="sp4"></span>
                                <span class="sp4"></span>
								<span class="sp4"></span>
                            </label>
                            <? foreach($data['group'] as $tmp): ?>
                            <label class="item">
                                <span class="sp1"><?=$tmp['name']?></span>
                                <span class="sp2"><?=$tmp['date']?></span>
								<?foreach($tmp['teammate'] as $rs):?>
                                <span class="sp4"><?=$rs['username']?></span>
								<?endforeach?>
                                <div class="cl"></div>
                            </label>
                            <?endforeach?>
                        </div>
                        <input type="hidden" value="<?=$tmp['id']?>" name="shop_id" />
                    
                </div>     
            </div>
        </div>
    </body>
</html>
