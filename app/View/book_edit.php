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
        <script type="text/javascript">

            function lg(url)
            {
                location.href = url
                return false;
            }

        </script>
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



                    <? if(count($data['orders'])>0) : ?>

                        <?foreach($data['orders'] as $value) :?>
                        <fieldset>
                            <form>
                                <h3><?=$value['shop_name']?>--[<?=$data['state'][$value['state']]?>]</h3>
                                <label class="tt item">
                                    <span class="sp2">書名</span>
                                    <span class="sp3">課名</span>
                                </label>
                                <?foreach($value['detail'] as $value2):?>
                                <label class="item">
                                    <span class="sp2"><?=$value2['name']?></span>
                                    <span class="sp3"><?=$value2['class_name']?></span>
                                    <div class="cl"></div>
                                </label>
                                <? endforeach?>
                                <span class="sall_count">Total：<?=$value['sall_count']?></span>
                                <span class="quantity">共<?=$value['book_quantity']?>本</span>
                                <!--<div class="action"><a href="./?controller=book&action=editorder&id=<?=$value['id']?>">修改</a></div>-->
                                <? if($value['state']==0):?>
                                <div class="cl"><input type="button" value="修改" id="change" onclick="lg('<?=conver_url('./?controller=book&action=editorder&id='.$value['id'])?>');"></div>
                                <? endif?>
                            </form>
                            </fieldset>
                         <?endforeach?>
                    <? endif?>
                </div>     
            </div>
        </div>
    </body>
</html>
