<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=$data['title']?></title>
    </head>
    <body>
        <h1><?=$data['title']?></h1>
        <form action="<?=$data['do_addusercsv_url']?>" method="post" enctype="multipart/form-data">
            <p><label>選擇檔案：<input type="file" name="file" /></label></p>
            <input type="submit" value="上傳" />
        </form>
    </body>
</html>
