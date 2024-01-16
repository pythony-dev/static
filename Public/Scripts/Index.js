$(document).ready(() => {
    if("serviceWorker" in navigator && !navigator.serviceWorker.controller) {
        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "siteMap",
                "action" : "fetch",
            }).then(response => {
                if(response["status"] == "success" && "name" in response && "link" in response && "links" in response) {
                    navigator.serviceWorker.register(response["link"].toString() + "/Worker.js").then(() => {
                        navigator.serviceWorker.ready.then(async serviceWorker => {
                            await serviceWorker.active.postMessage({
                                "name" : response["name"].toString(),
                                "link" : response["link"].toString(),
                                "links" : response["links"],
                            })

                            location.reload()
                        })
                    })
                }
            })
        }, false)
    }

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
                "theme" : $(event.target).attr("theme"),
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
    id += "-alert"
    $("#" + id).modal("show")
    $("#" + id).off("hide.bs.modal")
    $("#" + id + " .confirm").off("click")

    if(typeof(closed) == "function") $("#" + id).on("hide.bs.modal", closed)

    if(typeof(confirmed) == "function") {
        $("#" + id + " .confirm").click(event => {
            $("#" + id).modal("hide")

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