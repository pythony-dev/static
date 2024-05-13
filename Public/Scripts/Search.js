$(document).ready(() => {
    $("#search-username").on("input", event => {
        event.preventDefault()

        $("#search-list").addClass("d-none").empty()
        $("#search-empty").addClass("d-none")
        $("#search-spinner").removeClass("d-none")

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "search",
                "search" : $("#search-username").val(),
            }).then(response => {
                $("#search-list").addClass("d-none").empty()
                $("#search-empty").addClass("d-none")
                $("#search-spinner").addClass("d-none")

                if(response["status"] == "success" && "users" in response) {
                    if(response["users"].length != 0) $("#search-list").removeClass("d-none")
                    else $("#search-empty").removeClass("d-none")

                    response["users"].forEach((user, id) => {
                        $("#search-list").append("\
                            " + (id != 0 ? "<div class=\"line\"> </div>" : "") + "\
                            <div class=\"d-flex justify-content-between py-4\">\
                                <div class=\"d-flex\">\
                                    <img class=\"my-auto shadow border rounded-circle image-64 ratio-1\" src=\"" + user["image"] + "\" alt=\"" + user["username"] + "\"/>\
                                    <div class=\"my-auto ps-4\">\
                                        <p class=\"mb-0\"> " + user["username"] + " </p>\
                                    </div>\
                                </div>\
                                <div class=\"d-flex flex-column flex-md-row-reverse\">\
                                    <div class=\"my-auto\">\
                                        <input class=\"btn rounded-circle image-48 ratio-1 button-outline user-block\" type=\"image\" src=\"" + $("html").attr("link") + "/Public/Images/Icons/" + ($("html").attr("data-bs-theme") != "dark" ? "Light" : "Dark") + "/Block.png\" alt=\"" + $("#search-block").val() + "\" user=\"" + user["hash"] + "\"/>\
                                    </div>\
                                    " + (user["chat"] ? "\
                                        <a class=\"my-auto me-md-4 mt-4 mt-md-auto\" href=\"" + user["chat"] + "\">\
                                            <input class=\"btn rounded-circle image-48 ratio-1 button-outline\" type=\"image\" src=\"" + $("html").attr("link") + "/Public/Images/Icons/" + ($("html").attr("data-bs-theme") != "dark" ? "Light" : "Dark") + "/Chat.png\" alt=\"" + $("#search-chat").val() + "\"/>\
                                        </a>\
                                    " : "") + "\
                                </div>\
                            </div>\
                        ")
                    })

                    $(".user-block").off("click").click(event => {
                        event.preventDefault()

                        const user = $(event.target).attr("user")

                        showAlert("search-block-ask", null, event => {
                            getToken(token => {
                                $.post("", {
                                    "token" : token,
                                    "request" : "blocks",
                                    "action" : "create",
                                    "user" : user,
                                }).then(response => {
                                    if(response["status"] == "success") showAlert("search-block-success")
                                    else showAlert("search-block-error")
                                }).fail(() => {
                                    showAlert("search-block-error")
                                })
                            })
                        })
                    })
                } else if($("#search-username").val() != "") showAlert("search-search-error")
            }).fail(() => {
                $("#search-spinner").addClass("d-none")

                showAlert("search-search-error")
            })
        }, false)
    })
})