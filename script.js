// JavaScript code for modal
var modal = document.getElementById('updateModal');
var span = document.getElementsByClassName('close')[0];

// Function to open modal with pre-filled values
function updateRow(id, admin_id, last_name, first_name, middle_initial, email, password) {
    console.log("Updating row with ID: ", id);  // Check if this logs when clicking the button
    document.getElementById('modal_id').value = id;
    document.getElementById('modal_admin_id').value = admin_id;
    document.getElementById('modal_last_name').value = last_name;
    document.getElementById('modal_first_name').value = first_name;
    document.getElementById('modal_middle_initial').value = middle_initial;
    document.getElementById('modal_email').value = email;
    document.getElementById('modal_password').value = password;

    modal.style.display = 'block';
}

// Close the modal when user clicks the "x"
span.onclick = function() {
    modal.style.display = 'none';
}

// Close the modal when user clicks outside of the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}


function showSidebar(){
    const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'flex'
}
function hideSidebar(){
    const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'none'
}

const adminIcon = document.querySelector('.admin-icon');
const dropdownMenu = document.querySelector('.dropdown-menu');

adminIcon.addEventListener('click', () => {
    dropdownMenu.classList.toggle('show');
});

// Close the dropdown if clicked outside
document.addEventListener('click', (event) => {
    if (!adminIcon.contains(event.target)) {
        dropdownMenu.classList.remove('show');
    }
});
