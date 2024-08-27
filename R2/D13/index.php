<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php

	function removeDuplicates($arr){
		//put your code here
        echo "original array";
        echo "<br>";
        foreach($arr as $i){
            echo $i . ',';
        }
        echo "<br>";

        echo "new array";
        echo "<br>";
        $new = [];
        foreach($arr as $i){
            if(!in_array($i , $new)){
                $new[] = $i;
            }
        }

        foreach($new as $i){
            echo $i . ',';
        }
        echo "<br><br>";
	}

	removeDuplicates(['a', 'a', 'b', 'c', 'd']);
	removeDuplicates(['another', 'array', 'array', 'with', 'strings']);
	removeDuplicates(['b']);
	removeDuplicates(['a', 'b']);
	removeDuplicates(['a', 'aa', 'b']);
	removeDuplicates(['a', 'z', 'z']);
	?>

</body>
</html>