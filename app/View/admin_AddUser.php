<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <form action="<?=$data['addUser_url']?>" method="post">
            <p><label>帳號：<input type="text" name="account" /></label></p>
            <p><label>密碼：<input type="text" name="password" /></label></p>
            <p><label>姓名：<input type="text" name="UserName" /></label></p>
            <p>是否更改密碼：
                <label><input type="radio" name="changePassword" value="1">是</label>
                <label><input type="radio" name="changePassword" value="0" checked="checked">否</label>
            </p>
            <input type="submit" value="新增" />
        </form>
    </body>
</html>
