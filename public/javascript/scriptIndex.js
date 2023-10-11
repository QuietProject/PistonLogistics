const maxPageScroll = document.body.scrollHeight - document.documentElement.clientHeight;

document.addEventListener("scroll", (event) => {
  const scrollPos = window.scrollY * 15 / maxPageScroll
  // if(window.screen.width > 1000){
  document.getElementById("logo").style.transform = `translateX(${scrollPos}vw)`
  // }
});

document.getElementById("menu").addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle("opened");
})
document.getElementById("closeMenu").addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle("opened");
})

const all = document.getElementById("all");
const animacionInicio = document.getElementById("animacionInicio");
const divInicio = document.getElementById("divInicio");
const footer = document.getElementById("footer");

all.style.display = "none";
setTimeout(() => {
  all.style.display = "";
  setTimeout(() => {
    all.style.opacity = "1";
    footer.style.opacity = "1";
    animacionInicio.style.opacity = "0";
    setTimeout(() => {
      animacionInicio.style.display = "none";
    }, 1);
  }, 100);
}, 3000);

const textoAbout = document.querySelector(".textoAbout");
const textoPreguntas1 = document.querySelector(".textoPreguntas1");
const textoPreguntas2 = document.querySelector(".textoPreguntas2");
const sobreNosotros = document.querySelector(".sobreNosotros");
const preguntas = document.querySelector(".preguntas");
const animateElements1 = textoAbout.querySelectorAll(".animar");
const animateElements2 = textoPreguntas1.querySelectorAll(".animar");
const animateElements3 = textoPreguntas2.querySelectorAll(".animar");

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            sobreNosotros.style.animation = `fade 1s ease 0.2s forwards`;
            preguntas.style.animation = `fade 1s ease 0.8s forwards`;
            animateElements1.forEach((element, index) => {
                element.style.animation = `fade 1s ease ${index * 0.2 + 0.4}s forwards`;
            });
            animateElements2.forEach((element, index) => {
              element.style.animation = `fade 1s ease ${index * 0.2 + 0.8}s forwards`;
            });
            animateElements3.forEach((element, index) => {
              element.style.animation = `fade 1s ease ${index * 0.2 + 0.8}s forwards`;
          });
            observer.disconnect();
        }
    });
});

observer.observe(textoAbout);
