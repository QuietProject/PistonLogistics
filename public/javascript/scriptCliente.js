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