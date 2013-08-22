<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <form action="<?=$data['editUser_url']?>" method="post">
            <input type="hidden" value="<?=$_GET['id']?>" name="id" />
            <p><label>帳號：<input type="text" name="account" value="<?=$data['user']['account']?>" /></label></p>
            <p><label>設定新密碼：<input type="text" name="password" /></label></p>
            <p><label>姓名：<input type="text" name="UserName" value="<?=$data['user']['username']?>" /></label></p>
            <p><label>生日：<input type="text" name="birth" value="<?=$data['user']['birth']?>" /></label></p>
            <p>是否更改密碼：
                <label><input type="radio" name="changePassword" value="1" <?if($data['user']['changepass']==1)echo "checked=\"checked\""?> />是</label>
                <label><input type="radio" name="changePassword" value="0" <?if($data['user']['changepass']==0)echo "checked=\"checked\""?> />否</label>
            </p>
            <input type="submit" value="更改" />
        </form>
    </body>
</html>
