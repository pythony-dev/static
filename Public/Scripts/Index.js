$(document).ready(() => {
    $.post("", {
        "request" : "start",
        "link" : location.pathname,
        "referer" : document.referrer,
    })

    $(".language").click(event => {
        $.post("", {
            "request" : "language",
            "language" : $(event.target).attr("language"),
        }).then(response => {
            if(response.includes("true")) location.reload()
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
                if(response.includes("true")) location.reload()
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
    }).then(response => {
        callback(response)
    }).fail(() => {
        alert("Error")
    })
}