document.getElementById("hamMenu").addEventListener("click", function myFunction() {
    let str = document.getElementById("sideMenu").style.getPropertyValue('right');
    if (str.slice(0, 2) < 0) {
        document.getElementById("sideMenu").style.right = "0";
        document.getElementById("menu").style.color = "orange";
    }
    else {
        document.getElementById("sideMenu").style.right = "-15vw";
        document.getElementById("menu").style.color = "var(--baseLighter)";
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