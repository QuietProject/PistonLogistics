document.getElementById("hamMenu").addEventListener("click", function myFunction() {
    let str = document.getElementById("sideMenu").style.getPropertyValue('right');
    if (str.slice(0, -2) < 0) {
        document.getElementById("sideMenu").style.right = "0";
    }
    else {
        document.getElementById("sideMenu").style.right = "-15vw";
    }
})