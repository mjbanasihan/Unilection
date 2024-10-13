function openModal() {
    document.getElementById("createBallotModal").style.display = "block";
}

// Close modal
function closeModal() {
    document.getElementById("createBallotModal").style.display = "none";
}

// Add group of position and candidates
function addGroup() {
    const groupsContainer = document.getElementById("groupsContainer");

    const groupDiv = document.createElement('div');
    groupDiv.className = 'group';

    // Create Position Input
    const positionLabel = document.createElement('label');
    positionLabel.innerHTML = 'Position:';
    const positionInput = document.createElement('input');
    positionInput.type = 'text';
    positionInput.placeholder = 'Enter position name';

    // Create Candidate Input
    const candidateLabel = document.createElement('label');
    candidateLabel.innerHTML = 'Candidates (comma separated):';
    const candidateInput = document.createElement('input');
    candidateInput.type = 'text';
    candidateInput.placeholder = 'Enter candidates';

    // Append elements to the group div
    groupDiv.appendChild(positionLabel);
    groupDiv.appendChild(positionInput);
    groupDiv.appendChild(candidateLabel);
    groupDiv.appendChild(candidateInput);

    // Append group to the container
    groupsContainer.appendChild(groupDiv);
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById("createBallotModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}