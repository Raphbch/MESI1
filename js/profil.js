$(document).ready(function(){
    $('.Refuser').click(function() {
        var idquizselected = $(this).val();
        $.ajax({
            type: "POST",
            url: "supprimerquiz.php",
            data: { idquiz: idquizselected }
        }).done(function() {
            location.reload();
        });
    });

    $('.Valider').click(function() {
        var idquizselected = $(this).val();
        $.ajax({
            type: "POST",
            url: "validatequiz.php",
            data: { idquiz: idquizselected }
        }).done(function() {
            location.reload();
        });
    });
});

