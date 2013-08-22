<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <form action="<?=$data['editshop_url']?>" method="post">
            <input type="hidden" name="id" value="<?=$data['shop']['data']['id']?>" />
            <p><label>商店名稱：<input type="text" name="name" value="<?=$data['shop']['data']['name']?>"</label></p>
            <p><label>起始日期&時間：<input type="text" name="start_time" value="<?=$data['shop']['data']['start_time']?>"</label></p>
            <p><label>終止日期&時間：<input type="text" name="terr_time" value="<?=$data['shop']['data']['terr_time']?>"</label></p>
            <fieldset >
                <legend>書籍</legend>
                <?foreach($data['shop']['info'] as $value) :?>
                    <p><label><input type="checkbox" name="product[]" value="<?=$value['id']?>" <?=$value['check']?> /><?=$value['name']?></label></p>
                <?endforeach?>
            </fieldset>
            <input type="submit" value="修改" />
        </form>
    </body>
</html>
