console.log('ashdasd')
document.getElementById('customer').addEventListener('change', radio);
document.getElementById('own').addEventListener('change', radio);
let own=1;

$("#agregarAlmacenes").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "./includes/addDepot.php",
        dataType: "json",
        data: {
            nombre: document.getElementById("nombre").value,
            calle: document.getElementById("calle").value,
            numero: document.getElementById("numero").value,
            own: own,
            RUT: document.getElementById("customerList").value
        },
        success: function (e) {
            alert(e)
        }
    });

});

function radio(e) {
    let customers = document.getElementById('customers');
    console.log(e.target.value);
    if (e.target.value == 'customer') {
        customers.removeAttribute('hidden');
        own=0;
    } else{
        customers.setAttribute('hidden','');
        own=1;
    }
}