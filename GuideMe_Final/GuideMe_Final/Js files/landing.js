const profileBtn = document.querySelector(".profile-btn");
const dropdown = document.querySelector(".dropdown");

profileBtn.addEventListener("click", () => {
    dropdown.classList.toggle("show");
});

window.addEventListener("click", (e) => {
    if (!e.target.closest(".profile-menu")) {
        dropdown.classList.remove("show");
    }
});

function logout(){
    localStorage.removeItem("token");
    window.open("../Html files/login.html", "_self")
}


// ///////////////////////////////////
const slider = document.getElementById("slider");

document.getElementById("right").onclick = function () {

    slider.scrollBy({
        left:350,
        behavior:"smooth"
    });

}

document.getElementById("left").onclick = function () {

    slider.scrollBy({
        left:-350,
        behavior:"smooth"
    });

}