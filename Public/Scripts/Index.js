$(document).ready(() => {
    $.post("", {
        "request" : "start",
        "link" : location.pathname,
        "referer" : document.referrer,
    })

    $(".language").on("click", event => {
        $.post("", {
            "request" : "language",
            "language" : $(event.target).attr("language"),
        }).then(response => {
            if(response.includes("true")) document.location.reload()
            else alert("Error")
        }).fail(() => {
            alert("Error")
        })
    })
})