

//Success and Error Message Timeout Code Start
setTimeout(function() {
    $('.alertsuccess').slideUp(1000);
},5000);

setTimeout(function() {
    $('.alerterror').slideUp(1000);
},10000);

$(document).ready(function() {
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
});