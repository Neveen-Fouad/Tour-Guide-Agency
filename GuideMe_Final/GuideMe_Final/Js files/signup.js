let signUpButton = document.getElementById("signUp");
let signUp2Button = document.getElementById("signUp2");
let container = document.getElementById("container");

// Animation
signUpButton.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});

signUp2Button.addEventListener("click", () => {
    container.classList.remove("right-panel-active");
});

// tour guide form
let tourguideform = document.getElementById("tourGuide");
let name = document.getElementById("GuideName");
let phone = document.getElementById("GuidePhone");
let email = document.getElementById("GuideEmail");
let area = document.getElementById("GuideArea");
let language = document.getElementById("GuideLanguages");
let password = document.getElementById("GuidePassword");
let confirmPassword = document.getElementById("GuidePassword_confirmation");
let age = document.getElementById("GuideAge");
let gender = document.getElementById("GuideGender");
let price = document.getElementById("GuidePricePerHour");
let profilePicture = document.getElementById("guide_pic");
let licensePicture = document.getElementById("License_pic");

// tourist form

let touristform = document.getElementById("tourist");
let touristName = document.getElementById("TouristName");
let touristPhone = document.getElementById("TouristPhone");
let touristEmail = document.getElementById("TouristEmail");
let touristGender = document.getElementById("TouristGender");
let touristage = document.getElementById("TouristAge");
let Tpassword = document.getElementById("TouristPassword");
let TconfirmPassword = document.getElementById("TouristPassword_confirmation");

// Base URL
let baseurl = "http://127.0.0.1:8000/api"

// Tour Guide Form

tourguideform.addEventListener("submit", async function (e) {
    e.preventDefault();
    try {
        const formData = new FormData();
        formData.append("GuideName", name.value);
        formData.append("GuidePhone", phone.value);
        formData.append("GuideEmail", email.value);
        formData.append("GuideArea", area.value);
        formData.append("GuideLanguages", language.value);
        formData.append("GuidePassword", password.value);
        formData.append("GuidePassword_confirmation", confirmPassword.value);
        formData.append("GuideAge", age.value);
        formData.append("GuideGender", gender.value);
        formData.append("GuidePricePerHour", price.value);
        formData.append("guide_pic", profilePicture.files[0]);
        formData.append("License_pic", licensePicture.files[0]);
        let response = await fetch(`${baseurl}/GuideAuth`, {
            method: "POST",
            headers: {
                "Content-Type": "multipart/form-data",
            },
            body: formData
        })
        let data = await response.json();
        window.open("../Html files/landing.html", "_self")
        console.log(data);
    } catch (error) {
        console.error("Error submitting form:", error);
    }
})

// Tourist Form

touristform.addEventListener("submit", async function (e) {
    e.preventDefault();
    try {
        let response = await fetch(`${baseurl}/TouristAuth`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                TouristName: touristName.value,
                TouristPhone: touristPhone.value,
                TouristEmail: touristEmail.value,
                TouristPassword: Tpassword.value,
                TouristPassword_confirmation: TconfirmPassword.value,
                TouristAge: touristage.value,
                TouristGender: touristGender.value,
            })
        })

        let data = await response.json();
        window.open("../Html files/landing.html", "_self")
        console.log(data);
    } catch (error) {
        console.error("Error", error);
    }
})
