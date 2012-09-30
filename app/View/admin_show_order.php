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

        <? foreach($data['shop'] as $value):?>
            <div><?=$value['book']['name']?> - - <?=$value['num'][0]?></div>
        <? endforeach ?>

        <? foreach($data['order_list'] as $value):?>
            <div class="orders" style="margin:2px 2px; border: 1px solid #808080;width: 150px;float: left;">
                <p><?=$value['id']?> - <?$value['account']?> - <?=$value['username']?></p>
                <p><?=$value['book_quantity']?>本 - <?=$value['sall_count']?>元</p>
                <? foreach($value['detail'] as $book) :?>
                    <p><?=$book['name']?> - <?=$book['sall_price']?></p>
                <? endforeach?>
            </div>
        <? endforeach ?>
    </body>
</html>
