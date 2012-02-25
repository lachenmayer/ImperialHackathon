/* Author: 

*/

var Foodie = (function() {

  var getPurchasesByCID = function(cid) {
    $.get("http://129.31.217.212/hthon/main/?type=cid&id=" + cid + "&latest=30",
    function(response) {
      console.log(response);
      return JSON.parse(response);
    });
  }
  
  return {
    testPurchases: function() {
      return getPurchasesByCID(691254);
    }
  }
})();

$(function() {
  
  var dailyBreakdownData = [[0,2.34],
                            [1,5.14],
                            [2,3.31],
                            [3,6.24],
                            [4,2.54]];

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
        show: true,
        radius: 5 
      }
  }

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

  $.plot($("#graph"), [dailyBreakdownSeries], options);

  $("graph").bind("plothover", function(event, pos, item) {
    console.log([event, pos, item]);
  });

});
