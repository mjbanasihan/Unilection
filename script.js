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
