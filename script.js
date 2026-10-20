const { Select } = require("react-day-picker");

const form = document.getElementById("biodataForm");
const message = document.getElementById("message");

form.addEventListener("submit", function(event) {
    event.preventDefault();

    const fullname =
        document.getElementById("fullname").value.trim();

    const matric =
        document.getElementById("matric").value.trim();

    const email =
        document.getElementById("email").value.trim();

    const dob =
        document.getElementById("dob").value;

    const gender =
        document.getElementById("gender").value;
    const level =
        document.getElementById("level").value;

    const department =
        document.getElementById("department").value.trim();

    if (!fullname || !matric || !email ||
        !dob || !gender || !level || !department) {

        message.textContent = "Please fill in every field.";
        message.style.color = "red";
        return;
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (new Date(dob) >= today) {
        message.textContent =
            "Date of birth must be in the past.";
        message.style.color = "red";
        return;
    }

    message.textContent =
        "Biodata validated successfully!";
    message.style.color = "green";    
});
