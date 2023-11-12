const color = "white";
const preview = document.createElement("video");
preview.setAttribute("id", "preview");
const qrContainer = document.getElementById("qrContainer");
const qr = document.getElementById("qr");
const qrSvg = document.getElementById("qrSvg");
const confirmButton = document.getElementById("confirmButton");
let ticketInfo = document.getElementById("ticketInfo");

qr.addEventListener("click", function () {
    qr.appendChild(preview);
    qr.removeChild(qrSvg);

    let scanner = new Instascan.Scanner({
        video: document.getElementById("preview"),
        mirror: false,
    });
    Instascan.Camera.getCameras()
        .then(function (cameras) {
            scanner.start(cameras[0]);
        })
        .catch(function (error) {
            console.error(error);
        });
    scanner.addListener("scan", function (content) {
        console.log("Scanned content: " + content);
        // //let paquetes = await fetch("http://localhost:8080/paquetes", {"mode": "cors", "headers": "Access-Control-Allow-Origin: *"})
        // //

        // console.log(paquetes);
        ticketInfo.value = content;
    });
});

const btnChange = document.getElementById("btnChange");
const btnChangeQR = document.getElementById("btnChangeQR");
const codigoContainer = document.querySelector(".codigoContainer");

btnChange.addEventListener("click", () => {
    btnChangeQR.style.display = "";
    btnChange.style.display = "none";
    codigoContainer.style.display = "";
    qr.style.display = "none";
});

btnChangeQR.addEventListener("click", () => {
    btnChange.style.display = "";
    btnChangeQR.style.display = "none";
    codigoContainer.style.display = "none";
    qr.style.display = "";
});


