$(document).ready(() => {
    const loadMessages = error => {
        $("#messages-more").addClass("d-none")
        $("#messages-spinner").removeClass("d-none")

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "messages",
                "action" : "getMessages",
                "page" : parseInt($("#messages-page").val()) + 1,
            }).then(response => {
                $("#messages-spinner").addClass("d-none")
                $("#messages-more").removeClass("d-none")

                if(response["status"] == "success" && "messages" in response) {
                    if(response["messages"].length != 10) $("#messages-more").addClass("d-none")
                    if(response["messages"].length != 0) {
                        $("#messages-empty").addClass("d-none")
                        $(".add-py-5").removeClass("pt-5").addClass("py-5")
                        $(".add-pb-5").removeClass("pt-5").addClass("pb-5 pt-md-5")
                    }

                    const last = response["messages"].length - 1

                    response["messages"].forEach((message, id) => {
                        $("#messages-list").append("\
                            " + (id != 0 || $("#messages-page").val() != 0 ? "<div class=\"line\"> </div>" : "") + "\
                            <a class=\"text-decoration-none text-" + ($("html").attr("data-bs-theme") != "dark" ? "dark" : "light") + "\" href=\"" + message["link"] + "\">\
                                <div class=\"row mx-0\">\
                                    <div class=\"col-9 col-md-5 my-auto px-0 p" + (id == 0 && $("#messages-page").val() == 0 ? "b" : (id == last ? "t-5 add-py" : "y")) + "-5\">\
                                        <div class=\"d-flex\">\
                                            <img class=\"my-auto shadow border rounded-circle image-64 ratio-1\" src=\"" + message["sender"] + "\" alt=\"" + message["username"] + "\"/>\
                                            <div class=\"my-auto ps-4 text-start\">\
                                                <p class=\"overflow-hidden mb-0\"> " + $("#messages-by").val() + " " + message["username"] + " </p>\
                                                <p class=\"mb-0\"> " + $("#messages-" + (message["updated"].includes("/") ? "on" : "at")).val() + " " + message["updated"] + " </p>\
                                                <p class=\"mb-0\"> " + message["count"] + " " + $("#messages-messages").val() + " </p>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class=\"order-md-1 col-3 col-md-2 my-auto px-0 p" + (id == 0 && $("#messages-page").val() == 0 ? "b" : (id == last ? "t-5 add-py" : "y")) + "-5 text-end\">\
                                        <div class=\"d-flex flex-column flex-md-row-reverse\">\
                                            <div class=\"my-auto\">\
                                                <input class=\"btn rounded-circle image-48 ratio-1 button-outline user-block\" type=\"image\" src=\"" + $("#messages-block-src").val() + "\" alt=\"" + $("#messages-block-alt").val() + "\" user=\"" + message["hash"] + "\"/>\
                                            </div>\
                                            <div class=\"my-auto me-md-4 mt-4 mt-md-auto\">\
                                                <input class=\"btn rounded-circle image-48 ratio-1 button-outline user-delete\" type=\"image\" src=\"" + $("#messages-delete-src").val() + "\" alt=\"" + $("#messages-delete-alt").val() + "\" user=\"" + message["hash"] + "\"/>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class=\"col-12 col-md-5 my-auto px-0 p" + (id == 0 && $("#messages-page").val() == 0 ? "b" : (id == last ? "t-5 add-pb" : "b-5 pt-md")) + "-5\">\
                                        <p class=\"overflow-hidden mb-0 text-justify fw-bold\"> " + message["message"] + " </p>\
                                    </div>\
                                </div>\
                            </a>\
                        ")
                    })

                    $("#messages-page").val(parseInt($("#messages-page").val()) + 1)

                    $(".user-block").off("click").click(event => {
                        event.preventDefault()

                        const user = $(event.target).attr("user")

                        showAlert("messages-block-ask", null, event => {
                            getToken(token => {
                                $.post("", {
                                    "token" : token,
                                    "request" : "blocks",
                                    "action" : "create",
                                    "user" : user,
                                }).then(response => {
                                    if(response["status"] == "success") showAlert("messages-block-success")
                                    else showAlert("messages-block-error")
                                }).fail(() => {
                                    showAlert("messages-block-error")
                                })
                            })
                        })
                    })

                    $(".user-delete").off("click").click(event => {
                        event.preventDefault()

                        const user = $(event.target).attr("user")

                        showAlert("messages-delete-ask", null, event => {
                            getToken(token => {
                                $.post("", {
                                    "token" : token,
                                    "request" : "messages",
                                    "action" : "deleteByUser",
                                    "user" : user,
                                }).then(response => {
                                    if(response["status"] == "success") {
                                        showAlert("messages-delete-success", event => {
                                            location.reload()
                                        })
                                    } else showAlert("messages-delete-error")
                                }).fail(() => {
                                    showAlert("messages-delete-error")
                                })
                            })
                        })
                    })
                } else showAlert("messages-message-error")
            }).fail(() => {
                $("#messages-spinner").addClass("d-none")
                $("#messages-more").removeClass("d-none")

                showAlert("messages-message-error")
            })
        }, error)
    }

    $("#messages-more").click(event => {
        event.preventDefault()

        loadMessages(true)
    })

    loadMessages(false)
})