document.getElementById("btnUsers").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUsers").className = "button active";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
    document.getElementById("displayWelcome").style.display = "none";
    document.getElementById("displayUsers").style.display = "flex";
    document.getElementById("displayTrucks").style.display = "none";
    document.getElementById("displayRutes").style.display = "none";
    document.getElementById("displayWarehouses").style.display = "none";
    document.getElementById("displayProducts").style.display = "none";
    document.getElementById("displayClients").style.display = "none";
})

document.getElementById("btnTrucks").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUsers").className = "button inactive";
    document.getElementById("btnTrucks").className = "button active";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
    document.getElementById("displayWelcome").style.display = "none";
    document.getElementById("displayUsers").style.display = "none";
    document.getElementById("displayTrucks").style.display = "flex";
    document.getElementById("displayRutes").style.display = "none";
    document.getElementById("displayWarehouses").style.display = "none";
    document.getElementById("displayProducts").style.display = "none";
    document.getElementById("displayClients").style.display = "none";
})

document.getElementById("btnRutes").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUsers").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button active";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
    document.getElementById("displayWelcome").style.display = "none";
    document.getElementById("displayUsers").style.display = "none";
    document.getElementById("displayTrucks").style.display = "none";
    document.getElementById("displayRutes").style.display = "flex";
    document.getElementById("displayWarehouses").style.display = "none";
    document.getElementById("displayProducts").style.display = "none";
    document.getElementById("displayClients").style.display = "none";
})

document.getElementById("btnWarehouses").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUsers").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button active";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
    document.getElementById("displayWelcome").style.display = "none";
    document.getElementById("displayUsers").style.display = "none";
    document.getElementById("displayTrucks").style.display = "none";
    document.getElementById("displayRutes").style.display = "none";
    document.getElementById("displayWarehouses").style.display = "flex";
    document.getElementById("displayProducts").style.display = "none";
    document.getElementById("displayClients").style.display = "none";
})

document.getElementById("btnProducts").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUsers").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button active";
    document.getElementById("btnClients").className = "button inactive";
    document.getElementById("displayWelcome").style.display = "none";
    document.getElementById("displayUsers").style.display = "none";
    document.getElementById("displayTrucks").style.display = "none";
    document.getElementById("displayRutes").style.display = "none";
    document.getElementById("displayWarehouses").style.display = "none";
    document.getElementById("displayProducts").style.display = "flex";
    document.getElementById("displayClients").style.display = "none";
})

document.getElementById("btnClients").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUsers").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button active";
    document.getElementById("displayWelcome").style.display = "none";
    document.getElementById("displayUsers").style.display = "none";
    document.getElementById("displayTrucks").style.display = "none";
    document.getElementById("displayRutes").style.display = "none";
    document.getElementById("displayWarehouses").style.display = "none";
    document.getElementById("displayProducts").style.display = "none";
    document.getElementById("displayClients").style.display = "flex";
})

document.getElementById("addUser").addEventListener("click", function myFunction(){
    document.getElementById("addUserBackdrop").style.display = "flex";
})

document.getElementById("addUserBackdrop").addEventListener("click", function myFunction(){
    document.getElementById("addUserBackdrop").style.display = "none";
})