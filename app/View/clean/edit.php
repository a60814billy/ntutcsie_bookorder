<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
        <link rel="stylesheet" type="text/css" href="<?=WEB_ROOT?>/default.css" />
        <style type="text/css">
            .sall_count{
                position: absolute;
                right: 10px;
            }
            .action{
                margin: 5px 0px 0px 0px;
                right: 10px;
                position: absolute;
                border: 1px solid #bfbbbb;
                background-color: #e2dede;
                padding: 5px 0px;
                width: 80px;
                text-align: center;
                font-size: 14pt;
            }
            .action:hover{
                border-style: inset;
            }
            .action a:hover{
                text-decoration: none;
                
            }
        </style>
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



                    <? if($data['editwork']) : ?>

                        <fieldset>
                            <form method="post">
                                
								<div class="choiselist">
								<label class="tt item">
									<span class="sp1">選擇</span>
									<span class="sp1">組別</span>
									<span class="sp2">日期</span>
								</label>
								<? foreach($data['group'] as $tmp): ?>
									<label class="item">
										<span class="sp1"><input type="radio" name="check" value="<?=$tmp['id']?>" <?=$data['ccheck'][$tmp['id']]?> /></span>
										<span class="sp1"><?=$tmp['name']?></span>
										<span class="sp2"><?=$tmp['date']?></span>
										<div class="cl"></div>
									</label>
								<?endforeach?>
								<input type="submit" value="送出選擇" />
                            </form>
                            </fieldset>
                    <? endif?>
                </div>     
            </div>
        </div>
    </body>
</html>
