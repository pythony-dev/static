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
        if(response["status"] == "success" && "token" in response && typeof(callback) == "function") callback(response["token"])
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

            if(response["status"] == "userID") showAlert("upload-userID")
            else if(response["status"] == "extension") showAlert("upload-extension")
            else if(response["status"] == "type") showAlert("upload-type")
            else if(response["status"] == "size") showAlert("upload-size")
            else if(response["status"] == "image") showAlert("upload-image")
            else if(response["status"] == "success") {
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