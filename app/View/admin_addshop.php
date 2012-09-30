<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <form action="<?=$data['addshop_url']?>" method="post">
            <p><label>商店名稱：<input type="text" name="name"></label></p>
            <p><label>起始日期&時間：<input type="text" name="start_time" /></label></p>
            <p><label>終止日期&時間：<input type="text" name="terr_time" /></label></p>
            <fieldset >
                <legend>書籍</legend>
                <?foreach($data['book_lsit'] as $value) :?>
                    <p><label><input type="checkbox" name="product[]" value="<?=$value['id']?>" /><?=$value['name']?></label></p>
                <?endforeach?>
            </fieldset>
            <input type="submit" value="新增" />
        </form>
    </body>
</html>
