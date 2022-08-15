$(document).ready(() => {
    $(".language").click(event => {
        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "language",
                "action" : "update",
                "language" : $(event.target).attr("language"),
            }).then(response => {
                if(response["status"] == "success") location.reload()
                else alert($("#index-alert-language").val())
            }).fail(() => {
                alert($("#index-alert-language").val())
            })
        })
    })

    $("#navbar-logOut, #settings-logOut").click(event => {
        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "logOut",
            }).then(response => {
                if(response["status"] == "success") location.reload()
                else alert($("#index-alert-logOut").val())
            }).fail(() => {
                alert($("#index-alert-logOut").val())
            })
        })
    })
})

const getToken = callback => {
    $.post("", {
        "request" : "tokens",
        "action" : "create",
    }).then(response => {
        if(response["status"] == "success" && "token" in response) callback(response["token"])
        else alert($("#index-alert-token").val())
    }).fail(() => {
        alert($("#index-alert-token").val())
    })
}