<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <form action="<?=$data['editshop_url']?>" method="post">
            <select name="shop_id">
                <?foreach($data['shop'] as $key => $value): ?>

                <option value="<?=$value['id']?>"><?=$value['name']?></option>
                
                <?endforeach?>
            </select>
            <input type="submit" value="修改" />
        </form>
    </body>
</html>
