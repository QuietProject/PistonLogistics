document.getElementById("hamMenu").addEventListener("click", function myFunction() {
    let str = document.getElementById("sideMenu").style.getPropertyValue('right');
    if (str.slice(0, 2) < 0) {
        document.getElementById("sideMenu").style.right = "0";
    }
    else {
        document.getElementById("sideMenu").style.right = "-15vw";
    }
})

document.getElementById("BtnPaquetes").addEventListener("click", function myFunction() {
    document.getElementById("ContainerPaquetes").style.display = "flex";
    document.getElementById("ContainerLotes").style.display = "none";
    document.getElementById("ContainerCrearLote").style.display = "none";
    document.getElementById("ContainerQrScanner").style.display = "none";
})

document.getElementById("BtnLotes").addEventListener("click", function myFunction() {
    document.getElementById("ContainerPaquetes").style.display = "none";
    document.getElementById("ContainerLotes").style.display = "flex";
    document.getElementById("ContainerCrearLote").style.display = "none";
    document.getElementById("ContainerQrScanner").style.display = "none";
})

document.getElementById("BtnCrearLote").addEventListener("click", function myFunction() {
    document.getElementById("ContainerPaquetes").style.display = "none";
    document.getElementById("ContainerLotes").style.display = "none";
    document.getElementById("ContainerCrearLote").style.display = "flex";
    document.getElementById("ContainerQrScanner").style.display = "none";
})

document.getElementById("BtnQrScanner").addEventListener("click", function myFunction() {
    document.getElementById("ContainerPaquetes").style.display = "none";
    document.getElementById("ContainerLotes").style.display = "none";
    document.getElementById("ContainerCrearLote").style.display = "none";
    document.getElementById("ContainerQrScanner").style.display = "flex";
})