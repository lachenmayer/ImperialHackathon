var debug = true;

function log(str) {
  if (debug) console.log(str);
}

var Foodie = (function() {

  var userInfo = {};

  return {
    getUserInfoByCID: function(cid, callback) {
      $.get("http://dyn1195-219.wlan.ic.ac.uk/~peregrinepark/ImperialHackathon/dbase.php?type=single&cid=" + cid, function(response) {
        userInfo[cid] = JSON.parse(response);
        callback(userInfo[cid]);
      });
      //var fakeResponse = '{"dailybreakdown":[{"count":"7","total":"4250","day":"Sunday"},{"count":"8","total":"5550","day":"Saturday"},{"count":"15","total":"8700","day":"Friday"},{"count":"13","total":"6250","day":"Thursday"},{"count":"20","total":"7850","day":"Wednesday"},{"count":"14","total":"3450","day":"Tuesday"},{"count":"13","total":"9050","day":"Monday"}],"topfoods":[{"itemid":4,"quantity":2,"total":200},{"itemid":10,"quantity":8,"total":8000},{"itemid":8,"quantity":19,"total":950},{"itemid":6,"quantity":18,"total":9000},{"itemid":7,"quantity":6,"total":300},{"itemid":5,"quantity":18,"total":3600},{"itemid":9,"quantity":6,"total":600},{"itemid":3,"quantity":3,"total":4500},{"itemid":1,"quantity":16,"total":19200},{"itemid":2,"quantity":2,"total":800}],"topshops":[{"shopid":6,"count":12,"total":4250},{"shopid":3,"count":14,"total":6350},{"shopid":4,"count":11,"total":5850},{"shopid":5,"count":16,"total":8950},{"shopid":1,"count":18,"total":8050},{"shopid":2,"count":27,"total":13700}],"items":[{"itemid":1,"name":"Tuna Sandwich","price":1200,"metadata":"1,5,400,1,3"},{"itemid":2,"name":"Large Cappucino","price":400,"metadata":"1,2,0,50,1,4"},{"itemid":3,"name":"Baked Potato","price":1500,"metadata":"1,1,300,1,2"},{"itemid":4,"name":"Baked Beans","price":100,"metadata":"1,5,100,2,2"},{"itemid":5,"name":"Green Tea","price":200,"metadata":"1,2,0,10,3,4"},{"itemid":6,"name":"Chocolate Muffin","price":500,"metadata":"1,2,6,500,1,1"},{"itemid":7,"name":"Banana","price":50,"metadata":"1,2,3,300,1,4"},{"itemid":8,"name":"Apple","price":50,"metadata":"1,2,3,200,2,2"},{"itemid":9,"name":"Lattice Pastry","price":100,"metadata":",6,800,1,1"},{"itemid":10,"name":"Powerade","price":1000,"metadata":",0,600,4,4"}],"shops":[{"shopid":1,"name":"JCR Pancake Shop"},{"shopid":2,"name":"EEE Cafe"},{"shopid":3,"name":"JCR Deli"},{"shopid":4,"name":"JCR Fast Food"},{"shopid":5,"name":"JCR Cafe"},{"shopid":6,"name":"Library Cafe"}]}';
      //callback(JSON.parse(fakeResponse));
    }
  }

})();

var DailyBreakdown = (function() {

  var userInfo = {};

  var weeklyTotal = 0;

  var inputData = [];
  
  return {
    getInfo: function(info) {
      userInfo = info.dailybreakdown;
      $.each(userInfo, function(i, day) {
        inputData.push([userInfo.length - i - 1, day.total]);
        weeklyTotal += parseInt(day.total);
      });
      inputData.reverse();
    },

    drawTable: function() {
      var tableRows = "";
      $.each(userInfo, function(i, day) {
        var tableRow = '<tr><td class="day ' + day.day.toLowerCase() + '">' +
                       day.day +
                       '</td> <td class=total> £' +
                       (day.total / 100).toFixed(2) +
                       '</td></tr>';
        tableRows = tableRow + tableRows;
      });
      $("#dailybreakdown").append(tableRows);
      $(".moneyspent").text((weeklyTotal / 100).toFixed(2));
    },

    plotGraph: function() {
      var separateDays = [];
      var dayColors = ["#000000", "#F24949", "#89E0FA", "#FFEC73", "#73C75A", "#FF822E", "#9DA600"];
      for(var i = 0; i < inputData.length; i++){
          var series = {
              data: [inputData[i]],
              lines: {
                  show: false
              },
              shadowSize: 0,
              color: dayColors[i % inputData.length],
              points: {
                  show: true,
                  radius: 5,
                  lineWidth: 4
              }
          }
          separateDays.push(series);
      }

      var series = {
          data: inputData,
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

      separateDays.unshift(series);

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
      $.plot($("#graph"), separateDays, options);
      $("#graph").bind("plotclick", function(event, pos, item) {
        console.log(event);
      });
    }
  }

})();

var TopFoods = (function() {

  var topItems = {};
  var items = {};
  
  var getItemNameById = function(id) {
    var itemName = "";
    $.each(items, function(i, item) {
      if (id == item.itemid) {
        itemName = item.name;
        return;
      }
    });
    return itemName;
  }

  return {
    
    getInfo: function(info) {
      topItems = info.topfoods;
      items = info.items;
    },

    drawTable: function() {
      $.each(topItems, function(i, item) {
        var tableRow = "<tr><td class=item>" +
                       getItemNameById(item.itemid) +
                       "</td><td class=amount>" +
                       item.quantity + 
                       "</td><td class=total>£" +
                       (item.total / 100).toFixed(2) +
                       "</td></tr>";
        $("#topitems").append(tableRow);
      });
    }

  }

})();

var TopShops = (function() {

  var topShops = {};
  var shops = {};
  
  var getShopNameById = function(id) {
    var shopName = "";
    $.each(shops, function(i, shop) {
      if (id == shop.shopid) {
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
        var tableRow = "<tr><td class=shop>" +
                       getShopNameById(shop.shopid) +
                       "</td><td class=amount>" +
                       shop.count + 
                       "</td><td class=total>£" +
                       (shop.total / 100).toFixed(2) +
                       "</td></tr>";
        $("#topshops").append(tableRow);
      });
    }

  }

})();

$(function () {
  
  Foodie.getUserInfoByCID(770807, function(userInfo) {
    log(userInfo);

    DailyBreakdown.getInfo(userInfo);
    DailyBreakdown.drawTable();
    DailyBreakdown.plotGraph();

    TopFoods.getInfo(userInfo);
    TopFoods.drawTable();

    TopShops.getInfo(userInfo);
    TopShops.drawTable();
  });
  
});


