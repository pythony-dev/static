$(document).ready(() => {
    if(window.matchMedia && window.matchMedia("(prefers-color-scheme : dark)").matches != ($("html").attr("data-bs-theme") == "dark")) {
        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "settings",
                "action" : "theme",
                "mode" : window.matchMedia("(prefers-color-scheme : dark)").matches ? "dark" : "light",
            }).then(response => {
                if(response["status"] == "success" && !("serviceWorker" in navigator && !navigator.serviceWorker.controller)) location.reload()
            })
        }, false)
    }

    if("serviceWorker" in navigator && !navigator.serviceWorker.controller) navigator.serviceWorker.register($("html").attr("link") + "/Worker.js").then(() => navigator.serviceWorker.ready.then(() => location.reload()))

    $(".language").click(event => {
        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "settings",
                "action" : "language",
                "language" : $(event.target).attr("language"),
            }).then(response => {
                if(response["status"] == "success") location.reload()
                else showAlert("index-language")
            }).fail(() => {
                showAlert("index-language")
            })
        })
    })

    $(".theme").click(event => {
        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "settings",
                "action" : "theme",
                "color" : $(event.target).attr("theme"),
            }).then(response => {
                if(response["status"] == "success") location.reload()
                else showAlert("index-theme")
            }).fail(() => {
                showAlert("index-theme")
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

    $(".alert-close").click(event => $("#alert-" + $(event.target).attr("alert")).modal("hide"))

    $(".open").modal("show").addClass("fade")
})

const getToken = (callback, error = true) => {
    $.post("", {
        "request" : "tokens",
        "action" : "create",
    }).then(response => {
        if(response["status"] == "success" && "token" in response && typeof(callback) == "function") callback(response["token"].toString())
        else if(error) showAlert("index-token")
    }).fail(() => {
        if(error) showAlert("index-token")
    })
}

const showAlert = (id, closed = null, confirmed = null) => {
    $("#alert-" + id).modal("show")
    $("#alert-" + id).off("hide.bs.modal")
    $("#alert-" + id + " .confirm").off("click")

    if(typeof(closed) == "function") $("#alert-" + id).on("hide.bs.modal", closed)

    if(typeof(confirmed) == "function") {
        $("#alert-" + id + " .alert-yes").click(event => {
            $("#alert-" + id).modal("hide")

            confirmed(event)
        })
    }
}

const uploadImage = (folder, file, success, done) => {
    getToken(token => {
        const formData = new FormData()
        formData.append("token", token)
        formData.append("request", "images")
        formData.append("action", "upload")
        formData.append("folder", folder)
        formData.append("image", $(file)[0].files[0])

        $.ajax({
            type : "POST",
            url : "",
            data : formData,
            processData : false,
            contentType : false,
        }).done(response => {
            if(typeof(done) == "function") done()

            if("error" in response) {
                if(response["error"] == "extension") showAlert("upload-extension")
                else if(response["error"] == "type") showAlert("upload-type")
                else if(response["error"] == "size") showAlert("upload-size")
                else showAlert("upload-error")
            } else if(response["status"] == "success") {
                showAlert("upload-success", event => {
                    if(typeof(success) == "function") success(response)
                })
            } else showAlert("upload-error")
        }).fail(() => {
            showAlert("upload-error")

            if(typeof(done) == "function") done()
        })
    })
}