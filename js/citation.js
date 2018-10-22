$(document).ready(function () {

    $.getJSON("../json/citation.json", function (data) {
        var i = Math.floor(Math.random()*data.liste.length);
        $("#proverbe").append(data.liste[i].citation);
        $("#proverbe").append(data.liste[i].auteur);

    });
});
