const color = "black";
const all = document.getElementById("all");
const animacionInicio = document.getElementById("animacionInicio");
const divInicio = document.getElementById("divInicio");
const footer = document.getElementById("footer");

const maxPageScroll = document.body.scrollHeight - document.documentElement.clientHeight;

document.addEventListener("scroll", (event) => {
  const scrollPos = window.scrollY * 15 / maxPageScroll
  document.getElementById("logo").style.transform = `translateX(${scrollPos}vw)`
});


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
const textoPreguntas = document.querySelector(".textoPreguntas");
const sobreNosotros = document.querySelector(".sobreNosotros");
const preguntas = document.querySelector(".preguntas");
const animateElements1 = textoAbout.querySelectorAll(".animar");
const animateElements2 = textoPreguntas.querySelectorAll(".animar");

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

      observer.disconnect();
    }
  });
});

observer.observe(textoAbout);


document.getElementById("homeLink").addEventListener("click", function (event) {
  event.preventDefault();
  const offset = 100;
  const target = document.querySelector("#home");
  const targetPosition = target.getBoundingClientRect().top + window.scrollY - offset;
  window.scrollTo({
    top: targetPosition,
    behavior: "smooth"
  });
});

document.getElementById("aboutUsLink").addEventListener("click", function (event) {
  event.preventDefault();
  const offset = 100;
  const target = document.querySelector("#aboutUs");
  const targetPosition = target.getBoundingClientRect().top + window.scrollY - offset;
  window.scrollTo({
    top: targetPosition,
    behavior: "smooth"
  });
});

document.getElementById("preguntasLink").addEventListener("click", function (event) {
  event.preventDefault();
  const offset = 100;
  const target = document.querySelector("#preguntas");
  const targetPosition = target.getBoundingClientRect().top + window.scrollY - offset;
  window.scrollTo({
    top: targetPosition,
    behavior: "smooth"
  });
});