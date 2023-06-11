const dark = document.getElementById("dark");
const light = document.getElementById("light");
const theme = document.getElementById("theme-switch");
const relLink = document.querySelector("[href='../']");
const setTheme = localStorage.getItem("theme");
if (setTheme == "dark") {
  if (relLink !== null) {
    theme.href = "../css/dark.css"
  } else {
    theme.href = "css/dark.css"
  }
  light.classList.add("hide");
  dark.removeAttribute("class");
} else {
  dark.classList.add("hide");
  light.removeAttribute("class");
  theme.removeAttribute("href");
}
function changeTheme() {
  if (dark.classList.contains("hide")) {
    if (relLink !== null) {
      theme.href = "../css/dark.css"
    } else {
      theme.href = "css/dark.css"
    }
    light.classList.add("hide");
    localStorage.setItem("theme", "dark");
    dark.removeAttribute("class");
  } else {
    dark.classList.add("hide");
    localStorage.setItem("theme", "light");
    light.removeAttribute("class");
    theme.removeAttribute("href");
  }
}
function mobileNav() {
  const nav = document.getElementById("nav-list");
  const menuIcon = document.getElementById("menu-icon");
  const closeIcon = document.getElementById("close-icon");
  if (closeIcon.classList.contains("hide")) {
    menuIcon.classList.add("hide");
    nav.style.display = ("flex");
    setTimeout(function () { nav.className = "anim" }, 0);
    closeIcon.removeAttribute("class");
  } else {
    closeIcon.classList.add("hide");
    nav.removeAttribute("class");
    nav.removeAttribute("style");
    menuIcon.removeAttribute("class");
  }
}
function showPass() {
  const userPass = document.querySelector(".user-password");
  const view = document.getElementById("view");
  const blur = document.getElementById("blur");
  if (blur.classList.contains("hide")) {
    view.classList.add("hide");
    userPass.setAttribute("type", "text");
    blur.removeAttribute("class");
  } else {
    blur.classList.add("hide");
    userPass.setAttribute("type", "password");
    view.removeAttribute("class");
  }
}
function showPassNew() {
  const userPass = document.querySelector(".user-password-new");
  const view = document.getElementById("viewNew");
  const blur = document.getElementById("blurNew");
  if (blur.classList.contains("hide")) {
    view.classList.add("hide");
    userPass.setAttribute("type", "text");
    blur.removeAttribute("class");
  } else {
    blur.classList.add("hide");
    userPass.setAttribute("type", "password");
    view.removeAttribute("class");
  }
}
function checkOpt() {
  const select = document.getElementById("book-action");
  if (select.value === "upload") {
    req();
  } else {
    hide();
  }
}
const files = document.querySelector(".files");
function req() {
  files.setAttribute("required", "");
}
function hide() {
  files.removeAttribute("required");
}
function actionConfirm() {
  const actionConfirm = document.getElementById("confirm-action");
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