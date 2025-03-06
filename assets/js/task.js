document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("taskModal");
    const openBtn = document.getElementById("openTaskModal");
    const closeBtn = document.querySelector(".close");

    // Show modal when clicking the plus button
    openBtn.addEventListener("click", function () {
        modal.style.display = "block";
    });

    // Close modal when clicking close button
    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Handle form submission with AJAX
    document.getElementById("taskForm").addEventListener("submit", function (event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("/tasks/create", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            window.location.reload(); // Refresh page after success
        })
        .catch(error => console.error("Error:", error));
    });
});