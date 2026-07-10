const BaseUrl="http://127.0.0.1:8000/api";
let name= document.getElementById("name");
let email= document.getElementById("email");
let phone= document.getElementById("phone");
let gender= document.getElementById("gender");
let age= document.getElementById("age");
let area= document.getElementById("area");
let price_per_hour= document.getElementById("price_per_hour");
let licence= document.getElementById("licence");
let image= document.getElementById("image");
//reviews
let tourist_image= document.getElementById("tourist_image");
let tourist_name=document.getElementById("tourist_name");
let comment=document.getElementById("comment");
let rating=document.getElementById("rating");
//booking details
let allBookings = [];
let currentBookingId = null;
//stats
let total_booking_num = document.getElementById("total_booking_num");
let total_accepted_num = document.getElementById("total_accepted_num");
let average_rating = document.getElementById("average_rating");

function logout(){
    localStorage.removeItem("token");
    window.open("../Html files/login.html", "_self")
}

//stat funcs

//bookingNum Func


async function bookingNum() {

    let token = localStorage.getItem("token");
    let user_id = localStorage.getItem("user_id");

    let response = await fetch(`${BaseUrl}/requests/count/${user_id}`, {
        headers: {
            "Authorization": `Bearer ${token}`
        }
    });

    let data = await response.json();

    total_booking_num.innerHTML = data.count;
}
bookingNum();

//total_accepted_num fun

async function acceptedNum() {

    let token = localStorage.getItem("token");
    let user_id = localStorage.getItem("user_id");

    let response = await fetch(`${BaseUrl}/requests/accepted/count/${user_id}`, {
        headers: {
            "Authorization": `Bearer ${token}`
        }
    });

    let data = await response.json();

    total_accepted_num.innerHTML = data.count;
}

acceptedNum();

///avgRatingNum func

async function avgRatingNum() {

    let token = localStorage.getItem("token");
    let user_id = localStorage.getItem("user_id");

    let response = await fetch(`${BaseUrl}/Reviews/averageRating/${user_id}`, {
        headers: {
            "Authorization": `Bearer ${token}`
        }
    });

    let data = await response.json();

    average_rating.innerHTML = data.average_rating;
}

avgRatingNum();




//get profile func
async function getProfile(){
    let token =localStorage.getItem("token");
    let user_id=localStorage.getItem("user_id");
    
    
    //may cause an error part el id: user_id
    let response= await fetch(`${BaseUrl}/GuideData/${user_id}` , {
        headers:{
            //contentformdata? thry said no
            "Authorization": `Bearer ${token}`
        }
    })
    let data= await response.json();
    //the data.data could make an issue
    let user =data.data.user;
    name.innerHTML= user.name;
    email.innerHTML= user.email;
    phone.innerHTML= user.phone;
    gender.innerHTML= user.gender;
    age.innerHTML= user.age;
    area.innerHTML= user.area;
    price_per_hour.innerHTML= user.price_per_hour;
    //if not formdata remove this leave it static
    // image.innerHtml= user.image;
    image.src = user.image;

    console.log(data.data.user);
} 
getProfile();

// function goEdit(){
//     //i have a feeling i should give the token here but maybe thats the old way??
//     window.open("../tourguide_EditProfile.html", "_self" )
// }

editprofilebuttn.addEventListener("click" , function(){
    window.open("../Html files/tourguide_EditProfile.html", "_self" )
})

// //get reviews func
// async function getreviews(){
//     let token =localStorage.getItem("token");
//     //may cause an error part el id
//     let response= await fetch(`${BaseUrl}/Reviews` , {
//         headers:{
//             // "Authorization": `Bearer ${token}`
//             "Content-Type": "application/json"
//         }
//     })
//     //unsure about the routing again
//     let data= await response.jason();
//     let user =data.data.user;
//     tourist_image.innerHtml= user.tourist_image;
//     // tourist_name.innerHtml= user.tourist_name;
//     //chatsuggestion
//     tourist_image.src = user.tourist_image;
//     comment.innerHtml= user.comment;
//     rating.innerHtml= user.rating;

