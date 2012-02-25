/* Author: 

 */

var Foodie = (function() {

  var userInfo = {};

  return {
    getUserInfoByCID: function(cid, callback) {
      $.get("http://dyn1212-5.wlan.ic.ac.uk/~peregrinepark/ImperialHackathon/dbase.php?cid=" + cid, function(response) {
        userInfo[cid] = JSON.parse(response);
        callback(userInfo[cid]);
      });
      //var fakeResponse = '{"dailybreakdown":[],"topfoods":[{"itemid":"1","quantity":"1","total":"1200"},{"itemid":"8","quantity":"1","total":"50"}],"topshops":[{"shopid":"4","count":"1","total":"1200"},{"shopid":"1","count":"1","total":"50"}],"items":[{"itemid":"1","name":"Tuna Sandwich","price":"1200","metadata":"1,5,400,1,3"},{"itemid":"8","name":"Apple","price":"50","metadata":"1,2,3,200,2,2"}],"shops":[{"shopid":"1","name":"JCR Pancake Shop"},{"shopid":"4","name":"JCR Fast Food"}]}';
      //callback(JSON.parse(fakeResponse));
    }
  }

})();

var DailyBreakdown = (function() {

    var dailyBreakdownData = [
        [0, 2.34],
        [1, 5.14],
        [2, 3.31],
        [3, 6.24],
        [4, 2.54]
    ];

    var separateDays = [];
    var dayColors = ["#000000", "#F24949", "#89E0FA", "#FFEC73", "#73C75A"];
    for(var i = 0; i < dailyBreakdownData.length; i++){
        var series = {
            data: [dailyBreakdownData[i]],
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
        separateDays.push(series);
    }

    var dailyBreakdownSeries = {
        data: dailyBreakdownData,
        lines: {
            show: true,
            lineWidth: 5
        },
        shadowSize: 0,
        color: "rgb(180, 180, 180)",
        clickable: true,
        hoverable: true,
        points: {
            show: false,
            radius: 5
        }
    }

    separateDays.unshift(dailyBreakdownSeries);

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
  
  return {
    plotGraph: function() {
      $.plot($("#graph"), separateDays, options);
    }
  }

})();

var TopShops = (function() {

  var topShops = {};
  var shops = {};
  
  var getShopNameById = function(id) {
    var shopName = "";
    $.each(shops, function(i, shop) {
      console.log("id: " + id + " shopid: " + shop.shopid);
      if (id == shop.shopid) {
        console.log("return wooo: " + shop.name);
        shopName = shop.name;
        return;
      }
    });
    return shopName;
  }

  return {
    
    getInfo: function(info) {
      topShops = info.topshops;
      shops = info.shops;
    },

    drawTable: function() {
      $.each(topShops, function(i, shop) {
        console.log(getShopNameById(shop.shopid));
        var tableRow = "<tr><td class=shop>" +
                       getShopNameById(shop.shopid) +
                       "</td> <td class=amount>" +
                       shop.total +
                       "</td></tr>";
        $("#topshops").append(tableRow);
      });
    }

  }

})();

$(function () {
  
  Foodie.getUserInfoByCID(593824, function(userInfo) {
    //DailyBreakdown.getInfo(userInfo);
    //DailyBreakdown.drawTable();

    //TopFoods.getInfo(userInfo);
    //TopFoods.drawTable();

    TopShops.getInfo(userInfo);
    TopShops.drawTable();
  });
  

  DailyBreakdown.plotGraph();
  
});
