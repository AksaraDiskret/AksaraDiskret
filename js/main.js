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

const firstName = document.querySelector("#first-name");
const lastName = document.querySelector("#last-name");
const email = document.querySelector("#email");
const password = document.querySelector("#password");
const failedNote = document.querySelector(".failed");
const successNote = document.querySelector(".success");

function isEmail(email) {
    const StandardEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return StandardEmail.test(email);
}

const dataSignup = {};
function LoadData() {
    dataSignup.Fname = firstName.value;
    dataSignup.Lname = lastName.value;
    dataSignup.email_address = email.value;
    dataSignup.pass = password.value;

    if (Boolean(dataSignup.Fname)
        && Boolean(dataSignup.Lname)
        && Boolean(dataSignup.email_address)
        && Boolean(dataSignup.pass)) {

        if (isEmail(dataSignup.email_address) === true) {
            if (dataSignup.pass.length >= 8) {
                localStorage.setItem("dataSignup", JSON.stringify(dataSignup));
                window.location.href = "/signin";
            } else {
                failedNote.textContent = "Password is too short. Please enter at least 8 characters.";
            }
        } else {
            failedNote.textContent = "Invalid email address. Please try again.";
        }
    } else {
        failedNote.textContent = "Please fill out the form.";
    }
}

const dataCheck = localStorage.getItem("dataSignup");
const dataSigninPass = document.querySelector("#password");
const UserName = document.getElementById("user");
const Data = JSON.parse(dataCheck);
UserName.innerHTML = `${Data.Fname} ${Data.Lname}`;

function signIn() {
    if (dataCheck !== null && isEmail(Data.email_address) === true) {
        if (Data.email_address === email.value
            && Data.pass === dataSigninPass.value) {
            window.location.href = "/collection";
        } else {
            failedNote.textContent = "Invalid email address or password.";
        }
    } else {
        failedNote.textContent = "Please fill out the form.";
    }
}