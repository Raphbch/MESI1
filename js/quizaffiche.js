$(document).ready(function () {
    $('#Valider').click(function () {
        var Score = 0;
        for (var i = 1; i <= $("#nbquestion").val(); i++) {
            $("input[type=radio]").attr('disabled', true);
            $("input[type=button]").hide();
            var rate_value;
            var ReponseTrue = "#ReponseTrue" + i;
            var ReponseSelected = "#reponse" + i + "1";
            var LabelSelected = "#label" + i + "1";


            if ($(ReponseSelected).is(':checked')) {
                rate_value = 1;
            }
            else {
                ReponseSelected = "#reponse" + i + "2";
                LabelSelected = "#label" + i + "2";
                if ($(ReponseSelected).is(':checked')) {
                    rate_value = 2;
                }
                else {
                    ReponseSelected = "#reponse" + i + "3";
                    LabelSelected = "#label" + i + "3";
                    if ($(ReponseSelected).is(':checked')) {
                        rate_value = 3;
                    }
                    else {
                        ReponseSelected = "#reponse" + i + "4";
                        LabelSelected = "#label" + i + "4";
                        if ($(ReponseSelected).is(':checked')) {
                            rate_value = 4;
                        }
                    }
                }
            }
            var LabelTrue = "#label" + i +$(ReponseTrue).val();
            if (rate_value == $(ReponseTrue).val()) {
                $(LabelSelected).addClass("text-success");
                Score = Score + 1;
            }
            else {
                $(LabelSelected).addClass("text-danger");
                $(LabelTrue).addClass("text-success");
            }
        }
                var idquizselected = $("#idquiz").val();
                $.ajax({
                    type: "POST",
                    url: "sendScore.php",
                    data: { idquiz: idquizselected, score: Score }
                }).done(function() {
                    $("#resultaffiche").html("<h2 class='text-center'>Vous avez fait un score de : " +Score+" sur "+$("#nbquestion").val()+"</h2>" +
                        "<br>" +
                        "<a href='profil.php' class='btn btn-info btn-block'><h4 class='text-center'>Retour au profil</h4></a>");

                });
    });
});