$(document).ready(() => {
    $("#contact-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "contact",
                "email" : $("#contact-email").val(),
                "message" : $("#contact-message").val(),
            }).then(response => {
                if(response.includes("true")) {
                    alert("Thanks !")

                    location.reload()
                } else alert("Error")
            }).fail(() => {
                alert("Error")
            })
        })
    })
})