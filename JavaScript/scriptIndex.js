const aboutUsLink = document.getElementById("aboutUsLink");
const aboutUs = document.getElementById("aboutUs");
const homeLink = document.getElementById("homeLink");
const home = document.getElementById("home");
const body = document.getElementsByTagName("body");
const menu = document.getElementById("menu");
const menuDesplegable = document.getElementById("menuDesplegable");
const tl = gsap.timeline({ defautls: { duration: 0.8 } });
let i = 0;
let y = 0;
let width;

gsap.registerPlugin(ScrollTrigger);
toggleAnimation();
window.addEventListener("resize", toggleAnimation);


//Boton aboutUs en el menu desplegable
aboutUsLink.addEventListener("click", (e) => {
  e.preventDefault();
  aboutUs.scrollIntoView({ behavior: "smooth" });

  if (i % 2 === 0) {
    tl.fromTo(
      ".menuDesplegable",
      { opacity: 0, x: 30 },
      { opacity: 1, x: 0, duration: 0.8 }
    );
    gsap.fromTo('.bx-menu', {color: "#000000"}, {color: "#ff9500"});
    i++;
  } else {
    tl.fromTo(
      ".menuDesplegable",
      { opacity: 1, x: 0 },
      { opacity: 0, x: 30, duration: 0.8 }
    );
    gsap.fromTo('.bx-menu', {color: "#ff9500"}, {color: "#000000"});
    i++;
  }
});

//Boton home en el menu desplegable
homeLink.addEventListener("click", (e) => {
  e.preventDefault();
  home.scrollIntoView({ behavior: "smooth" });

  if (i % 2 === 0) {
    tl.fromTo(
      ".menuDesplegable",
      { opacity: 0, x: 30 },
      { opacity: 1, x: 0, duration: 0.8 }
    );
    i++;
  } else {
    tl.fromTo(
      ".menuDesplegable",
      { opacity: 1, x: 0 },
      { opacity: 0, x: 30, duration: 0.8 }
    );
    i++;
  }
});

//Menu Desplegable
menuDesplegable.style.display = "none";
menu.addEventListener("click", () => {
  menuDesplegable.style.display = "";
  if (i % 2 === 0) {
    tl.fromTo(
      ".menuDesplegable",
      { opacity: 0, x: 30 },
      { opacity: 1, x: 0, duration: 0.8 }
    );
    gsap.fromTo('.bx-menu', {color: "#000000"}, {color: "#ff9500"});
    i++;
  } else {
    tl.fromTo(
      ".menuDesplegable",
      { opacity: 1, x: 0 },
      { opacity: 0, x: 30, duration: 0.8 }
    );
    gsap.fromTo('.bx-menu', {color: "#ff9500"}, {color: "#000000"});
    i++;
  }
});

function toggleAnimation() {
  if (window.innerWidth >= 300) {
    gsap.to(".logo", {
      scrollTrigger: {
        trigger: ".aboutUs",
        toggleActions: "play pause resume reverse",
        scrub: true,
      },
      x: 95,
      duration: 1,
    });
  } else {
    gsap.killTweensOf(".logo");
  }
}



if (window.innerWidth >= 1280) {
  tl.fromTo(
    ".menuRastreo",
    { opacity: 0, x: 300 },
    { opacity: 1, x: 0, duration: 0.8 }
  );
}
