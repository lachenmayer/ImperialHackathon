/* Author: 

 */

var Foodie = (function () {

    var getPurchasesByCID = function (cid) {
        $.get("http://129.31.217.212/hthon/main/?type=cid&id=" + cid + "&latest=30",
            function (response) {
                console.log(response);
                return JSON.parse(response);
            });
    }

    return {
        testPurchases: function () {
            return getPurchasesByCID(691254);
        }
    }
})();

$(function () {

    var dailyBreakdownData = [
        [0, 2.34],
        [1, 5.14],
        [2, 3.31],
        [3, 6.24],
        [4, 2.54]
    ];

    var dailyBreakdownDays = [
        [
            [0, 2.34]
        ],
        [
            [1, 5.14]
        ],
        [
            [2, 3.31]
        ],
        [
            [3, 6.24]
        ],
        [
            [4, 2.54]
        ]
    ];

    var seperateDays = new Array();
    var dayColors = ["#000000", "#F24949", "#89E0FA", "#FFEC73", "#73C75A"];
    for(var i = 0; i < dailyBreakdownDays.length; i++){
        var series = {
            data: dailyBreakdownDays[i],
            lines: {
                show: false
            },
            shadowSize: 0,
            color: dayColors[i],
            points: {
                show: true,
                radius: 5,
                lineWidth: 4
            }
        }
        seperateDays.push(series);
    }

    var dailyBreakdownSeries = {
        data: dailyBreakdownData,
        lines: {
            show: true,
            lineWidth: 5
        },
        shadowSize: 0,
        color: "rgb(160, 160, 160)",
        clickable: true,
        hoverable: true,
        points: {
            show: false,
            radius: 5
        }
    }

    seperateDays.unshift(dailyBreakdownSeries);

    var options = {
        legend: {
            show: false
        },
        xaxis: {
            show: false
        },
        yaxis: {
            show: false
        },
        grid: {
            borderWidth: 0
        }
    };

    console.log(seperateDays);

    $.plot($("#graph"), seperateDays, options);

    $("graph").bind("plothover", function (event, pos, item) {
        console.log([event, pos, item]);
    });

});
