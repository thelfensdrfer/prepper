    var Ziggy = {
        namedRoutes: {"landing":{"uri":"\/","methods":["GET","HEAD"],"domain":null},"login":{"uri":"login","methods":["GET","HEAD"],"domain":null},"logout":{"uri":"logout","methods":["POST"],"domain":null},"register":{"uri":"register","methods":["GET","HEAD"],"domain":null},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"],"domain":null},"password.email":{"uri":"password\/email","methods":["POST"],"domain":null},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"],"domain":null},"password.update":{"uri":"password\/reset","methods":["POST"],"domain":null},"password.confirm":{"uri":"password\/confirm","methods":["GET","HEAD"],"domain":null},"food.index":{"uri":"food","methods":["GET","HEAD"],"domain":null},"checklist.index":{"uri":"checklists","methods":["GET","HEAD"],"domain":null},"account.show":{"uri":"account","methods":["GET","HEAD"],"domain":null},"account.update":{"uri":"account\/personal","methods":["PUT"],"domain":null},"account.password":{"uri":"account\/password","methods":["PUT"],"domain":null},"account.reminder":{"uri":"account\/reminder","methods":["PUT"],"domain":null},"food.store":{"uri":"food\/{food_group}","methods":["POST"],"domain":null},"food.update":{"uri":"food\/{food}","methods":["PUT"],"domain":null},"food.delete":{"uri":"food\/{food}","methods":["DELETE"],"domain":null},"foodplan.update":{"uri":"foodplan\/{food_group}","methods":["PUT"],"domain":null},"checklist.store":{"uri":"checklists","methods":["POST"],"domain":null},"checklist.update":{"uri":"checklists\/{checklist}","methods":["PUT"],"domain":null},"checklist.item.store":{"uri":"checklist\/{checklist}\/item","methods":["POST"],"domain":null},"checklist.item.update":{"uri":"checklist\/item\/{item}","methods":["PUT"],"domain":null},"checklist.item.delete":{"uri":"checklist\/item\/{item}","methods":["DELETE"],"domain":null}},
        baseUrl: 'http://prepper.localhost:8080/',
        baseProtocol: 'http',
        baseDomain: 'prepper.localhost',
        basePort: 8080,
        defaultParameters: []
    };

    if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }
