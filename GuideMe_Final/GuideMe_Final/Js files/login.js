// popup functionality

let forgetPassword = document.getElementById("forgetPassword");
let popup = document.getElementById("popup-overlay");
let closePopup = document.getElementById("closePopup");

forgetPassword.addEventListener("click", function (e) {
    e.preventDefault();
    popup.style.display = "flex";
});

closePopup.addEventListener("click", function () {
    popup.style.display = "none";
});

popup.addEventListener("click", function (e) {
    if (e.target === popup) {
        popup.style.display = "none";
    }
});


// login form

let email = document.getElementById("email");
let password = document.getElementById("password");
let loginBtn = document.getElementById("loginBtn");
let baseurl = "http://127.0.0.1:8000/api"

loginBtn.addEventListener("click", async function (e) {
    e.preventDefault();
    try {
        let response = await fetch(`${baseurl}/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email: email.value,
                password: password.value
            })
        });
        let data = await response.json();
        localStorage.setItem("user_token", data.token);
        window.open("../Html files/landing.html", "_self");
        console.log(data);
    } catch (error) {
        console.error("Error:", error);
    }
});

// sending email to reset password

let sendReset = document.getElementById("sendReset");
sendReset.addEventListener("click", async function () {
    try {
        let response = await fetch(`${baseurl}/forgetPassword`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email: email.value
            })
        });
        let data = await response.json();
        window.open("../Html files/resetpass.html", "_self")
        console.log(data);
    } catch (error) {
        console.error("Error:", error);
    }
});
