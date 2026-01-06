setTimeout(() => {
    const messages = document.querySelectorAll(".auto-close");

    messages.forEach((message) => {
        message.classList.remove("show");
        message.classList.add("fade");

        setTimeout(() => {
            message.remove();
        }, 500);
    });
}, 3000);
