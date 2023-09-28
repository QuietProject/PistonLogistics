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




const section = document.getElementById('section');
const divs = section.querySelectorAll('div');

divs.forEach((div, index) => {
    const newDiv = document.createElement('div');
    newDiv.className = `div${index + 1}`;
    const info = document.createElement('div');
    info.textContent = 'Informacion Pedido ' + (index + 1);
    newDiv.appendChild(info);
    div.appendChild(newDiv);

    let i = 0;
    let a = `div${index + 1}`;

    div.addEventListener('click', () => {
        if (i % 2 === 0) {
            document.querySelector(`.${a}`).style.transform = "translateY(100%)";
            i++;
        } else {
            document.querySelector(`.${a}`).style.transform = "translateY(0%)";
            i++;
        }
    })
});

