
var url = 'endpoint_text.php';
//var url = 'https://wdev2.be/steven21/rest/server/1_get_text/endpoint_text.php';

fetch(url)
    .then(function(response) {
        return response.text();
    })
    .then(function(text) {
        document.querySelector('#divResponse').innerText = text;
    });
