document.getElementById("btnUser").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUser").className = "button active";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
})

document.getElementById("btnTrucks").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUser").className = "button inactive";
    document.getElementById("btnTrucks").className = "button active";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
})

document.getElementById("btnRutes").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUser").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button active";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
})

document.getElementById("btnWarehouses").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUser").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button active";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button inactive";
})

document.getElementById("btnProducts").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUser").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button active";
    document.getElementById("btnClients").className = "button inactive";
})

document.getElementById("btnClients").addEventListener("click", function myFunction(){
    document.getElementById("brandIcon").className = "brandIconNav inactive";
    document.getElementById("btnUser").className = "button inactive";
    document.getElementById("btnTrucks").className = "button inactive";
    document.getElementById("btnRutes").className = "button inactive";
    document.getElementById("btnWarehouses").className = "button inactive";
    document.getElementById("btnProducts").className = "button inactive";
    document.getElementById("btnClients").className = "button active";
})