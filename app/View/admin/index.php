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
    </body>
</html>
