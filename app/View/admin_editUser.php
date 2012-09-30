<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <ul>
        <? foreach($data['users'] as $value) :?>
            <li><a href="<?=conver_url('./?controller=admin&action=edituser2&id='.$value['id'])?>"><?=$value['username']?></a></li>
        <? endforeach ?>
        </ul>
    </body>
</html>
