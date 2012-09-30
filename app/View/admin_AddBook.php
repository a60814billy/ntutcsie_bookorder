<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <form action="<?=$data['addBook_url']?>" method="post">
            <p><label>書名：<input type="text" name="name" /></label></p>
            <p><label>課程：<input type="text" name="class" /></label></p>
            <p><label>原價：<input type="text" name="origin" /></label></p>
            <p><label>特價：<input type="text" name="sall" /></label></p>
            <input type="submit" value="新增" />
        </form>
    </body>
</html>
