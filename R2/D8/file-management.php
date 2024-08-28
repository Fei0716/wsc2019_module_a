<?php

$basePath = __DIR__;

$files = scandir($basePath);//get all the files under the directory path

//check for submitting edit content
if($_GET["edit-content"]){
    //update the file
    //check the existance of the file
    $fullPath = $basePath. '/'. $_GET["edit"];
    file_put_contents($fullPath, $_GET["edit-content"]);

    //reset the query parameter
    header("Location: ".strtok($_SERVER["REQUEST_URI"], '?'));
}


if($_GET["delete"]){
    //check the existance of the file
    $fullPath = $basePath. '/'. $_GET["delete"];
    if(is_file($fullPath) && file_exists($fullPath)){
        //delete the file
        unlink($fullPath);
    }else if(is_dir($fullPath)){
        //delete the folder
        //delete all the files and folders underneath the path
        $objects = scandir($fullPath);
        foreach($objects as $o){
            echo $fullPath."/".$o ."<br>";
            if(is_dir($fullPath."/".$o)){
                rmdir($fullPath."/".$o);
            }else if(is_file($fullPath."/".$o)){
                unlink($fullPath."/".$o);
            }
        }
        rmdir($fullPath);
    }
    //reset the query parameter
    header("Location: ".strtok($_SERVER["REQUEST_URI"], '?'));
}

$editContent = '';

if($_GET["edit"]){
    //check the existance of the file
    $fullPath = $basePath. '/'. $_GET["edit"];
    if(is_file($fullPath)){
        $editContent = file_get_contents($fullPath);
    }
}




?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File Management System</title>

    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        td,th{
            padding: 0.25rem;
        }
        label{
            display: block;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>File</th>
            <th>Size</th>
            <th></th>
            <th></th>
        </tr>

        <?php
            foreach($files as $f):
                if($f !== '.' && $f !== '..'):
        ?>
        <tr>
            <td><?= $f ?></td>
            <td><?= filesize($f) ?></td>
            <td>
                <a href="?edit=<?=$f?>">Edit</a>
            </td>
            <td>
                <a href="?delete=<?=$f?>">Delete</a>
            </td>
        </tr>

        <?php
            endif;endforeach;
        ?>
    </table>

    <?php if($editContent): ?>
        <form action="#">
            <input type="text" name="edit" value="<?=$_GET['edit']?>" hidden>

            <div>
                <label for="edit-content">Edit Content</label>
                <textarea name="edit-content" id="edit-content" cols="100" rows="30"><?= htmlspecialchars($editContent) ?></textarea>
            </div>
            <div>
                <button type="submit">Update</button>
            </div>
        </form>
    <?php endif; ?>
</body>
</html>
