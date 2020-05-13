$(document).ready(function () {
    //Al escribr dentro del input con id="service"
    $('#js-userlocations').on('input', function () {
        //Obtenemos el value del input
        var service = $(this).val();
        var dataString = 'service=' + service;

        $.ajax({
            type: "POST",
            // File that does the DB query to fetch results
            url: "query.php",
            data: { service: service },
            success: function (data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#js-suggestions').fadeIn(1000).html(data);
                $('#test').html(data);
                //Al hacer click en alguNa de las sugerencias
                $('#js-suggestions').on('click', '.suggest-element', function () {
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#js-userlocations').val(id);
                    //Hacemos desaparecer el resto de sugerencias
                    $('#js-suggestions').fadeOut(10);
                    //eLIMINAMOS EL VALUE DEL INPUT
                });
            }
        });
    });
});


window.onload = function () {
    document.getElementById("js-addLocation").onclick = function addLocation() {
        var locationValue = document.getElementById('js-userlocations').value;
        var stringtoSplit = locationValue;
        var splitstring = stringtoSplit.split(' - ');
        fetch('addAirport.php', {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            method: "POST",
            body: "airportId=" + splitstring[3]
        })
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                console.log(data)
                var tag = document.createElement("div");
                var icon = document.getElementById('deleteicon').innerHTML;
                var deleteicon = document.getElementById('deleteicon').innerHTML;


                tag.setAttribute("class", "airportBadge");
                tag.setAttribute("id", splitstring[3]);
                document.getElementById("js-locations").appendChild(tag);
                tag.innerHTML = '<div class="airportBadge__header">' + splitstring[2] + '</div><div class="airportBadge__cityname">' + splitstring[0] + '</div><p class="airportBadge__description">' + splitstring[1] + '</p><div class="airportBadge__actions"><span onclick="deleteField(this.id);" class="airportBadge__delete"  id="' + splitstring[3] + '">' + icon + '<span class="hide-sr">Remove</span></span></div></div>';
                //  ' + splitstring[1] + '<span class="airportBadge__city--iata">' + splitstring[2] + '</span></span></div><div class="airportBadge__action"><span role="button" onclick="deleteField(this.id);" class="airportBadge__delete" id="' + splitstring[2] + '"><span class="hide-sr">Delete</span>' + deleteicon + '</span></div></div>';

                //  ' + splitstring[1] + '<span class="airportBadge__city--iata">' + splitstring[2] + '</span></span></div><div class="airportBadge__action"><span role="button" onclick="deleteField(this.id);" class="airportBadge__delete" id="' + splitstring[2] + '"><span class="hide-sr">Delete</span>' + deleteicon + '</span></div></div>';


                // Create hidden input
                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", "iata[]");
                input.setAttribute("value", splitstring[3]);
                document.getElementById("js-locations").appendChild(input);

            }).catch(function (error) {
                console.log('Error: ' + error);
            });
        // Clear the input
        document.getElementById("js-userlocations").value = "";
    }
}


function deleteField(buttonID) {
    var elem = document.getElementById(buttonID);
    var airportId = buttonID;
    fetch('/user/airport_selection/removeAirport.php', {
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        method: "POST",
        body: "airportId=" + airportId
    }).then(function (response) {
        return response.text();
    })
        .then(function (data) {
        })

    elem.parentNode.parentNode.remove();
    return false;
}