document.getElementById("hamMenu").addEventListener("click", function myFunction() {
    let str = document.getElementById("sideMenu").style.getPropertyValue('right');
    if (str.slice(0, 2) < 0) {
        document.getElementById("sideMenu").style.right = "0";
    }
    else {
        document.getElementById("sideMenu").style.right = "-15vw";
    }
})

let scannedContent = localStorage.getItem('scannedContent');

// Reference to the "Ticket Info" div and input
let ticketInfoDiv = document.getElementById('ticketInfo');
let ticketInfoInput = document.getElementById('ticketInfoInput');

// Display the scanned content in the "Ticket Info" div
if (scannedContent) {
    console.log('Scanned content: ' + scannedContent)
    ticketInfoDiv.innerHTML = '<span>' + scannedContent + '</span>';
    ticketInfoInput.value = scannedContent;
} else {
    console.log('No scanned content available')
    ticketInfoDiv.innerHTML = '<span>No scanned content available</span>';
}

document.getElementById("confirmButton").addEventListener("click", function myFunction() {

    localStorage.clear();
})