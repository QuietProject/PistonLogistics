const preview = document.createElement("video");
preview.classList.add("preview");
preview.setAttribute("id", "preview");
const qrContainer = document.getElementById("qrContainer");
const qrSvg = document.getElementById("qrSvg");
let ticketInfo = document.getElementById('ticketInfo');

document.getElementById("hamMenu").addEventListener("click", function () {
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

qrContainer.addEventListener("click", function () {
    qrContainer.appendChild(preview);
    qrContainer.removeChild(qrSvg);

    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview'),
        mirror: false
    });
    Instascan.Camera.getCameras().then(function (cameras) {
        scanner.start(cameras[0]);
    }).catch(function (error) {
        console.error(error);
    });
    scanner.addListener('scan', async function (content) {
        console.log('Scanned content: ' + content);
        // //let paquetes = await fetch("http://localhost:8080/paquetes", {"mode": "cors", "headers": "Access-Control-Allow-Origin: *"})
        // // 
        
        
        $.ajax({
            type: "get",
            url: "http://localhost:8080/paquetes",
            data:  content,
            dataType: "dataType",
            success: function (response) {
                
            }
        });

        // console.log(paquetes);
        ticketInfo.value = content;
    })

})
