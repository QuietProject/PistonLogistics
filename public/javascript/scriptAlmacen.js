
const menu = document.getElementById('menu');
const menuDesplegable = document.getElementById('menuDesplegable');

let i = 0;

menuDesplegable.style.display = 'none';
menu.addEventListener('click', () => {
    menuDesplegable.style.display = '';
    if (i % 2 === 0) {
        gsap.fromTo('.menuDesplegable', { opacity: 0, x: 70 }, { opacity: 1, x: 0, display: '', duration: 0.8 });
        gsap.fromTo('.bx-menu', { color: "#ffffff" }, { color: "#ff9500" });
        i++;
    } else {
        gsap.fromTo('.menuDesplegable', { opacity: 1, x: 0, display: '' }, { opacity: 0, x: 70, display: 'none', duration: 0.8 });
        gsap.fromTo('.bx-menu', { color: "#ff9500" }, { color: "#ffffff" });
        i++;
    }
})

const mainScreen = document.getElementById('mainScreen');
const btnDescarga = document.getElementById('descarga');
const btnCarga = document.getElementById('carga');
const containerDescarga = document.getElementById('containerDescarga');
const containerCarga = document.getElementById('containerCarga');

let d = 0;
let c = 0;

btnDescarga.addEventListener('click', () => {

    if (d % 2 === 0) {
        containerDescarga.style.display = 'flex';
        gsap.fromTo('.containerDescarga', { opacity: 0 }, { opacity: 1, duration: 0.8 });
        gsap.fromTo('.mainScreen', { opacity: 1 }, { opacity: 0, duration: 0.8 });
        mainScreen.style.display = 'none';
        d++;
    }
});

btnCarga.addEventListener('click', () => {

    if (c % 2 === 0) {
        containerCarga.style.display = 'flex';
        gsap.fromTo('.containerCarga', { opacity: 0 }, { opacity: 1, duration: 0.8 });
        gsap.fromTo('.mainScreen', { opacity: 1 }, { opacity: 0, duration: 0.8 });
        mainScreen.style.display = 'none';
        c++;
    }
});

const btnBackDescarga = document.getElementById('btnBackDescarga');
const btnBackCarga = document.getElementById('btnBackCarga');

btnBackDescarga.addEventListener('click', () => {
    containerDescarga.style.display = 'none';
    d++;
    mainScreen.style.display = 'flex';
    gsap.fromTo('.mainScreen', { opacity: 0 }, { opacity: 1, duration: 0.8 });
});

btnBackCarga.addEventListener('click', () => {
    containerCarga.style.display = 'none';
    c++;
    mainScreen.style.display = 'flex';
    gsap.fromTo('.mainScreen', { opacity: 0 }, { opacity: 1, duration: 0.8 });
});