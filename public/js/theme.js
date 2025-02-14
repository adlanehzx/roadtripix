function switchTheme(theme) {
  document.documentElement.setAttribute("data-theme", theme);
  localStorage.setItem("theme", theme);
}

document.addEventListener("DOMContentLoaded", () => {
  const savedTheme = localStorage.getItem("theme") || "light";
  switchTheme(savedTheme);
});

document.querySelector("#theme-toggle").addEventListener("click", () => {
  const currentTheme = document.documentElement.getAttribute("data-theme");
  console.log("Current Theme:", currentTheme);
  const newTheme = currentTheme === "dark" ? "light" : "dark";
  console.log("New Theme:", newTheme);
  switchTheme(newTheme);
});
