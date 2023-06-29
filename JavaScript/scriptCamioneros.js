const body = document.getElementsByTagName('body');
const menu = document.getElementById('menu');
const menuDesplegable = document.getElementById('menuDesplegable');
let i = 0;
let y = 0;

menuDesplegable.style.display = 'none';
menu.addEventListener('click', ()=>{
    menuDesplegable.style.display = '';
    if (i % 2 === 0) {
        gsap.fromTo('.menuDesplegable', {opacity: 0}, {opacity: 1, duration: 0.8});
        i++;
    }else{
        gsap.fromTo('.menuDesplegable', {opacity: 1}, {opacity: 0, duration: 0.8});
        i++;
    }
})