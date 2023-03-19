"use strict";

function domRemoveParticipant(event) {
    let row = event.target.parentNode;
    if (confirm("Want to delete the selected row?")) {
        let participants = JSON.parse(localStorage.getItem("participants"));
        let first = row.cells[0].innerHTML;
        let last = row.cells[1].innerHTML;
        let role = row.cells[2].innerHTML;
        for (let i = 0; i < participants.length; i++) {
            if (
                participants[i].first === first &&
                participants[i].last === last &&
                participants[i].role === role
            ) {
                participants.splice(i, 1); 
                localStorage.setItem("participants", JSON.stringify(participants));
                row.parentNode.removeChild(row);
                break;
            }
        }
    }
}

function domAddParticipant(participant) {
    let table = document.getElementById("participant-table");
    let newRow = table.insertRow();

    let cell1 = newRow.insertCell();
    cell1.textContent = participant.first;

    let cell2 = newRow.insertCell();
    cell2.textContent = participant.last;

    let cell3 = newRow.insertCell();
    cell3.textContent = participant.role;
}

// Check if there's a nextId entry in localStorage
if (localStorage.getItem("nextId")) {
    // If there is, set the nextId static variable of the Participant class to its value
    participant.nextId = parseInt(localStorage.getItem("nextId"));
}

if (localStorage.getItem("participants")) {
    let participants = JSON.parse(localStorage.getItem("participants"));
    participants.forEach(element => {
        domAddParticipant(element);
    });
}

class participant {
    static nextId = 1;

    constructor(firstName, lastName, role) {
        this.id = participant.nextId++;
        this.first = firstName;
        this.last = lastName;
        this.role = role;

        // Add the participant to the participants array in localStorage
        let participants = JSON.parse(localStorage.getItem("participants")) || [];
        participants.push(this);
        localStorage.setItem("participants", JSON.stringify(participants));
    }
}

function addParticipant(event) {

    const first = document.getElementById("first").value;
    const last = document.getElementById("last").value;
    const role = document.getElementById("role").value;

    document.getElementsByTagName("input").value = null;

    // Add participant to the HTML
    domAddParticipant(new participant(first, last, role));

    // Move cursor to the first name input field
    document.getElementById("first").focus();

    if (typeof (Storage) !== "undefined") {

    }
}

document.addEventListener("DOMContentLoaded", (Event) => {
    // This function is run after the page contents have been loaded
    // Put your initialization code here
    document.getElementById("addButton").onclick = addParticipant;

    let table = document.getElementById("participant-table");
    table.addEventListener("dblclick", function (event) {
        domRemoveParticipant(event)
    });
})

console.log(JSON.parse(localStorage.getItem("participants")));