const BaseUrl = "http://127.0.0.1:8000/api";

const user_id = localStorage.getItem("user_id");
const token = localStorage.getItem("token");


const form = document.getElementById("editGuideForm");

const name = document.getElementById("name");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const gender = document.getElementById("gender");
const age = document.getElementById("age");
const area = document.getElementById("area");
const price = document.getElementById("price_per_hour");

const image = document.getElementById("image");
const licence = document.getElementById("licence");

const previewImage = document.getElementById("previewImage");

const changePic = document.getElementById("ChangePic");

function logout(){
    localStorage.removeItem("token");
    window.open("../Html files/login.html", "_self")
}

changePic.addEventListener("click", () => {

    image.click();

});

image.addEventListener("change", () => {

    if(image.files.length > 0){

        previewImage.src = URL.createObjectURL(image.files[0]);

    }

});

async function getGuide(){

    try{

        const response = await fetch(`${BaseUrl}/GuideData/${user_id}`,{

            headers:{
                "Accept":"application/json",
                "Authorization":`Bearer ${token}`
            }

        });

        const data = await response.json();

        console.log(data);

        const guide = data.data;

        name.value = guide.name;
        email.value = guide.email;
        phone.value = guide.phone;
        gender.value = guide.gender;
        age.value = guide.age;
        area.value = guide.area;
        price.value = guide.price_per_hour;

        previewImage.src = guide.image;

    }

    catch(error){

        console.log(error);

    }

}

getGuide();

form.addEventListener("submit", async function(e){

    e.preventDefault();

    try{

        const response = await fetch(`${BaseUrl}/GuideData/${user_id}`,{

            method:"PATCH",

            headers:{
                "Content-Type":"application/json",
                "Authorization":`Bearer ${token}`
            },

            body:JSON.stringify({

                name:name.value,
                email:email.value,
                phone:phone.value,
                gender:gender.value,
                age:Number(age.value),
                area:area.value,
                price_per_hour:Number(price.value)

            })

        });

        const data = await response.json();

        console.log(data);

        alert("Profile updated successfully!");

        window.location.href="tourGuideProfile.html";

    }

    catch(error){

        console.log(error);

    }

});

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
