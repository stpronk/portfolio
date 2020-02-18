require('./bootstrap');

function createElement (data, $tag = 'div') {
  const div = document.createElement($tag);
  div.classList.add( 'city-block');
  // var wtemp = document.getElementsByClassName("temp_display");
  // var weather = document.getElementsByClassName("weather_display");
  // var location = document.getElementsByClassName("location_display");

  var city = "<h2 class='heading_scnd'>" + data.name + "</h2>";
  var temp = "<h2 class='heading_scnd'> temperture: " + data.main.temp + "°C" + "</h2>";
  var loc = "<p class='paragraph'> coordinaten: " + data.coord.lat + ", " + data.coord.lon + "</p>";

  div.innerHTML += temp;
  div.innerHTML += city;
  div.innerHTML += loc;

  return div;
}

function replaceCurrent (element) {

  element.classList.add('.other_class');


  return document.querySelector('.current').replaceWith(element)
}


function fetch () {
  const url = 'fehiwygbfj ghtyesbf';
  fetchAll(url, true);
}


function fetchAll(url, current = false) {
  fetch(url)
    .then(function (response) {
      if (response.ok) {
        response.json().then(function (data) {

          const div = createElement(data);

          if (current) {
            return replaceCurrent(div);
          }

          return renderElement(div);
        });
      } else {
        console.log("response failed");
      }
    });
}