//     // console.log(data.data.user);
// } 
// getreviews();

//final reviews functions
async function getReviews() {

    try {

        let response = await fetch(`${BaseUrl}/Reviews`);

        let data = await response.json();

        console.log(data);

    } catch (error) {

        console.log(error);

    }

}
getReviews();


const container = document.getElementById("reviewsContainer");

container.innerHTML = "";

data.data.forEach(review => {

    container.innerHTML += `

        <div class="review">

            <img src="${review.tourist_image}" alt="Tourist">

            <div class="review-content">

                <h4>${review.tourist_name}</h4>

                <p>${review.comment || "No comment available."}</p>

            </div>

            <div class="stars">

                ${createStars(review.rating)}

            </div>

        </div>

    `;

});
///to loop on the stars and change base on the review
function createStars(rating) {

    let stars = "";

    for (let i = 1; i <= 5; i++) {

        if (i <= rating) {

            stars += `<i class="fa-solid fa-star"></i>`;

        } else {

            stars += `<i class="fa-regular fa-star"></i>`;

        }

    }

    return stars;
}

///final function for the booking
async function getBookings() {

    try {

        let token =localStorage.getItem("token");
        let user_id=localStorage.getItem("user_id");
        let response = await fetch(`${BaseUrl}/requests/tourguide/${user_id}`);
        //id from whattt????? update:if it made an error ill just killsomeone atp

        let data = await response.json();

        // console.log(data);
        //probably eroor
        displayBookings(data.data);

    } catch (error) {

        console.log(error);

    }

}
getBookings();

function displayBookings(bookings) {

    allBookings = bookings;    
    let cartona = "";

    bookings.forEach(booking => {

        cartona += `
            <div class="booking">

                <div class="bookinfo">

                    <img src="${booking.tourist_image}" alt="${booking.tourist_name}">

                    <div class="book-text">
                        <h4>${booking.tourist_name}</h4>

                        <p>
                            <i class="fa-solid fa-map-location-dot"></i>
                            ${booking.destination}
                        </p>

                        <p>
                            <i class="fa-solid fa-calendar-days"></i>
                            ${booking.arrival_time}
                        </p>

                    </div>

                </div>

                <div>

                    <button class="viewdetails"
                        onclick="openModal('${booking.id}')">
                        Show Details
                    </button>

                </div>

            </div>
        `;

    });

    document.getElementById("cartona").innerHTML = cartona;

}

// function openModal(id){
    

//     let booking = allBookings.find(b => b.id == id);

//     document.getElementById("modalImage").src = booking.tourist_image;
//     document.getElementById("modalName").textContent = booking.tourist_name;
//     document.getElementById("modalDestination").textContent = booking.destination;
//     document.getElementById("modalDate").textContent = booking.arrival_time;
//     document.getElementById("modalPlan").textContent = booking.plan;

//     document.getElementById("bookingModal").style.display = "flex";

// }

// function closeModal(){

//     document.getElementById("bookingModal").style.display = "none";

// }

// async function acceptBooking(id){

//     await fetch(`${baseUrl}/api/requests/${id}/accept`,{
//         method:"PATCH"
//     });

//     closeModal();

//     getBookingRequests();

// }

// async function rejectBooking(id){

//     await fetch(`${baseUrl}/api/requests/${id}/reject`,{
//         method:"PATCH"
//     });

//     closeModal();

//     getBookingRequests();

// }
async function updateBooking(id, approval) {

    let token = localStorage.getItem("token");

    await fetch(`${BaseUrl}/requests/approval/${id}`, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
        },
        body: JSON.stringify({
            is_approved: approval
        })
    });

    closeModal();
    getBookings();
}

acceptBtn.onclick = function () {
    updateBooking(currentBookingId, 1);
};

rejectBtn.onclick = function () {
    updateBooking(currentBookingId, 0);
};


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


// document.getElementById("acceptBtn").onclick = function(){

//     acceptBooking(booking.id);

// }

// document.getElementById("rejectBtn").onclick = function(){

//     rejectBooking(booking.id);

// }



