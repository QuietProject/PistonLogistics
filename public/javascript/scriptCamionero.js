const body = document.getElementsByTagName('body');
const menu = document.getElementById('menu');
const menuDesplegable = document.getElementById('menuDesplegable');
const tl = gsap.timeline({ defautls: { duration: 0.8 } });
let i = 0;
let y = 0;

menuDesplegable.style.display = 'none';
menu.addEventListener('click', () => {
    menuDesplegable.style.display = '';
    if (i % 2 === 0) {
        tl.fromTo('.menuDesplegable', { opacity: 0, x: 30 }, { opacity: 1, x: 0, display: '', duration: 0.8 });
        gsap.fromTo('.bx-menu', { color: "#000000" }, { color: "#ff9500" });
        i++;
    } else {
        tl.fromTo('.menuDesplegable', { opacity: 1, x: 0, display: '' }, { opacity: 0, x: 30, display: 'none', duration: 0.8 });
        gsap.fromTo('.bx-menu', { color: "#ff9500" }, { color: "#000000" });
        i++;
    }
})


const section = document.getElementById('section');
const divs = section.querySelectorAll('div');

divs.forEach((div, index) => {
    const newDiv = document.createElement('div');
    newDiv.className = `div${index + 1}`;
    const info = document.createElement('div');
    info.textContent = 'Informacion Pedido ' + (index + 1);
    newDiv.appendChild(info);
    div.appendChild(newDiv);

    let i = 0;
    let a = `div${index + 1}`;

    div.addEventListener('click', () => {
        if (i % 2 === 0) {
            gsap.fromTo(`.${a}`, { opacity: 0, xPercent: 0 }, { opacity: 1, xPercent: 100, duration: 0.8 });
            i++;
        } else {
            gsap.fromTo(`.${a}`, { opacity: 1, xPercent: 100 }, { opacity: 0, xPercent: 0, duration: 0.8 });
            i++;
        }
    })
});

