function progressTimer(){
    var bar = $("#time-bar");
    var start = new Date();
    var limit = 180000;
    var totalSec;
    bar.width(100+ "%");
    bar.removeClass("progress-bar-danger")
       .removeClass("progress-bar-warning")
       .addClass("progress-bar-info");

    var interval = window.setInterval(function () {
        setTimeout(function(){ // to wait for the bar to fill up initially
            var elapsed = new Date() - start;
            bar.width((((limit-elapsed) / limit) * 100) + "%");
            
            totalSec = (limit-elapsed) / 1000;
            var minutes = parseInt( totalSec / 60 ) % 60;
            var seconds = Math.ceil(totalSec % 60);

            if (minutes)
                var result = (minutes < 10 ? "0" + minutes : minutes) + " mins " + (seconds  < 10 ? "0" + seconds+" secs" : seconds+" secs");
            else
                var result = (seconds  < 10 ? "0" + seconds+" secs" : seconds+" secs");

            if (seconds>=0)
                if (minutes == 0 && seconds<21)
                    bar.html(result);
                else
                    bar.html("Time left : "+result);
            else
                bar.html();

            if (limit - elapsed <= 30000)
                bar.removeClass("progress-bar-info")
                   .addClass("progress-bar-warning");

            if (limit - elapsed <= 10000)
                bar.removeClass("progress-bar-info")
                   .removeClass("progress-bar-warning")
                   .addClass("progress-bar-danger");

            if (elapsed >= limit) {
                window.clearInterval(interval);
            }
        },700);
    }, 50);
}

function ClearAllIntervals() {
    for (var i = 1; i < 99999; i++)
        window.clearInterval(i);
}