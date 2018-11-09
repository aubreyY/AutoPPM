var ipconfig = "http://localhost/";

var testlist = new Array();
var alltestlist = new Array();
var nonetestlist = new Array();

var idlist = new Array();
var allidlist = new Array();
var noneidlist = new Array();
$(function () {
    var $infocontainer = $("#infoid");
    var $g1div = $("#g1id");
    var $g2div = $("#g2id");

    function showModal() { //打开上传框

    }

    function closeModal() { //关闭上传框

    }

    //利用html5 FormData() API,创建一个接收文件的对象，因为可以多次拖拽，这里采用单例模式创建对象Dragfiles
    var Dragfiles = (function () {
        var instance;
        return function () {
            if (!instance) {
                instance = new FormData();
            }
            return instance;
        }
    }());
    //为Dragfiles添加一个清空所有文件的方法
    FormData.prototype.deleteAll = function () {
        var _this = this;
        this.forEach(function (value, key) {
            _this.delete(key);
        })
    }

    //添加拖拽事件
    var dz = document.getElementById('content');
    var upfile = document.getElementById("fileiconid");
    var upfile1 = document.getElementById("fileiconid1");
    var upfile2 = document.getElementById("fileiconid2");
    var doupload = document.getElementById("uploadiconid");

    doupload.onclick = function () {
        upload();
    }

    var newForm = Dragfiles(); //获取单例
    upfile.addEventListener("dragover", function (e) {
        //阻止浏览器默认打开文件的操作
        e.preventDefault();
        console.log("dragover");
        //拖入文件后边框颜色变红
        this.style.borderColor = 'red';
    })

    upfile.addEventListener("dragleave", function (e) {
        //恢复边框颜色
        e.preventDefault();
        console.log("dragleave");
        this.style.borderColor = 'gray';
    })
    upfile.addEventListener("drop", function (e) {
        //恢复边框颜色
        this.style.borderColor = 'gray';
        //阻止浏览器默认打开文件的操作
        e.preventDefault();
        console.log("drop");
        console.log("files:" + JSON.stringify(e));
        var files = e.dataTransfer.files[0];
        console.log("files:" + JSON.stringify(files));
        //添加文件到newForm
        newForm.append(files.name, files);
    })

    //ajax上传文件
    function upload() {
        var data = newForm; //获取formData
        $.ajax({
            url: ipconfig + 'AutoPPM/public/index/Index/uploads.html',
            type: 'POST',
            data: data,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                alert('succeed!') //可以替换为自己的方法
                closeModal();
                data.deleteAll(); //清空formData
            },
            error: function (returndata) {
                // alert('failed!') //可以替换为自己的方法
            }
        });
    }

    function timetrans() {
        var date = new Date();//如果date为10位不需要乘1000
        var Y = date.getFullYear() + '-';
        var M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
        var D = (date.getDate() < 10 ? '0' + (date.getDate()) : date.getDate()) + ' ';
        var h = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
        var m = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
        var s = (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds());
        return Y + M + D + h + m + s;
    }

    function subtimetrans() {
        var date = new Date();//如果date为10位不需要乘1000
        var h = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';
        var m = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';
        var s = (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds());
        return h + m + s;
    }

    /*表格全屏显示*/
    $(".q_btn").toggle(
        function () {
            $("#tbl").css({ width: "246%", height: "92%", left: "-49%"});
            $("#tbl").css({ border: "1px solid #DFDFDF", "box-shadow": "0px -3px 20px 15px rgba(85,135,238,0.5)" });
            // $(".tab_tr").css({width: "1500px",'margin-top':"-11px","white-space": "inherit","overflow": "auto"});
            $(".tab_null").css({"margin-top":"0px"});
        },
        function () {
            $("#tbl").css({ width: "100%", height: "420px", left: "0px" });
            $("#tbl").css({ border: "0px solid #fff", "box-shadow": "0px 0px 0px 0px"});
            // $(".tab_tr").css({width: "31.8%",'margin-top':"-9px;","white-space": "nowrap"});
            $(".tab_null").css({"margin-top":"8px"});
            // $(".th_1").css({width:"79px"});
        });

    //清空所有内容
    function clearAll() {
        var data = Dragfiles();
        data.deleteAll(); //清空formData
    }

    $infocontainer.bind("click", function () {
        var json = {};


        $("#loadgif").show();
        $("#time_out").show();

        $.ajax({
            type: "GET",
            url: ipconfig + "autoppm/public/index/Index/dataextra.html",
            contentType: "application/json",
            data: json,
            traditional: true,
            dataType: "text",
            async: true,
            success: function (data) {
                clearInterval(timer);
                $("#loadgif").hide();
                $("#time_out").hide();
                // var generatedata = new Date();
                var timespan = timetrans();
                //console.log("timespan:"+timespan);
                $("#timespanid").text(timespan);
                document.getElementById("g1id").style.background = "#4068c0";
                document.getElementById("g1id").style.pointerEvents = "all";
                var cir1 = document.getElementById("processcirid2");
                var line1 = document.getElementById("processline2");
                cir1.src = ipconfig + "autoppm/public/static/img/green.png";
                line1.src = ipconfig + "autoppm/public/static/img/Green Line.png";
                var arrayData = JSON.parse(data);
                var testnumItem = 0;
                $('tr').remove(".tab_td");
                $.each(arrayData, function (list, item) {
                    var current_item =
                        "<tr class='tab_td'>" +
                            "<td><input id='infoitem" + testnumItem + "' type='checkbox' name='check' value='" + testnumItem + "' /></td>" +
                            "<td>" + item["it_reportnum"] + "</td>" +
                            "<td>" + item["it_partnum"] + "</td>" +
                            "<td>" + item["it_imagenum"] + "</td>" +
                            "<td>" + item["it_partname"] + "</td>" +
                            "<td>" + item["it_materialnum"] + "</td>" +
                            "<td>" + item["it_spec"] + "</td>" +
                            "<td>" + item["it_quantity"] + "</td>" +
                            "<td>" + item["it_batchnum"] + "</td>" +
                            "<td>" + item["it_reportsheetnum"] + "</td>" +
                            "<td>" + item["it_testnum"] + "</td>" +
                            "<td>" + item["it_thickness"] + "</td>" +
                            "<td>" + item["it_sliplen"] + "</td>" +
                            "<td>" + item["it_quaprovenum"] + "</td>" +
                            "<td>" + item["it_metaprovenum"] + "</td>" +
                            "<td>" + item["it_mechnum"] + "</td>" +
                            "<td>" + item["it_cheminum"] + "</td>" +
                            "<td>" + item["it_metalnum"] + "</td>" +
                        "</tr>";
                    $('#infotableid').append(current_item);
                    allidlist[testnumItem] = item["it_id"];
                    $("#infoitem"+testnumItem).on('click', null,function () {
                        if ($(this).prop("checked")==true) {
                            console.log("value:"+item["it_id"]);
                            idlist[$(this).val()] = item["it_id"];
                            console.log("idlist:" + idlist);
                            $("#zzkcb").prop("checked", true);
                        } else {
                            idlist[$(this).val()] = "";
                            console.log("idlist:" + idlist);
                            var templist = idlist.slice(0);
                            if (templist.notempty().length == 0) {
                                $("#zzkcb").prop("checked", false);
                            }
                        }
                    })
                    testnumItem++;

                    //隔行换色
                    $("tr:odd").addClass("tr_odd");
                    $("tr:even").addClass("tr_even");
                })
                //全选or全不选
                $("#tab_th").click(function () {
                    if (this.checked) {
                        idlist = allidlist;
                        console.log("allidlist:" + idlist);
                        $("#zzkcb").prop("checked", true);
                        $("[name=check]:checkbox").prop("checked", true);
                    } else {
                        idlist = noneidlist;
                        console.log("noneidlist:" + idlist);
                        $("#zzkcb").prop("checked", false);
                        $("[name=check]:checkbox").prop("checked", false);
                    }
                });
                generateTestnumlist();
                //信息框-例1
                layer.open({
                    title: '生成成功'
                    , content: '材料信息表已生成'
                });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#loadgif").hide();
                $("#time_out").hide();
                alert("材料信息表生成失败");
            }
        });
        var timer = setInterval(function () {
            $.ajax({
                type: "GET",
                // url:"{:url('dataExtra')}",
                url: ipconfig + "autoppm/public/index/Index/getPercent.html",
                contentType: "application/json",
                data: json,
                traditional: true,
                dataType: "text",
                async: true,
                beforeSend: function (XHR) {
                },
                success: function (data) {
                    console.log("data:" + data);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("获取失败");
                }
            });
        }, 1000);

    })
    function generateTestnumlist() {
        console.log("generateTestnumlist");
        var json = {};
        $.ajax({
            type: "GET",
            url: ipconfig + "autoppm/public/index/Index/getTestnum.html",
            contentType: "application/json",
            data: json,
            traditional: true,
            dataType: "text",
            async: true,
            success: function (data) {
                var arrayData = JSON.parse(data);
                console.log("arrayData:" + arrayData);
                var cnt = 0;
                $.each(arrayData, function (list, value) {
                    var item = "<li class='option'>" +
                        "<input class='case' id='testnum" + cnt + "' name='checkbox' type='checkbox' value='" + cnt + "'>" +
                        "<a href='#'>" + value + "</a>" +
                        "</li>";
                    $("#testulid").append(item);
                    alltestlist[cnt] = value;
                    $("#testnum" + cnt).live('click', function () {
                        if ($(this).prop("checked") == true) {
                            console.log("value:" + value + " checked " + cnt);
                            testlist[$(this).val()] = value;
                            console.log("testlist:" + testlist);
                            $("#wlqdcb").prop("checked", true);
                            $("#hlqdcb").prop("checked", true);
                            $("#dzgykcb").prop("checked", true);
                            $("#rclgykcb").prop("checked", true);
                        } else {
                            console.log("value:" + value + " unchecked " + cnt);
                            testlist[$(this).val()] = "";
                            console.log("testlist:" + testlist);
                            var templist = testlist.slice(0);
                            if (templist.notempty().length == 0) {
                                $("#wlqdcb").prop("checked", false);
                                $("#hlqdcb").prop("checked", false);
                                $("#dzgykcb").prop("checked", false);
                                $("#rclgykcb").prop("checked", false);
                            }
                        }
                    })
                    cnt++;
                })
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#loadgif").hide();
                $("#time_out").hide();
                alert("材料信息表生成失败");
            }
        });
    }
    /**
     * 扩展Array方法, 去除数组中空白数据
     */
    Array.prototype.notempty = function () {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == "" || typeof (this[i]) == "undefined") {
                this.splice(i, 1);
                i--;
            }
        }
        return this;
    };

    $g1div.bind("click", function () {

        testlist.notempty();
        idlist.notempty();
        var json = {};
        json = { "testnumlist": JSON.stringify(testlist), "idnumlist": JSON.stringify(idlist) };

        $("#loadgif").show();
        $("#time_out").show();
        console.log("json:" + JSON.stringify(json));
        $.ajax({
            type: "GET",
            // url:"{:url('dataExtra')}",
            url: ipconfig + "autoppm/public/index/Index/generate1.html",
            contentType: "application/json",
            data: json,
            traditional: true,
            dataType: "text",
            async: true,
            success: function (data) {
                $("#loadgif").hide();
                $("#time_out").hide();
                // // console.log(data);
                var g1time = subtimetrans();
                $(".zzktime").text(g1time);
                $(".wlqdtime").text(g1time);
                $(".hlqdtime").text(g1time);
                var cir1 = document.getElementById("processcirid3");
                var line1 = document.getElementById("processline3");
                cir1.src = ipconfig + "autoppm/public/static/img/green.png";
                line1.src = ipconfig + "autoppm/public/static/img/Green Line.png";
                document.getElementById("g2id").style.background = "#4068c0";
                document.getElementById("g2id").style.pointerEvents = "all";
                // 只读属性
                $(".g1download1").css('pointer-events', "all");
                $(".g1download2").css('pointer-events', "all");
                $(".g1download3").css('pointer-events', "all");

                var contentStr = null;
                if ($("#zzkcb").prop("checked")) {
                    contentStr = '周转卡已生成';
                    $("#zzkimg").attr("src", ipconfig + "autoppm/public/static/img/excel_1.png");
                    $(".g1download1").attr("src", ipconfig + "autoppm/public/static/img/tab_load_1.png");
                }
                if ($("#wlqdcb").prop("checked")) {
                    contentStr = '物料清单、合炉清单已生成';
                    $("#wlqdimg").attr("src", ipconfig + "autoppm/public/static/img/excel_1.png");
                    $("#hlqdimg").attr("src", ipconfig + "autoppm/public/static/img/excel_1.png");
                    $(".g1download2").attr("src", ipconfig + "autoppm/public/static/img/tab_load_1.png");
                    $(".g1download3").attr("src", ipconfig + "autoppm/public/static/img/tab_load_1.png");
                }

                if ($("#wlqdcb").prop("checked")&&$("#zzkcb").prop("checked")) {
                    contentStr = '周转卡、物料清单、合炉清单已生成';
                }

                //信息框-例1
                layer.open({
                    title: '生成成功'
                    , content: contentStr
                });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#loadgif").hide();
                $("#time_out").hide();
                alert("生成失败");
            }
        });
    })
    $g2div.bind("click", function () {
        testlist = testlist.notempty();
        var json = {};
        if (testlist.length != 0) {
            json = { "testnumlist": JSON.stringify(testlist) };
        }
        $("#loadgif").show();
        $("#time_out").show();
        $.ajax({
            type: "GET",
            // url:"{:url('dataExtra')}",
            url: ipconfig + "autoppm/public/index/Index/generate2.html",
            contentType: "application/json",
            data: json,
            traditional: true,
            dataType: "text",
            async: true,
            beforeSend: function (XHR) {
                //发送ajax请求之前向http的head里面加入验证信息
            },
            success: function (data) {
                $("#loadgif").hide();
                $("#time_out").hide();
                var g1time = subtimetrans();
                $(".dzgyktime").text(g1time);
                $(".rclgyktime").text(g1time);
                var cir1 = document.getElementById("processcirid4");
                cir1.src = ipconfig + "autoppm/public/static/img/green.png";
                console.log(data);
                // 只读属性
                $(".g2download1").css('pointer-events', "all");
                $(".g2download2").css('pointer-events', "all");

                if ($("#rclgykcb").prop("checked")) {
                    $("#rclgykimg").attr("src", ipconfig + "autoppm/public/static/img/excel_1.png");
                    $("#dzgykimg").attr("src", ipconfig + "autoppm/public/static/img/excel_1.png");
                    $(".g2download1").attr("src", ipconfig + "autoppm/public/static/img/tab_load_1.png");
                    $(".g2download2").attr("src", ipconfig + "autoppm/public/static/img/tab_load_1.png");
                }
                //信息框-例1
                layer.open({
                    title: '生成成功'
                    , content: '锻造工艺卡、热处理工艺卡已生成'
                });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#loadgif").hide();
                $("#time_out").hide();
                alert("生成失败");
            }
        });
    })

    $(".select_toggle").click(function(){
        if($(".select_menu").css("display")=="none"){
            $(".select_menu").show();
        }else{
            $(".select_menu").hide();
        }
    });
    // 点击按钮隐藏
    $(".select_btn").click(function(){
        $(".select_menu").hide();
    });
    //全选
    $("#selectall_1").click(function () {
        $("input[name='checkbox").each(function () {
            $(this).attr("checked", true);
        });
        testlist = alltestlist;
        $("#wlqdcb").prop("checked", true);
        $("#hlqdcb").prop("checked", true);
        $("#dzgykcb").prop("checked", true);
        $("#rclgykcb").prop("checked", true);
    });
    //全不选
    $("#selectall_2").click(function () {
        $("input[name='checkbox").each(function () {
            $(this).attr("checked", false);
        });
        testlist = nonetestlist;
        $("#wlqdcb").prop("checked", false);
        $("#hlqdcb").prop("checked", false);
        $("#dzgykcb").prop("checked", false);
        $("#rclgykcb").prop("checked", false);
    });
    //多选
    $("input:checkbox[name='all']").click(function () {
        if ($(this).attr("checked") == true) {
            $("input:checkbox[name='checkbox']").attr("checked", true);
        } else {
            $("input:checkbox[name='checkbox']").attr("checked", false);
        }
    });
});