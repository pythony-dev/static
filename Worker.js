const settings = {
    "name" : "Static",
    "link" : "https://www.pythony.dev/Static",
}

self.addEventListener("install", event => {
    caches.open(settings["name"].toString()).then(cache => cache.add(settings["link"].toString() + "/error/418?error=false"))
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