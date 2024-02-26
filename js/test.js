const form = document.getElementById('weatherForm');

form.addEventListener('submit', (event) => {

    // Call the weather api (https://rapidapi.com/weatherapi/api/weatherapi-com)
    event.preventDefault();
    const locationInput = form.elements['locationInput'];
    let location = locationInput.value;
    $.ajax({
        url: 'https://weatherapi-com.p.rapidapi.com/forecast.json?q=' + location + '&days=3',
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': apiKey,
            'X-RapidAPI-Host': 'weatherapi-com.p.rapidapi.com'
        },
        success: function(response) {
            // Process Data
            console.log(response);
            id = response['location']['lat'].toString() + response['location']['lon'].toString();
            
            // Add the location to the list if it has not been added already
            if (!$("#" + id.replace( /(\.)/g, "\\$1" )).length) {
                $('#repeatCityMessage').hide();

                let location = response['location'];
                let current = response['current'];

                currentCityHtml = '<li class="city" id="' + id + '">';

                // Add html for the current location and weather
                currentWeatherHtml = '<div class="currentWeather">';
                currentWeatherHtml += '<p class="cityName">' + location['name'] + '</p>';
                currentWeatherHtml += '<p class="regionName">' + location['region'] + '</p>';
                currentWeatherHtml += '<p class="temperature">' + current['temp_c'] + '°C</p>';
                currentWeatherHtml += '<img class="conditionImg" src="https://' + current['condition']['icon'] + '">';
                currentWeatherHtml += '<p class="conditionText">' + current['condition']['text'] + '</p>';
                currentWeatherHtml += '</div>';

                let forecast = response['forecast']['forecastday'];

                // Add html for the hourly forecast
                hourlyForecastHtml = '<div id="hourlyForecast">';
                hourlyForecastHtml += '<p id="hourlyForecastTitle">Hourly Forecast</p>';
                hourlyForecastHtml += '<div id="hourlyForecastData">';
                for (let i = 0; i < 24; i++) {
                    let time = i + ':00';
                    hourHtml = '<div class="hourObject">';
                    hourHtml += '<p class="hour">' + time + '</p>';
                    hourHtml += '<img class="hourlyForecastImg" src="https://' + forecast[0]['hour'][i]['condition']['icon']  + '">';
                    hourHtml += '<p class="hourlyTemperature">' + forecast[0]['hour'][i]['temp_c'] + '°C</p>';
                    hourHtml += '</div>';

                    hourlyForecastHtml += hourHtml;
                }
                hourlyForecastHtml += '</div></div>';

                let daysOfTheWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

                // Add html for daily forecast (3 days)
                threeDayForecastHtml = '<div id="threeDayForecast">';
                threeDayForecastHtml += '<p id="threeDayForecastTitle">Three Day Forecast</p>';
                threeDayForecastHtml += '<div id="threeDayForecastData">';
                for (let i = 0; i < 3; i++) {
                    // Multiply by 1000 because Date takes epoch in terms of milliseconds
                    let date = new Date(forecast[i]['date']);
                    let readableDay = daysOfTheWeek[date.getUTCDay()];
                    dayHtml = '<div class="dayObject">';
                    dayHtml += '<div class="dayText">' + readableDay + '</div>';
                    dayHtml += '<div class="weatherImage"><img class="threeDayForecastImg" src="https://' + forecast[i]['day']['condition']['icon']  + '"></div>';
                    dayHtml += '<div class="rangeText">' + forecast[i]['day']['mintemp_c'] + '°C to ' + forecast[i]['day']['maxtemp_c'] + '°C</div>';
                    dayHtml += '</div>';

                    threeDayForecastHtml += dayHtml;
                }
                threeDayForecastHtml += '</div></div>';

                currentCityHtml += currentWeatherHtml + hourlyForecastHtml + threeDayForecastHtml;
                currentCityHtml += '<button class="deleteButton" onclick="deleteLocation(this)">Delete</button>';
                currentCityHtml += '</li>';
                $('#cities').append(currentCityHtml);
                
            } else {
                $('#repeatCityMessage').show();
            }

        },
        error: function(xhr, status, error) {
            // Handle errors for the weather api
            alert('Something went wrong. Try refreshing the page.');
        }
    });
});


function deleteLocation(elem) {
    document.getElementById(elem.parentNode.id).remove();
}