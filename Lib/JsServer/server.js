var WebSocketServer = require('websocket').server;
var http = require('http');


function start(route, handle) {

    var httpServer = http.createServer(function (request, response) {

        route(handle, request, response, connections);
    });


    port = process.argv[2];
    console.log(port);

    httpServer.listen(port != undefined ? port : 8899, function () {
        console.log((new Date()) + ' Websocket is listening on port 8899');
    });


    var wsServer = new WebSocketServer({
        httpServer:httpServer,
        autoAccceptConnections:false
    });

    function originIsAllowed(origin) {
        return true;
    }

    var connections = new Array();
    wsServer.on('request', function (request) {
        if (!originIsAllowed(request.origin)) {
            request.reject();

            return;
        }

        var connection = request.accept("muffin-protocol", request.origin);


        connection.on('message', function (message) {

            var session_id = JSON.parse(message.utf8Data).identification;
            if (!(session_id in connections) || !(connection in connections[session_id])) {
                if (!(session_id in connections)) {
                    connections[session_id] = new Array();
                }
                //console.log("New session : " + session_id);
                connections[session_id].push(connection);
            }

            for (k in connections) {
                // console.log(k + " : " + connections[k]);
            }
        });

        connection.on('close', function (message) {
            console.log("---------------------------------------");
            connectionsb = new Array();

            for (key in connections) {
                con2 = new Array();
                console.log(key + " : " + connections[key]);
                for (k in  connections[key]) {
                    if (connections[key][k] == connection) {
                        connections[key].splice(k, 1);
                    }
                }
                console.log(key + " : " + connections[key]);
                if (connections[key].length == 0) {
                    delete connections[key];
                }

            }

        });
    });
}

exports.start = start;