import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

function applyTheme(theme) {
    if (theme === "dark") {
        document.documentElement.classList.add("dark");
        themeToggleDarkIcon.classList.add("hidden");
        themeToggleLightIcon.classList.remove("hidden");
    } else {
        document.documentElement.classList.remove("dark");
        themeToggleDarkIcon.classList.remove("hidden");
        themeToggleLightIcon.classList.add("hidden");
    }
}

var themeToggleBtn = document.getElementById("theme-toggle");

if(themeToggleBtn){
    themeToggleBtn.addEventListener("click", function () {
        var currentTheme = document.documentElement.classList.contains("dark") ? "dark" : "light";
        var newTheme = currentTheme === "dark" ? "light" : "dark";
        applyTheme(newTheme);
        localStorage.setItem("color-theme", newTheme);
    });
}

