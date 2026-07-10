let selectedFilters = {
    language: 'English',
    price: 150,
    specializations: []
};

function logout() {
    localStorage.removeItem("token");
    window.open("../Html files/login.html", "_self")
}
// function openDialog() {
//     document.getElementById('dialogOverlay').classList.add('active');
// }

// function closeDialog() {
//     document.getElementById('dialogOverlay').classList.remove('active');
//     document.getElementById('resultsMessage').classList.remove('active');
// }

// function selectLanguage(button, language) {
//     // Remove active from all buttons
//     document.querySelectorAll('.lang-btn').forEach(btn => {
//         btn.classList.remove('active');
//     });
//     // Add active to selected button
//     button.classList.add('active');
//     selectedFilters.language = language;
//     console.log('Selected Language:', language);
// }

// function updatePrice(slider) {
//     selectedFilters.price = slider.value;
//     document.getElementById('priceValue').textContent = slider.value;
// }

function updateSpecialization() {
    const specializations = [];
    if (document.getElementById('archaeology').checked) specializations.push('Archaeology');
    if (document.getElementById('food').checked) specializations.push('Food & Dining');
    if (document.getElementById('hiking').checked) specializations.push('Hiking & Desert');
    if (document.getElementById('local').checked) specializations.push('Local Life');

    selectedFilters.specializations = specializations;
}

// function resetFilters() {
//     // Reset languages
//     document.querySelectorAll('.lang-btn').forEach(btn => {
//         btn.classList.remove('active');
//     });
//     document.querySelectorAll('.lang-btn')[0].classList.add('active');

//     // Reset price
//     document.getElementById('priceSlider').value = 150;
//     document.getElementById('priceValue').textContent = '150';

//     // Reset specializations
//     document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
//         checkbox.checked = false;
//     });

//     selectedFilters = {
//         language: 'English',
//         price: 150,
//         specializations: []
//     };

//     document.getElementById('resultsMessage').classList.remove('active');
//     console.log('All filters reset');
// }

// function applyFilters() {
//     updateSpecialization();

//     let message = `✓ Search Applied<br>;
//         message += <strong>Language:</strong> ${selectedFilters.language}<br>;
//             message += <strong>Price:</strong> Up to $${selectedFilters.price} per day<br>;

//             if (selectedFilters.specializations.length > 0) {
//                     message += <strong>Specializations:</strong> ${selectedFilters.specializations.join(', ')}<br>;
//             } else {
//                         message += <strong>Specializations:</strong> All Types<br>;
//             }

//                             message += <br>Loading 48 guides...;

//                                 document.getElementById('resultsMessage').innerHTML = message;
//                                 document.getElementById('resultsMessage').classList.add('active');

//                                 console.log('Selected Filters:', selectedFilters);

//             // Simulate loading
//             setTimeout(() => {
//                                 document.getElementById('resultsMessage').innerHTML = 
//                     ✓ Found 48 Guides!<br> +
//                                 Language: ${selectedFilters.language} |  +
//                                 Price: $${selectedFilters.price}/day;
//             }, 1000);
//         }`

//     document.getElementById('dialogOverlay').addEventListener('click', function (e) {
//         if (e.target === this) {
//             closeDialog();
//         }
//     });
// }

const BASE_URL = "http://127.0.0.1:8000/api/GuideData";


document.addEventListener("DOMContentLoaded", () => {
    fetchGuides(`${BASE_URL}/name/`);
});

async function fetchGuides(url) {

    console.log("URL:", url);

    try {
        let response = await fetch(url, {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        });

        console.log(response);

        let guidesData = await response.json();
        console.log(guidesData);

        updateExistingCards(guidesData);

    } catch (error) {
        console.error(error);
    }
}

function updateExistingCards(guidesList) {
    const cards = document.querySelectorAll(".card");

    guidesList.forEach((guide, index) => {

        if (index >= cards.length) return;

        const card = cards[index];


        const nameNode = card.querySelector(".guide-name");
        if (nameNode) nameNode.textContent = guide.name || "N/A";


        const locationNode = card.querySelector(".guide-location span:last-child");
        if (locationNode) locationNode.textContent = `${guide.area || "Egypt"}`;


        const langNode = card.querySelector(".guide-languages span:last-child");
        if (langNode) langNode.textContent = guide.language || "Arabic, English";


        const priceNode = card.querySelector(".price");
        if (priceNode) {
            priceNode.innerHTML = `<span class="price-currency">$</span>${guide.pricePerHour || "50"}<span style="font-size: 14px;">/hr</span>`;
        }
    });
}


function handleSearch() {
    const searchKey = document.getElementById("searchInput") ? document.getElementById("searchInput").value.trim() : "";
    fetchGuides(`${BASE_URL}/name/${searchKey}`);
}


let selectedLanguage = "English";
function selectLanguage(buttonElement, lang) {
    document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
    buttonElement.classList.add('active');
    selectedLanguage = lang;
}

function updatePrice(slider) {
    document.getElementById("priceValue").textContent = slider.value;
}

function applyFilters() {
    const priceLimit = document.getElementById("priceSlider").value;
    if (selectedLanguage) {
        fetchGuides(`${BASE_URL}/languages/${selectedLanguage}`);
    } else if (priceLimit && priceLimit !== "150") {
        fetchGuides(`${BASE_URL}/price/${priceLimit}`);
    } else {
        fetchGuides(`${BASE_URL}/name/`);
    }
    closeDialog();
}

function resetFilters() {
    fetchGuides(`${BASE_URL}/name/`);
    closeDialog();
}

function openDialog() { document.getElementById("dialogOverlay").style.display = "flex"; }
function closeDialog() { document.getElementById("dialogOverlay").style.display = "none"; }

// const profileBtn = document.querySelector(".profile-btn");
// const dropdown = document.querySelector(".dropdown");

// profileBtn.addEventListener("click", () => {
//     dropdown.classList.toggle("show");
// });

// window.addEventListener("click", (e) => {
//     if (!e.target.closest(".profile-menu")) {
//         dropdown.classList.remove("show");
//     }
// });
