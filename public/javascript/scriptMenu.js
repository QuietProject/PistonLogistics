let isTransitionInProgress = false;
const menu = document.getElementById("menuIcon");

menu.addEventListener("click", () =>{
    const sideMenu = document.getElementById("sideMenu");
    const computedStyles = window.getComputedStyle(sideMenu);
    const rightValue = computedStyles.getPropertyValue("right");

    if (isTransitionInProgress) {
        return;
    }

    if (rightValue === "-400px") {
        sideMenu.style.right = "0";
        menu.style.color = "var(--highlight)";
    }else{
        sideMenu.style.right = "-400px";
        menu.style.color = `${color}`;
    }
    
    isTransitionInProgress = true;

    document.getElementById("sideMenu").addEventListener('transitionend', () => {
        isTransitionInProgress = false;    
    });
})
