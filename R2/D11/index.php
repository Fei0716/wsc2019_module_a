<?php
    session_start();
    $data = json_decode(file_get_contents("./data.json"), false);
    if(isset($_SESSION['currentPage'])){
        if(isset($_GET["pageNo"])){
            $_SESSION['currentPage'] = $_GET["pageNo"];
        }
    }else{
        $_SESSION['currentPage'] = 0;
    }
    $_SESSION['partitionPage'] = isset($_SESSION["partitionPage"])? $_SESSION["partitionPage"] : 5;
    if($_GET["left"]){
        if($_SESSION["partitionPage"] > 5){
            $_SESSION["partitionPage"] = max($_SESSION["partitionPage"] - 5 ,0) ;
            $_SESSION["currentPage"] = max($_SESSION["currentPage"] - 5 ,0) ;
        }else{
            $_SESSION["partitionPage"] = max($_SESSION["partitionPage"] - 5 ,5) ;
            $_SESSION["currentPage"] = max($_SESSION["currentPage"] - 5 ,0) ;
        }
    }else if (isset($_GET['right'])){
        if($_SESSION['partitionPage'] < ceil(count($data) / 5)) {
            $_SESSION['partitionPage'] += 5;
            $_SESSION['currentPage'] = min(ceil(count($data)/ 5) - 1, $_SESSION['currentPage'] + 5);

        }else{
            $_SESSION['partitionPage'] = ceil(count($data) / 5);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="./bootstrap-4.3.1-dist/css/bootstrap.min.css">

    <style>
        .pagination{
            display: flex;
            gap: 1rem;
        }

        .page-link{
            border-radius: 100% !important;
        }
        .page-active{
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<main>
    <h1>Page Content</h1>


    <table>
        <tr>
            <th>Id</th>
            <th>Age</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Company</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
        <?php
            $counter = $_SESSION["currentPage"] *  5;
            for($i= $counter, $iMax = ($counter + 5); $i < $iMax; $i++ ):
        ?>
            <tr>
                <td><?=$data[$i]->id?></td>
                <td><?=$data[$i]->age?></td>
                <td><?=$data[$i]->name?></td>
                <td><?=$data[$i]->gender?></td>
                <td><?=$data[$i]->company?></td>
                <td><?=$data[$i]->email?></td>
                <td><?=$data[$i]->phone?></td>
                <td><?=$data[$i]->address?></td>
            </tr>
        <?php
            endfor;
        ?>
    </table>
</main>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="?left=1">&lt;</a></li>
        <?php
            $counter = $_SESSION["partitionPage"] - 4;
            for($i= $counter; $i <= $_SESSION["partitionPage"]; $i++):
        ?>
                <li class="page-item"><a class="page-link <?= $_SESSION['currentPage'] == ($i - 1)? 'page-active' : '' ?>" href="?pageNo=<?=$i- 1?>"><?= $i ?></a></li>

        <?php
            endfor;
        ?>
        <li class="page-item"><a class="page-link"href="?right=1">&gt;</a></li>
    </ul>
</nav>

</body>
</html>