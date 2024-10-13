$(document).ready(() => {
    const tests = $("html").attr("tests")

    if(tests != undefined && tests.includes("[") && tests.includes("]")) localStorage.setItem("tests", tests.replaceAll("'", "\""))

    const start = () => {
        let tests = localStorage.getItem("tests")

        if(tests == undefined || !tests.includes("[") || !tests.includes("]")) {
            return showAlert("index-tests-error", event => {
                localStorage.removeItem("tests")

                location.replace($("html").attr("link") + "/tests")
            })
        }

        tests = JSON.parse(tests)

        const test = tests.shift()

        tests = JSON.stringify(tests)

        if(test == undefined) {
            return showAlert("index-tests-success", event => {
                localStorage.removeItem("tests")

                location.replace($("html").attr("link") + "/tests")
            })
        } else if(test.length == 2 && test[0] == "follow" && $(test[1]).length == 1 && $(test[1]).attr("href") != undefined) {
            localStorage.setItem("tests", tests)

            location.replace($(test[1]).attr("href"))
        } else if(test.length == 2 && test[0] == "click" && $(test[1]).length == 1) {
            localStorage.setItem("tests", tests)

            $(test[1]).click()
        } else if(test.length == 2 && test[0] == "continue" && $(test[1]).length == 1) {
            localStorage.setItem("tests", tests)

            $(test[1]).click()

            start()
        } else if(test.length == 2 && test[0] == "check" && $(test[1]).length == 1) {
            $(test[1]).attr("checked", "true")

            localStorage.setItem("tests", tests)

            start()
        } else if(test.length == 2 && test[0] == "wait" && $(test[1]).length == 1) {
            $(test[1]).addClass("is-invalid").blur(event => {
                $(test[1]).removeClass("is-invalid").off("blur")

                localStorage.setItem("tests", tests)

                start()
            })
        } else if(test.length == 3 && test[0] == "value" && $(test[1]).length == 1 && test[2] != "") {
            localStorage.setItem("tests", tests)

            $(test[1]).val(test[2]).trigger("input")

            start()
        } else if(test.length == 4 && test[0] == "modal" && $(test[1]).length == 1 && $(test[2]).length == 1 && $(test[3]).length == 1) {
            $(test[2]).click()
            $(test[1]).on("shown.bs.modal", () => {
                $(test[1]).off("shown.bs.modal")

                localStorage.setItem("tests", tests)

                $(test[3]).click()
                $(test[1]).on("hidden.bs.modal", () => {
                    $(test[1]).off("hidden.bs.modal")

                    start()
                })
            })           
        } else {
            return showAlert("index-tests-error", event => {
                localStorage.removeItem("tests")

                location.replace($("html").attr("link") + "/tests")
            })
        }
    }

    setTimeout(start, 250)
})