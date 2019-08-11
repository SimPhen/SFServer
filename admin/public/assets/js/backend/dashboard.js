define(['jquery', 'bootstrap', 'backend', 'addtabs', 'table', 'echarts', 'echarts-theme', 'template'], function ($, undefined, Backend, Datatable, Table, Echarts, undefined, Template) {

    var Controller = {
        index: function () {
            // 基于准备好的dom，初始化echarts实例
            var myChart = Echarts.init(document.getElementById('echart'), 'walden');

            var totalValue = document.getElementById('totalValue');

            var fromDate = document.getElementById('date1');
            var toDate   = document.getElementById('date2');

            var date=new Date();
            //年
            var year=date.getFullYear();
            //月
            var month=(date.getMonth()+1)>10?(date.getMonth()+1):"0"+(date.getMonth()+1);
            //日
            var day=date.getDate()>10?date.getDate():"0"+date.getDate();


            function mGetDate(year, month){
                var d = new Date(year, month, 0);
                return d.getDate();
            }

            var fromDay = date.getDate()-6;
            var fromMonth = date.getMonth()+1;
            var fromYear  = date.getFullYear();
            if(fromDay<=0){
                var totalDay = 0;
                fromMonth = fromMonth -1;
                if(fromMonth<=0){
                    fromMonth = 12 + fromMonth;
                    fromYear = fromYear -1;
                    totalDay = mGetDate(fromYear,fromMonth);   //29
                }else{
                    totalDay = mGetDate(fromYear,fromMonth);   //29
                };
                fromDay =totalDay + fromDay;
            };
            fromDay   = fromDay>10?fromDay:"0"+fromDay;
            fromMonth = fromMonth>10?fromMonth:"0"+fromMonth;

            fromDate.value = fromYear+"-"+fromMonth+"-"+fromDay;
            toDate.value   = year+"-"+month+"-"+day;
            var btnSure = document.getElementById('sure');
            btnSure.onclick = function() {
              var f1 = new Date(fromDate.value.replace(/-/g, "/")); 
              var t2 = new Date(toDate.value.replace(/-/g, "/")); 
              if (Date.parse(f1) - Date.parse(t2) == 0) { 
                alert("两个日期相等"); 
                return false; 
              } 
              if (Date.parse(f1) - Date.parse(t2) > 0) { 
                alert("结束日期 小于 开始日期"); 
                return false; 
              } 


               var d1 = new Date(fromDate.value);
               var d2 = new Date(toDate.value);
               var off_day =parseInt(d2 - d1)/1000/86400;
                $.ajax({
                    url: "dashboard/test",
                    type: "post",
                    dataType: "json",
                    data: {from:fromDate.value,to:toDate.value,fromD:d1.getTime()/1000,off:off_day},
                    success: function (ret) {
                       //console.log(ret);
                       totalValue.innerText =ret['time']; 
                       var keys = ret['keys'];
                       var values = ret['values'];
                       Orderdata.paydata = values;
                       Orderdata.column  = keys;
                        myChart.setOption({
                            xAxis: {
                                data: keys,
                            },
                            series: [{
                                name: __('Sales'),
                                data: values,
                            }]
                        });
                      
                       // if ($("#echart").width() != $("#echart canvas").width() && $("#echart canvas").width() < $("#echart").width()) {
                       //     myChart.resize();
                       // };
                    }, error: function (e) {    
                       console.log("is error"+e)
                    }
                });
            };
            // 指定图表的配置项和数据
            var option = {
                title: {
                    text: '',
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                // legend: {
                //     data: [__('Sales'), __('Orders')]
                // },
                toolbox: {
                    show: false,
                    feature: {
                        magicType: {show: true, type: ['stack', 'tiled']},
                        saveAsImage: {show: true}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: Orderdata.column
                },
                yAxis: {},
                grid: [{
                    left: 'left',
                    top: 'top',
                    right: '10',
                    bottom: 30
                }],
                series: [{
                    name: __('Sales'),
                    type: 'line',
                    smooth: true,
                    areaStyle: {
                        normal: {}
                    },
                    lineStyle: {
                        normal: {
                            width: 1.5
                        }
                    },
                    data: Orderdata.paydata
                },
                    // {
                    //     name: __('Orders'),
                    //     type: 'line',
                    //     smooth: true,
                    //     areaStyle: {
                    //         normal: {}
                    //     },
                    //     lineStyle: {
                    //         normal: {
                    //             width: 1.5
                    //         }
                    //     },
                    //     data: Orderdata.createdata
                    // }
                    ]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
            //动态添加数据，可以通过Ajax获取数据然后填充
            // setInterval(function () {
            //     Orderdata.column.push((new Date()).toLocaleTimeString().replace(/^\D*/, ''));
            //     var amount = Math.floor(Math.random() * 200) + 200000;
            //     Orderdata.createdata.push(amount);
            //     Orderdata.paydata.push(Math.floor(Math.random() * amount) + 1);

            //     //按自己需求可以取消这个限制
            //     if (Orderdata.column.length >= 20) {
            //         //移除最开始的一条数据
            //         Orderdata.column.shift();
            //         Orderdata.paydata.shift();
            //         Orderdata.createdata.shift();
            //     }
            //     myChart.setOption({
            //         xAxis: {
            //             data: Orderdata.column
            //         },
            //         series: [{
            //             name: __('Sales'),
            //             data: Orderdata.paydata
            //         },
            //             {
            //                 name: __('Orders'),
            //                 data: Orderdata.createdata
            //             }]
            //     });
            //     if ($("#echart").width() != $("#echart canvas").width() && $("#echart canvas").width() < $("#echart").width()) {
            //         myChart.resize();
            //     }
            // }, 2000);
            
            function getCountNum(){
                var tmpNum = 0;
                for ( var i = 0; i <Orderdata.paydata.length; i++){
                   tmpNum = tmpNum + Orderdata.paydata[i];
                }
                return tmpNum;
            }
            var judgeCount = getCountNum();
            setInterval(function () {
                var d1 = new Date(fromDate.value);
                var d2 = new Date(toDate.value);
                var off_day =parseInt(d2 - d1)/1000/86400;
                 $.ajax({
                    url: "dashboard/test",
                    type: "post",
                    dataType: "json",
                    data: {from:fromDate.value,to:toDate.value,fromD:d1.getTime()/1000,off:off_day},
                    success: function (ret) {
                       //console.log(ret);
                       totalValue.innerText =ret['time']; 
                       var keys = ret['keys'];
                       var values = ret['values'];
                       Orderdata.paydata = values;
                       Orderdata.column  = keys;
                       var tmp = getCountNum();
                        if(tmp>judgeCount){
                             myChart.setOption({
                                    xAxis: {
                                        data: Orderdata.column,
                                    },
                                    series: [{
                                        name: __('Sales'),
                                        data: Orderdata.paydata,
                                    }]
                                });
                             judgeCount = tmp;
                        };
                    }, error: function (e) {    
                       console.log("time:is error"+e)
                    }
                });
            }, 5000);
            
           

            $(window).resize(function () {
                myChart.resize();
            });

            $(document).on("click", ".btn-checkversion", function () {
                top.window.$("[data-toggle=checkupdate]").trigger("click");
            });


        }
    };

    return Controller;
});