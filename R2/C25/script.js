
const div = document.querySelector('#square');
let startX;
let startY;
function start(e){
    console.log(e.clientX);
    console.log(e.clientY);
    startX = e.clientX;
    startY = e.clientY;
}
function follow(e){
   let  dx = e.clientX;
   let  dy = e.clientY ;
    div.style.left = `${dx - 50}px`;
    div.style.top = `${dy - 50}px`;
}


document.addEventListener('mouseenter', start);
document.addEventListener('mousemove', follow);
// document.addEventListener('mouseleave', stop);
