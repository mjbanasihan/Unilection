var modal = document.getElementById("ballotModal");

// Get the button that opens the modal
var btn = document.querySelector(".btn-create-ballot");

// When the user clicks the button, open the modal 
btn.onclick = function() {
    console.log("Plus button clicked!"); // Log statement
    modal.style.display = "block"; // Show the modal
    // Uncomment the following line if you have a function to populate the dropdown
    // populatePositions(); 
}

// When the user clicks on <span> (x), close the modal
function closeModal() {
    modal.style.display = "none"; // Hide the modal
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none"; // Hide the modal
    }
}

// Placeholder for populatePositions and submitBallot functions
function submitBallot() {
    var title = document.getElementById("ballotTitle").value;
    if (title) {
        alert("Ballot Title: " + title);
        closeModal();
    } else {
        alert("Please enter a ballot title.");
    }
}

function addPosition() {
    const positionName = document.getElementById('positionInput').value;

    // Validate the input
    if (!positionName) {
        alert('Please enter a position name.');
        return;
    }

    // Create a new FormData object to send the data
    const formData = new FormData();
    formData.append('position', positionName);

    // Make the AJAX request to position.php
    fetch('position.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Position added successfully!');

            // Clear input field
            document.getElementById('positionInput').value = '';

            // Now fetch the updated positions
            fetchPositions();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}

// Function to fetch positions from the database
function fetchPositions() {
    fetch('position.php?action=get_positions') // You'll need to adjust position.php to handle this request
        .then(response => response.json())
        .then(data => {
            const positionDropdown = document.getElementById('positionDropdown');
            positionDropdown.innerHTML = ''; // Clear previous options

            data.positions.forEach(position => {
                const option = document.createElement('option');
                option.value = position.ID; // Assuming ID is the identifier for the position
                option.textContent = position.position; // Assuming position is the name
                positionDropdown.appendChild(option);
            });

            // Show the dropdown and candidate section
            document.getElementById('positionDropdownContainer').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching positions:', error);
        });
}

// Function to show the candidate input section
function showCandidateSection() {
    document.getElementById('addCandidateSection').style.display = 'block';
}

// Function to add a candidate
function addCandidate() {
    const candidateName = document.getElementById('candidateName').value;
    const partyList = document.getElementById('partyList').value;
    const positionId = document.getElementById('positionDropdown').value;

    // Validate input
    if (!candidateName || !partyList || !positionId) {
        alert('Please fill in all fields.');
        return;
    }

    const formData = new FormData();
    formData.append('candidateName', candidateName);
    formData.append('partyList', partyList);
    formData.append('positionId', positionId);

    // Make the AJAX request to candidate.php (or whatever your file is called)
    fetch('candidate.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Candidate added successfully!');
            // Clear input fields
            document.getElementById('candidateName').value = '';
            document.getElementById('partyList').value = '';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}