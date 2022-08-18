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
                else showAlert("index-language")
            }).fail(() => {
                showAlert("index-language")
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
                else showAlert("index-logOut")
            }).fail(() => {
                showAlert("index-logOut")
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
        else showAlert("index-token")
    }).fail(() => {
        showAlert("index-token")
    })
}

const showAlert = (id, closed = null, confirmed = null) => {
    id += "-alert"
    $("#" + id).modal("show")
    $("#" + id).off("hide.bs.modal")
    $("#" + id + " .confirm").off("click")

    if(typeof(closed) == "function") $("#" + id).on("hide.bs.modal", closed)

    if(typeof(confirmed) == "function") {
        $("#" + id + " .confirm").on("click", event => {
            $("#" + id).modal("hide")

            confirmed(event)
        })
    }
}
