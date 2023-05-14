const nav = document.getElementById("nav-list");
const close = document.getElementById("close-icon");

function showMenu() {
    nav.classList.add("show-menu");
    close.style.display = "block";
}

function closeMenu() {
    nav.removeAttribute("class");
    close.removeAttribute("style");
}

function showPassword() {
    const password = document.getElementById("show-password");
    const show = document.getElementsByClassName("password");

    if (password.checked) {
        for (var i = 0; i < show.length; i++) {
            show[i].setAttribute("type", "text");
        }
    } else {
        for (var i = 0; i < show.length; i++) {
            show[i].setAttribute("type", "password");
        }
    }
}

function actionConfirm() {
    const actionConfirm = document.getElementById("action-confirm");
    const actionBtn = document.getElementById("action-btn");

    if (actionConfirm.checked) {
        actionBtn.removeAttribute("disabled");
    } else {
        actionBtn.setAttribute("disabled", "");
    }
}

function deleteConfirm() {
    const deleteConfirm = document.getElementById("delete-confirm");
    const deleteBtn = document.getElementById("delete-btn");

    if (deleteConfirm.checked) {
        deleteBtn.removeAttribute("disabled");
    } else {
        deleteBtn.setAttribute("disabled", "");
    }
}