
function login() {
    
    var username = $("#usernameInput").val();
    var password = $("#passwordInput").val();
    
    $("#pwFormGroup").removeClass("has-error");
    $("#unFormGroup").removeClass("has-error");
    $("#pwMsg").text("");
    
    $.post(
        "Identity/Login", 
        { username : username, password : password }, 
        function (response) {
            var status = JSON.parse(response).status;
            
            if (status === 200) {
                window.location.reload(true);
            }

            if(status === 400){
                $("#pwFormGroup").addClass("has-error");
                $("#unFormGroup").addClass("has-error");
                $("#pwMsg").text("Username ou password erradas.");
            }

            if(status === 500){
                $("#pwFormGroup").addClass('has-error');
                $("#unFormGroup").addClass('has-error');
                $("#pwMsg").text("Ocorreu um erro, por favor tente mais tarde.");
            }
        }
    );
}

function logout() {
    $.post("Identity/logout")
        .done(function() {
            window.location.reload(true);
        })
        .fail(function() {
            $.notify("Ocorreu um erro.", "error");
        });
    
}
var doc;
var a;
var newTable;
function getNotificacoes()
{
    $.get("Notificacoes/GetNotificationsPage")
        .done(function(response) {
            var resp = JSON.parse(response);
            
            if (resp.status === 200) {
                var parser = new DOMParser();
                a = parser.parseFromString(resp.response, "text/xml");
                doc = resp.response;

                //$(doc).find("#ctl00_ctl00_Conteudo_cpHabilus_dgNotificacoes > tbody > tr").each(function(tr) { tr.innerHTML })

                newTable = '<table class="table">';
                var rows = $(doc).find("#ctl00_ctl00_Conteudo_cpHabilus_dgNotificacoes > tbody > tr");
                for (var index = 0; index < rows.length; index++) 
                {
                    if (index === 0) 
                        newTable += "<thead><th>";
                    else
                        newTable += "<tr>";
                    
                    newTable += rows[index].innerHTML;

                    if (index === 0) 
                        newTable += "</thead></th>";
                    else
                        newTable += "</tr>";
                    
                }

                newTable += "</table>";

                $("#notifBody").html(newTable);
                console.log("a")
                
            }
            else{
                $.notify("Ocorreu um erro.", "error");
            }
        })
        .fail(function() {
            $.notify("Ocorreu um erro.", "error");
        });
}

