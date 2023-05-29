const nav = document.getElementById("nav-list");
const menuIcon = document.getElementById("menu-icon");
const closeIcon = document.getElementById("close-icon");

function mobileNav() {
  nav.classList.toggle("show-menu");
  if (nav.classList.contains("show-menu")) {
    menuIcon.style.display = "none";
    closeIcon.style.display = "block";
  } else {
    nav.removeAttribute("class");
    menuIcon.removeAttribute("style");
    closeIcon.removeAttribute("style");
  }
}

const elements = [
  { s: "s-default-pass", h: "h-default-pass", show: ".default-password" },
  { s: "s-old-pass", h: "h-old-pass", show: ".old-password" }
];

elements.forEach(({ s, h, show }) => {
  const spassword = document.getElementById(s);
  const hpassword = document.getElementById(h);
  const showElement = document.querySelector(show);

  if (spassword && hpassword && showElement) {
    spassword.addEventListener("click", () => showPassword(spassword, hpassword, showElement));
    hpassword.addEventListener("click", () => hidePassword(spassword, hpassword, showElement));
  }
});

function showPassword(spassword, hpassword, show) {
  spassword.style.opacity = 0;
  hpassword.style.opacity = 1;
  hpassword.style.zIndex = 1;
  show.setAttribute("type", "text");
}

function hidePassword(spassword, hpassword, show) {
  spassword.style.opacity = 1;
  hpassword.style.opacity = 0;
  hpassword.style.zIndex = -1;
  show.setAttribute("type", "password");
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