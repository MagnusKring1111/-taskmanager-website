document.addEventListener("DOMContentLoaded", () => {
    // Drag & Drop Kanban
    const cards = document.querySelectorAll(".task-card");
    const columns = document.querySelectorAll(".task-list");

    cards.forEach(card => {
        card.addEventListener("dragstart", e => {
            e.dataTransfer.setData("taskId", card.dataset.taskId);
        });
    });

    columns.forEach(column => {
        column.addEventListener("dragover", e => e.preventDefault());

        column.addEventListener("drop", e => {
            e.preventDefault();
            const taskId = e.dataTransfer.getData("taskId");
            const newStatusId = column.dataset.statusId;

            fetch("/actions/change_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `task_id=${taskId}&status_id=${newStatusId}`
            }).then(() => location.reload());
        });
    });

    // User dropdown toggle
    const userDropdownToggle = document.getElementById("userDropdownToggle");
    const userDropdownMenu = document.getElementById("userDropdownMenu");

    if (userDropdownToggle && userDropdownMenu) {
        userDropdownToggle.addEventListener("click", (e) => {
            e.stopPropagation();
            const isVisible = userDropdownMenu.style.display === "block";
            userDropdownMenu.style.display = isVisible ? "none" : "block";
            userDropdownToggle.classList.toggle("active", !isVisible);
        });

        document.addEventListener("click", (e) => {
            if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                userDropdownMenu.style.display = "none";
                userDropdownToggle.classList.remove("active");
            }
        });
    }
});
