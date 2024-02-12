let settings = undefined

self.addEventListener("message", message => {
    if(!("name" in message["data"]) || !("link" in message["data"]) || !Array.isArray(message["data"]["links"])) return

    caches.open(message["data"]["name"].toString()).then(cache => {
        settings = {
            "name" : message["data"]["name"].toString(),
            "link" : message["data"]["link"].toString(),
        }

        message["data"]["links"].forEach((element, index) => setTimeout(() => cache.add(element.toString()), index * 250 + 1000))
    })
})

self.addEventListener("fetch", event => {
    if(settings == undefined) return

    event.respondWith(fetch(event.request).then(async response => {
        if(event.request.method == "GET") await caches.open(settings["name"].toString()).then(cache => cache.put(event.request, response.clone()))

        return response
    }).catch(() => caches.open(settings["name"].toString()).then(cache => cache.match(event.request, {"ignoreSearch" : "true"}).then(response => {
        if(response) return response
        else if(event.request.url.includes("/Public/Images/Home/")) return cache.match(settings["link"].toString() + "/Public/Images/Home/Light/Default.png")
        else if(event.request.url.includes("/Public/Images/Features/")) return cache.match(settings["link"].toString() + "/Public/Images/Features/2fbd464942d68bf4bc77cb2d2ef3fb70b7730428.jpeg")
        else if(event.request.url.includes("/Public/Images/Articles/")) return cache.match(settings["link"].toString() + "/Public/Images/Articles/e53bbba3d6879b89f45b5f59e66ab3d4fb2a8c63.jpeg")
        else if(event.request.url.includes("/Public/Images/Users/")) return cache.match(settings["link"].toString() + "/Public/Images/Users/6fd5a5099276104d4967fd86082cddc35791d40c.jpeg")
        else if(event.request.url.includes("/Public/Images/Posts/")) return cache.match(settings["link"].toString() + "/Public/Images/Posts/ff7af0dac1a65164a1799a5b5222eec311241b71.jpeg")
        else if(event.request.url.includes("/Public/Images/Messages/")) return cache.match(settings["link"].toString() + "/Public/Images/Messages/4372787e09f273bc07e1c239e6dbdac14c7b75bb.jpeg")
        else return cache.match(settings["link"].toString() + "/error/404?error=false")
    }))))
})