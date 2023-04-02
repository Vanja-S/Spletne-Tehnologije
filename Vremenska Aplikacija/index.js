"use strict";

window.addEventListener("load", () => {
    makeAPICall("Ljubljana");
    initLikeButton();
    initSearchBar();
});

function initLikeButton() {
    const button = document.querySelector(".heart-like-button");

    button.addEventListener("click", () => {
        if (button.classList.contains("liked")) {
            button.classList.remove("liked");
            removeFromFavorites(document.querySelector(".location"));
        } else {
            button.classList.add("liked");
            addToFavorites(document.querySelector(".location"));
        }
    });
}

function addToFavorites(location) {
    const cityName = location.textContent;

    if (localStorage.getItem(cityName) !== null) {
        alert('This city is already added to favorites!');
        return;
    }
    localStorage.setItem(cityName, true);

    const newDiv = document.createElement('div');
    newDiv.classList.add('favorite-city');

    const h2 = document.createElement('h2');
    h2.textContent = cityName;
    const h3 = document.createElement('h3');
    h3.textContent = 'Population: 1000000';

    newDiv.appendChild(h2);
    newDiv.appendChild(h3);

    const sidebar = document.querySelector('.sidebar');
    sidebar.appendChild(newDiv);
}

function removeFromFavorites(location) {
    const cityName = location.textContent;

    localStorage.removeItem(cityName);

    const sidebar = document.querySelector('.sidebar');
    const divToRemove = sidebar.querySelector(`h2:contains(${cityName})`).parentNode;
    sidebar.removeChild(divToRemove);
}

function sanitizeInput(input) {
    const replacements = {
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;",
        "&": "&amp;"
    };

    return input.replace(/[<>"'&]/g, char => replacements[char]);
}

function initSearchBar() {
    const form = document.querySelector("form");
    form.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent the form from submitting normally

        const input = form.querySelector("input");
        const searchText = sanitizeInput(input.value); // Sanitize the user input
        makeAPICall(searchText);
    });
}

function makeAPICall(inputCity) {
    let coords = europeCapitals[inputCity];

    const city = document.querySelector("h1");
    const temp = document.querySelector("h2");
    // Make the API call to get the weather for current day
    const api = `https://api.open-meteo.com/v1/forecast?latitude=${coords.lat}&longitude=${coords.lng}&hourly=temperature_2m&forecast_days=1`;

    fetch(api)
        .then(response => {
            return response.json();
        })
        .then(data => {
            city.innerHTML = inputCity;
            temp.innerHTML = data.hourly.temperature_2m[new Date().getHours()] + "°C";
        });
}

const europeCapitals = {
    "Amsterdam": { lat: 52.3667, lng: 4.8945 },
    "Andorra la Vella": { lat: 42.5063, lng: 1.5218 },
    "Athens": { lat: 37.9838, lng: 23.7275 },
    "Belgrade": { lat: 44.7866, lng: 20.4489 },
    "Berlin": { lat: 52.5200, lng: 13.4050 },
    "Bern": { lat: 46.9480, lng: 7.4474 },
    "Bratislava": { lat: 48.1486, lng: 17.1077 },
    "Brussels": { lat: 50.8503, lng: 4.3517 },
    "Bucharest": { lat: 44.4268, lng: 26.1025 },
    "Budapest": { lat: 47.4979, lng: 19.0402 },
    "Copenhagen": { lat: 55.6761, lng: 12.5683 },
    "Dublin": { lat: 53.3498, lng: -6.2603 },
    "Helsinki": { lat: 60.1699, lng: 24.9384 },
    "Kiev": { lat: 50.4501, lng: 30.5234 },
    "Lisbon": { lat: 38.7223, lng: -9.1393 },
    "Ljubljana": { lat: 46.0569, lng: 14.5058 },
    "London": { lat: 51.5074, lng: -0.1278 },
    "Luxembourg": { lat: 49.6116, lng: 6.1319 },
    "Madrid": { lat: 40.4168, lng: -3.7038 },
    "Minsk": { lat: 53.9045, lng: 27.5615 },
    "Monaco": { lat: 43.7325, lng: 7.4189 },
    "Moscow": { lat: 55.7558, lng: 37.6173 },
    "Nicosia": { lat: 35.1856, lng: 33.3823 },
    "Oslo": { lat: 59.9139, lng: 10.7522 },
    "Paris": { lat: 48.8566, lng: 2.3522 },
    "Podgorica": { lat: 42.4304, lng: 19.2594 },
    "Prague": { lat: 50.0755, lng: 14.4378 },
    "Reykjavik": { lat: 64.1466, lng: -21.9426 },
    "Riga": { lat: 56.9496, lng: 24.1052 },
    "Rome": { lat: 41.9028, lng: 12.4964 },
    "San Marino": { lat: 43.9424, lng: 12.4578 },
    "Sarajevo": { lat: 43.9159, lng: 17.6791 },
    "Skopje": { lat: 41.9973, lng: 21.427 },
    "Sofia": { lat: 42.6977, lng: 23.3219 },
    "Stockholm": { lat: 59.3293, lng: 18.0686 },
    "Tallinn": { lat: 59.4369, lng: 24.7536 },
    "Tirana": { lat: 41.3275, lng: 19.8187 },
    "Vaduz": { lat: 47.1410, lng: 9.5215 },
    "Valletta": { lat: 35.9042, lng: 14.5189 },
    "Vatican City": { lat: 41.9029, lng: 12.4534 },
    "Vienna": { lat: 48.2082, lng: 16.3738 },
    "Vilnius": { lat: 54.6872, lng: 25.2797 },
    "Warsaw": { lat: 52.2297, lng: 21.0122 },
    "Zagreb": { lat: 45.8150, lng: 15.9819 }
};

let closed = false;
function activateMenu(menu) {
    menu.classList.toggle("change");
    let sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("active");
    if (closed)
        sidebar.classList.toggle("closed");
    else
        closed = !closed;
}