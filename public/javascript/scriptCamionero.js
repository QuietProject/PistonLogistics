const color = "black";
const body = document.getElementsByTagName('body');
let i = 0;
let y = 0;

let radios = document.forms["estado"].elements["estado"];
let labels = document.querySelectorAll(".radioBtnEstados label");

for (let i = 0, max = radios.length; i < max; i++) {
    radios[i].addEventListener("change", function() {
        labels.forEach((label, index) => {
            if (radios[index].checked) {
                label.classList.add("checked");
                label.classList.remove("notChecked");
            } else {
                label.classList.remove("checked");
                label.classList.add("notChecked");
            }
        });
        
        enviarInformacion();
        
    });
}

function enviarInformacion() {
    alert("Información enviada.");
}


const section = document.getElementById('section');
const divs = section.querySelectorAll('div');

let elementoAbierto = null;

divs.forEach((div, index) => {
    const newDiv = document.createElement('div');
    newDiv.className = `div${index + 1}`;
    const info = document.createElement('div');
    info.textContent = 'Informacion Pedido ' + (index + 1);
    newDiv.appendChild(info);
    div.appendChild(newDiv);

    let a = `div${index + 1}`;

    div.addEventListener('click', () => {
        let info = document.querySelector(`.${a}`);
    
        if (elementoAbierto !== null && elementoAbierto !== div) {
            let infoAbierto = elementoAbierto.querySelector(`div`);
            elementoAbierto.style.transform = "translateX(0%)";
            infoAbierto.style.transform = "translateY(0%)";
            infoAbierto.style.opacity = "0";
            infoAbierto.style.height = "0";
        }
    
        if (elementoAbierto !== div) {
            div.style.transform = "translateX(115%)";
            info.style.transform = "translateY(68.5%)";
            info.style.height = "300%";
            info.style.opacity = "1";
            elementoAbierto = div;
            document.getElementById("blank").style.height = "0";
            if (divs.length - index == 3) {
                document.getElementById("blank").style.height = "20vh";
            }else if (divs.length - index == 2) {
                document.getElementById("blank").style.height = "40vh";
            }else if (divs.length - index == 1) {
                document.getElementById("blank").style.height = "65vh";
            }
        } else {
            div.style.transform = "translateX(0%)";
            info.style.transform = "translateY(0%)";
            info.style.opacity = "0";
            info.style.height = "0";
            elementoAbierto = null;
            if (!document.querySelector('.div')) {
                document.getElementById("blank").style.height = "0";
            }
        }
    });  
    
    info.addEventListener("click", (e) => {
        e.stopPropagation();
    });
});








