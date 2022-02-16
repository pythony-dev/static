$(document).ready(() => {
    $.post("", {
        "request" : "start",
        "action" : "create",
        "link" : location.pathname,
        "referer" : document.referrer,
    })

    $(".language").click(event => {
        $.post("", {
            "request" : "language",
            "action" : "update",
            "language" : $(event.target).attr("language"),
        }).then(response => {
            if(JSON.parse(response)["status"] == "success") location.reload()
            else alert("Error")
        }).fail(() => {
            alert("Error")
        })
    })

    $("#logOut").click(event => {
        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "logOut",
            }).then(response => {
                if(JSON.parse(response)["status"] == "success") location.reload()
                else alert("Error")
            }).fail(() => {
                alert("Error")
            })
        })
    })
})

const getToken = (callback) => {
    $.post("", {
        "request" : "tokens",
        "action" : "create",
    }).then(response => {
        callback(JSON.parse(response)["token"])
    }).fail(() => {
        alert("Error")
    })
}