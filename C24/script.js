document.addEventListener('DOMContentLoaded' , function(){
let sortPositive = arr => {
	// put your code here
    //extract the positive numbers from the array and sort them in ascending order
    let positiveNumbers = arr.filter(x => x >0).sort( (a,b) => a - b);

    let counter = 0;
    arr = arr.map((x, i) =>{
       let no = x;
        if(no > 0){
            no = positiveNumbers[counter];counter++;
       }
        return  no;
    });
    console.log(arr);
}

/*TESTS FOR AVALIATIONS*/

sortPositive([-2, 150, 190, 170, -3, -4, 160, 180]);
sortPositive([-1, -1, -1, -1, -1]);
sortPositive([-1]);
sortPositive([4, 2, 9, 11, 2, 16]);
sortPositive([2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1]);
sortPositive([23, 54, -1, 43, 1, -1, -1, 77, -1, -1, -1, 3]);

});

