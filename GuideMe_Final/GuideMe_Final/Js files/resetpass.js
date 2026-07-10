let form = document.getElementById("resetForm");
let password = document.getElementById("newPassword");
let confirmPassword = document.getElementById("confirmNewPassword");
let baseurl = "http://127.0.0.1:8000/api";

form.addEventListener("submit", async function (e) {
    e.preventDefault();
    try {
        let response = await fetch(`${baseurl}/resetPassword`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                newPassword: password.value,
                confirmNewPassword: confirmPassword.value
            })
        });
        let data = await response.json();
        window.open("../Html files/login.html", "_self");
        console.log(data);
    } catch (error) {
        console.log(error);
    }
});