const settings = {
    "name" : "Static",
    "link" : "https://www.pythony.dev/Static",
    "links" : [
        "/manifest",
        "/error/418?error=false",
    ],
}

self.addEventListener("install", event => {
    caches.open(settings["name"].toString()).then(cache => settings["links"].forEach((element, index) => setTimeout(() => cache.add(settings["link"].toString() + element.toString()), index * 1000 + 1000)))
})

self.addEventListener("fetch", event => {
    event.respondWith(fetch(event.request).then(async response => {
        if(event.request.method == "GET") await caches.open(settings["name"].toString()).then(cache => cache.put(event.request, response.clone()))

        return response
    }).catch(() => caches.open(settings["name"].toString()).then(cache => cache.match(event.request, {"ignoreSearch" : "true"}).then(response => {
        if(response) return response
        else if(event.request.method == "POST") return new Response(JSON.stringify({"status" : "error"}))
        else return cache.match(settings["link"].toString() + "/error/418?error=false")
    }))))
})