const body = document.getElementsByTagName('body');
const menu = document.getElementById('menu');
const menuDesplegable = document.getElementById('menuDesplegable');
const tl = gsap.timeline({defautls: {duration: 0.8}});
let i = 0;
let y = 0;

menuDesplegable.style.display = 'none';
menu.addEventListener('click', ()=>{
    menuDesplegable.style.display = '';
    if (i % 2 === 0) {
        tl.fromTo('.menuDesplegable', {opacity: 0, x:30}, {opacity: 1, x: 0, duration: 0.8});
        i++;
    }else{
        tl.fromTo('.menuDesplegable', {opacity: 1, x:0}, {opacity: 0, x: 30, duration: 0.8});
        i++;
    }
})