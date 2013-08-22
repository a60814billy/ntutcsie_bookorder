<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <ul>
        <? foreach($data['menu'] as $key => $value ): ?>
            <li><a href="<?=$value?>"><?=$key?></a></li>
        <? endforeach ?>
        </ul>
        <form action="<?=$data['form_url']?>" method="post">
            <P><label><span>Shop</span>
                <select name="shop">
                <?foreach($data['shop'] as $value):?>
                    <option value="<?=$value['id']?>"><?=$value['name']?></option>
                <?endforeach?>        
                </select>
            </label></P>
            <input type="submit" value="送出" />
        </form>
    </body>
</html>
