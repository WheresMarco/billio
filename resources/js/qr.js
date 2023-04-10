import QrScanner from "qr-scanner";

const video = document.getElementById("qr-video");
const camQrResult = document.getElementById("cam-qr-result");
const searchField = document.getElementById("search-field");
let scannerOpen = false;

// Hide the header and the footer
document.getElementById("header").style.display = "none";
document.getElementById("footer").style.display = "none";

const scanner = new QrScanner(
    video,
    (result) => setResult(camQrResult, result),
    {
        onDecodeError: (error) => {

        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    }
);

function setResult(label, result) {
    // Update the search field with the result
    searchField.value = result.data;
    searchField.dispatchEvent(new Event('input'));
}

// Listen for the scan button to be clicked
document.getElementById("toggle-qr").addEventListener("click", togglScanner);

function togglScanner() {
    if (scannerOpen) {
        scanner.stop();
        scannerOpen = false;
    } else {
        scanner.start();
        scannerOpen = true;
    }
}
