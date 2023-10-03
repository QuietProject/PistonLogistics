
const body = document.getElementsByTagName('body');
let i = 0;
let y = 0;

let isTransitionInProgress = false;

document.getElementById('menu').addEventListener('click', () => {
    const sidebar = document.getElementById('sidebar');
    const menu = document.getElementById('menu');

    if (isTransitionInProgress) {
        return;
    }

    sidebar.classList.toggle("opened");

    setTimeout(() => {
        menu.classList.toggle("bx-menu");
        menu.classList.toggle("fixed");
        menu.classList.toggle("bx-x");
    },100);
    

    isTransitionInProgress = true;

    sidebar.addEventListener('transitionend', () => {
        isTransitionInProgress = false;
    });
});

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
            
    let isExpanded = false;

    div.addEventListener('click', () => {
        let info = document.querySelector(`.${a}`);
    
        if (elementoAbierto !== null && elementoAbierto !== div) {
            elementoAbierto.style.transform = "translateX(0%)";
            let infoAbierto = elementoAbierto.querySelector(`div`);
            infoAbierto.style.transform = "translateY(0%)";
            infoAbierto.style.opacity = "0";
            infoAbierto.style.height = "0";
        }
    
        if (!isExpanded || elementoAbierto !== div) {
            div.style.transform = "translateX(125%)";
            info.style.transform = "translateY(70%)";
            info.style.height = "60vh";
            info.style.opacity = "1";
            elementoAbierto = div;
            document.getElementById("blank").classList.add("blank");
        } else {
            div.style.transform = "translateX(0%)";
            div.style.width = "40%";
            info.style.transform = "translateY(0%)";
            info.style.opacity = "0";
            info.style.height = "0";
            elementoAbierto = null;
            if (!document.querySelector('.div')) {
                document.getElementById("blank").classList.remove("blank");
            }
        }
        isExpanded = !isExpanded;
    });    
});





