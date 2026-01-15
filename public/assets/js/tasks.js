/**
 * Get CSRF token from meta tag (Laravel security)
 */
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

document.addEventListener("DOMContentLoaded", () => {
    /* =====================================================
     * DOM ELEMENTS
     * ===================================================== */
    const formCreate = document.getElementById("form-create");
    const formEdit = document.getElementById("form-edit");
    const editTitle = document.getElementById("edit-title");
    const searchInput = document.getElementById("search-input");
    const searchClear = document.getElementById("search-clear");
    const filterStatus = document.getElementById("filter-status");
    const cancelEditButton = document.getElementById("cancel-edit");
    const todoList = document.querySelector(".todo-list");

    /**
     * Stores all tasks in memory to keep UI synchronized
     */
    let allTasks = [];

    /* =====================================================
     * RENDER FUNCTIONS
     * ===================================================== */

    /**
     * Generates the HTML structure for a single task
     * @param {Object} task
     * @returns {string}
     */
    function renderTask(task) {
        return `
            <div class="todo-item ${task.is_done ? "done" : ""}" id="todo-${
            task.id
        }">
                <span>${task.title}</span>

                <div class="actions">
                    <button class="finish-todo" data-id="${task.id}">
                        <i class="fa-solid fa-check"></i>
                    </button>

                    <button class="edit-todo"
                        data-id="${task.id}"
                        data-title="${task.title}">
                        <i class="fa-solid fa-pen"></i>
                    </button>

                    <button class="remove-todo" data-id="${task.id}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        `;
    }

    /**
     * Renders a list of tasks into the DOM
     * @param {Array} tasks
     */
    function renderList(tasks) {
        todoList.innerHTML = "";
        tasks.forEach((task) => {
            todoList.insertAdjacentHTML("beforeend", renderTask(task));
        });
    }

    /* =====================================================
     * CREATE TASK
     * ===================================================== */

    /**
     * Handles task creation using AJAX
     */
    formCreate.addEventListener("submit", (e) => {
        e.preventDefault();

        const titleInput = formCreate.querySelector('input[name="title"]');
        const title = titleInput.value.trim();

        // Prevent empty task submission
        if (title.length < 3) {
            showMessage(
                "O título da tarefa deve ter pelo menos 3 caracteres.",
                formCreate
            );
            titleInput.focus();
            return;
        }

        fetch(formCreate.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: new FormData(formCreate),
        })
            .then((res) => res.json())
            .then((task) => {
                allTasks.unshift(task); // Keep local state updated
                renderList(allTasks);
                formCreate.reset();
            });
    });

    /* =====================================================
     * EDIT TASK
     * ===================================================== */

    /**
     * Opens edit mode when edit button is clicked
     */
    document.addEventListener("click", (e) => {
        const editBtn = e.target.closest(".edit-todo");
        if (!editBtn) return;

        const { id, title } = editBtn.dataset;

        // Hide create form and all tasks
        formCreate.classList.add("hide");
        document.querySelectorAll(".todo-item").forEach((item) => {
            item.classList.add("hide");
        });

        // Configure edit form
        formEdit.action = `/tasks/${id}`;
        editTitle.value = title;
        formEdit.classList.remove("hide");
        editTitle.focus();
    });

    /**
     * Updates a task via AJAX
     */
    formEdit.addEventListener("submit", (e) => {
        e.preventDefault();

        const title = editTitle.value.trim();

        formEdit.classList.remove("hide");

        if (title.length < 3) {
            showMessage(
                "Para atualizar o título deve ter pelo menos 3 caracteres.",
                formEdit
            );
            editTitle.focus();
            return;
        }

        fetch(formEdit.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: new URLSearchParams({
                _method: "PUT",
                title: title,
            }),
        })
            .then((res) => res.json())
            .then((task) => {
                const index = allTasks.findIndex((t) => t.id == task.id);
                if (index !== -1) {
                    allTasks[index].title = task.title;
                }

                renderList(allTasks);
                resetEditState();
            });
    });

    /* =====================================================
     * FINISH TASK
     * ===================================================== */

    /**
     * Marks a task as completed
     */
    document.addEventListener("click", (e) => {
        const finishBtn = e.target.closest(".finish-todo");
        if (!finishBtn) return;

        const id = finishBtn.dataset.id;
        const todoItem = document.getElementById(`todo-${id}`);

        fetch(`/tasks/${id}/toggle`, {
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
        })
            .then((res) => res.json())
            .then((task) => {
                const index = allTasks.findIndex((t) => t.id == task.id);
                if (index !== -1) {
                    allTasks[index].is_done = task.is_done;
                }

                todoItem.classList.toggle("done", task.is_done);
            });
    });

    /* =====================================================
     * DELETE TASK
     * ===================================================== */

    /**
     * Deletes a task via AJAX
     */
    document.addEventListener("click", (e) => {
        const deleteBtn = e.target.closest(".remove-todo");
        if (!deleteBtn) return;

        const id = deleteBtn.dataset.id;

        fetch(`/tasks/${id}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            body: new URLSearchParams({ _method: "DELETE" }),
        }).then(() => {
            allTasks = allTasks.filter((task) => task.id != id);
            renderList(allTasks);
        });
    });

    /* =====================================================
     * LOAD & FILTER TASKS
     * ===================================================== */

    /**
     * Loads tasks from the server
     */
    function loadTasks() {
        fetch("/tasks", {
            headers: { Accept: "application/json" },
        })
            .then((res) => res.json())
            .then((tasks) => {
                allTasks = tasks;
                renderList(allTasks);
            });
    }

    /**
     * Filters tasks by search text and status
     * @param {string} searchText
     * @param {string} filterValue
     */
    function filterTasks(searchText = "", filterValue = "all") {
        const searchLower = searchText.toLowerCase();

        const filtered = allTasks.filter((task) => {
            const matchesSearch = task.title
                .toLowerCase()
                .includes(searchLower);

            let matchesFilter = true;
            if (filterValue === "done") matchesFilter = task.is_done;
            if (filterValue === "todo") matchesFilter = !task.is_done;

            return matchesSearch && matchesFilter;
        });

        renderList(filtered);
    }

    searchInput?.addEventListener("input", (e) => {
        filterTasks(e.target.value, filterStatus.value);
    });

    filterStatus?.addEventListener("change", (e) => {
        filterTasks(searchInput.value, e.target.value);
    });

    searchClear?.addEventListener("click", () => {
        searchInput.value = "";
        filterTasks("", filterStatus.value);
    });

    /* =====================================================
     * EDIT RESET
     * ===================================================== */

    /**
     * Resets the UI back to create mode
     */
    function resetEditState() {
        formEdit.classList.add("hide");
        formCreate.classList.remove("hide");
        editTitle.value = "";

        document.querySelectorAll(".todo-item").forEach((item) => {
            item.classList.remove("hide");
        });
    }

    cancelEditButton?.addEventListener("click", resetEditState);

    /* =====================================================
     * INITIAL LOAD
     * ===================================================== */
    loadTasks();
});
