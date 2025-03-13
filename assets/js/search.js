document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("liveSearchInput");
    const dropdown = document.getElementById("liveSearchResults");
    let debounceTimeout;

    if (!input || !dropdown) return;

    input.addEventListener("input", () => {
        const query = input.value.trim();
        clearTimeout(debounceTimeout);

        if (!query) {
            dropdown.innerHTML = "";
            dropdown.style.display = "none";
            return;
        }

        debounceTimeout = setTimeout(() => {
            fetch(`/actions/live_search.php?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.tasks.length && !data.clients.length) {
                        dropdown.innerHTML = `
                            <div class="live-search-dropdown">
                                <div class="live-search-list">
                                    <div class='live-search-item no-results'>Ingen resultater</div>
                                </div>
                                <div class="live-search-preview"><em>Vælg et element for at se detaljer</em></div>
                            </div>`;
                        dropdown.style.display = "block";
                        return;
                    }

                    let taskList = '';
                    let clientList = '';

                    if (data.tasks.length) {
                        taskList += `<div class="live-search-section-title">Opgaver</div>`;
                        data.tasks.forEach(task => {
                            taskList += `
<div class="live-search-item" data-type="task" data-id="${task.id}">
    <div class="item-title">${task.titel}</div>
    <div class="item-sub">${task.kunde_navn}</div>
</div>`;
                        });
                    }

                    if (data.clients.length) {
                        clientList += `<div class="live-search-section-title">Kunder</div>`;
                        data.clients.forEach(client => {
                            clientList += `
<div class="live-search-item" data-type="client" data-id="${client.id}">
    <div class="item-title">${client.navn}</div>
    <div class="item-sub">${client.email}</div>
</div>`;
                        });
                    }

                    dropdown.innerHTML = `
<div class="live-search-dropdown">
    <div class="live-search-list">
        ${taskList + clientList}
        <a href="/pages/search.php?q=${encodeURIComponent(query)}" class="live-search-all">Se alle resultater</a>
    </div>
    <div class="live-search-preview" id="searchPreviewBox">
        <em>Vælg et element for at se detaljer</em>
    </div>
</div>`;
                    dropdown.style.display = "block";

                    // Hover preview logic
                    document.querySelectorAll(".live-search-item").forEach(item => {
                        item.addEventListener("mouseover", () => {
                            const type = item.dataset.type;
                            const id = item.dataset.id;
                            fetch(`/actions/live_search_preview.php?type=${type}&id=${id}`)
                                .then(r => r.text())
                                .then(html => {
                                    document.getElementById("searchPreviewBox").innerHTML = html;
                                });
                        });
                    });
                });
        }, 300);
    });

    document.addEventListener("click", (e) => {
        if (!dropdown.contains(e.target) && e.target !== input) {
            dropdown.innerHTML = "";
            dropdown.style.display = "none";
        }
    });
});
