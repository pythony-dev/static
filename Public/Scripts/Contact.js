$(document).ready(() => {
    $("#contact-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "contact",
                "action" : "create",
                "email" : $("#contact-email").val(),
                "message" : $("#contact-message").val(),
            }).then(response => {
                if(JSON.parse(response)["status"] == "success") {
                    alert("Thanks !")

                    location.reload()
                } else alert("Error")
            }).fail(() => {
                alert("Error")
            })
        })
    })
})