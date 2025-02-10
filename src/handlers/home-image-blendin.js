document.addEventListener("DOMContentLoaded", function () {
    let img = document.getElementById("image");
    img.style.opacity = 0;
    img.style.transition = "opacity 2s ease-in-out";
    setTimeout(() => {
        img.style.opacity = 2;
    }, 100);
});
