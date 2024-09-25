function openNav() {
    document.getElementById("sidebar").style.width = "250px"; // Open sidebar
    document.getElementById("main").style.marginLeft = "250px"; // Adjust main content
}

function closeNav() {
    document.getElementById("sidebar").style.width = "0"; // Close sidebar
    document.getElementById("main").style.marginLeft = "0"; // Reset main content margin
}