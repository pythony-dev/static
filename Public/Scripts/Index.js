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
            if(response["status"] == "success") location.reload()
            else alert($("#index-alert-language").val())
        }).fail(() => {
            alert($("#index-alert-language").val())
        })
    })

    $("#logOut").click(event => {
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

const getToken = (callback) => {
    $.post("", {
        "request" : "tokens",
        "action" : "create",
    }).then(response => {
        if("token" in response) callback(response["token"])
        else alert($("#index-alert-token").val())
    }).fail(() => {
        alert($("#index-alert-token").val())
    })
}