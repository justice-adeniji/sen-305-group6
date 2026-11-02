const form = document.getElementById("biodataForm");
const message = document.getElementById("message");

if (form) {
    form.addEventListener("submit", async function(event) {
        event.preventDefault();

        const fullname = document.getElementById("fullname").value.trim();
        const matric = document.getElementById("matric").value.trim();
        const email = document.getElementById("email").value.trim();
        const dob = document.getElementById("dob").value;
        const gender = document.getElementById("gender").value;
        const level = document.getElementById("level").value;
        const department = document.getElementById("department").value.trim();

        if (!fullname || !matric || !email || !dob || !gender || !level || !department) {
            message.textContent = "Please fill in every field.";
            message.style.color = "#ff6b6b";
            return;
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (new Date(dob) >= today) {
            message.textContent = "Date of birth must be in the past.";
            message.style.color = "#ff6b6b";
            return;
        }

        message.textContent = "Saving to database...";
        message.style.color = "#ffd166";

        try {
            const response = await fetch("submit_biodata.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    fullname: fullname,
                    matric_no: matric,
                    email: email,
                    dob: dob,
                    gender: gender,
                    level: level,
                    department: department
                })
            });

            const result = await response.json();

            if (result.success) {
                message.textContent = result.message || "Biodata saved to database successfully!";
                message.style.color = "#06d6a0";
                form.reset();
            } else {
                message.textContent = result.message || "Failed to save biodata.";
                message.style.color = "#ff6b6b";
            }
        } catch (error) {
            message.textContent = "Network error or server unavailable. Please try again.";
            message.style.color = "#ff6b6b";
            console.error("Submission error:", error);
        }
    });
}
