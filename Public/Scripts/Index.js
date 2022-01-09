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
        $.post("", {
            "request" : "users",
            "action" : "logOut"
        }).then(response => {
            if(response.includes("true")) location.reload()
            else alert("Error")
        }).fail(() => {
            alert("Error")
        })
    })
})