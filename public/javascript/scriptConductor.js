// Add buttons Show add screen

document.getElementById("addTruck").addEventListener("click", function myFunction() {
    document.getElementById("addBackdrop").style.display = "flex";
    document.getElementById("addTruckInterface").style.display = "flex";
})

// Add buttons Show add screen

document.getElementById("closeButtonTrucks").addEventListener("click", function myFunction() {
    document.getElementById("addBackdrop").style.display = "none";
    document.getElementById("addTruckInterface").style.display = "none";
})

document.getElementById("closeButtonCornerTrucks").addEventListener("click", function myFunction() {
    document.getElementById("addBackdrop").style.display = "none";
    document.getElementById("addTruckInterface").style.display = "none";
})


function sortTable(n) {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("tableDriver");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function searchFilter() {
    var input, filter, table, tr, td, i, o, show, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableDriver");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        var rowLenght = tr[i].getElementsByTagName("td");
        var show = 0;
        for (o = 0; o < rowLenght.length; o++) {
            td = tr[i].getElementsByTagName("td")[o];
            console.log(o);
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    show++;
                }
            }
        }

        if (show == 0) {
            tr[i].style.display = "none";
        } else {
            tr[i].style.display = "";
        }
    }

}