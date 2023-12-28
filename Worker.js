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
    }))
})