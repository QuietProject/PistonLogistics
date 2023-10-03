const maxPageScroll = document.body.scrollHeight - document.documentElement.clientHeight

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