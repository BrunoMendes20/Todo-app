document.addEventListener("DOMContentLoaded", () => {
    // Automatically close messages rendered from the backend (Blade)
    initAutoClose();
});

/**
 * Display a message (used by AJAX / frontend logic)
 *
 * @param {string} text - Message content to be displayed
 * @param {HTMLElement|null} context - Optional DOM context to search for the container
 */
function showMessage(text, context = document) {
    // Try to find a message container inside the given context
    let container =
        context.querySelector(".errors-message-crud") ||
        context.querySelector(".invalid-feedback");

    // Stop execution if no container is found
    if (!container) return;

    // Set message text and make it visible
    container.textContent = text;
    container.classList.remove("hide");
    container.classList.add("show", "auto-close");

    // Start auto-close timer
    autoClose(container);
}

/**
 * Initialize auto-close behavior for messages
 * already rendered by the backend.
 */
function initAutoClose() {
    document.querySelectorAll(".auto-close").forEach((message) => {
        autoClose(message);
    });
}

/**
 * Automatically close a message after a delay
 *
 * @param {HTMLElement} element - Message container element
 */
function autoClose(element) {
    setTimeout(() => {
        // Start fade-out animation
        element.classList.remove("show");
        element.classList.add("fade");

        // Remove element from the DOM after animation
        setTimeout(() => {
            element.remove();
        }, 500);
    }, 3000);
}
