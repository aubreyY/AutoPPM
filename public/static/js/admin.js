var ipconfig = "http://localhost/";

var div2remove = null;
var delimgnum = null;

$(function () {
    $('#form_test').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            sFigure: {
                validators: {
                    notEmpty: {
                        message: '请填写图号！'
                    }
                }
            },
            sForging: {
                validators: {
                    notEmpty: {
                        message: '请填写锻造比！'
                    }
                }
            },
            sCoupon: {
                validators: {
                    notEmpty: {
                        message: '请填写试棒方向！'
                    }
                }
            },
            sDrill: {
                validators: {
                    notEmpty: {
                        message: '请填写钻φ**mm！'
                    }
                }
            },
            sFile: {
                validators: {
                    notEmpty: {
                        message: '请上传资源！'
                    }
                }
            }
        }
    })
    /*
     * 当点击了确定下单的按钮后调用此方法
     * 然后执行表单校验
     * */
    function onsubmitFn() {
        //表单提交前再进行一次验证
        var bootstrapValidator = $("#btn_s").data('bootstrapValidator');
        bootstrapValidator.validate();
        if (bootstrapValidator.isValid())
            $("#form_test").submit();
        else return;
    }

    // 提交刷新页面
    $('#btn_s1').click(function(){
        setTimeout(function(){
            window.location.href="admin.html";
        }, 1000);
    })

    $('#btn_s2').click(function(){
        setTimeout(function(){
            window.location.href="admin.html";
        }, 1000);
    })

    window.onload = function () {
        initPage();
    }

    function initPage() {
        var json = {};
        $.ajax({
            type: "GET",
            url: ipconfig + "autoppm/public/index/Index/adminInit.html",
            contentType: "application/json",
            data: json,
            traditional: true,
            dataType: "text",
            async: true,
            beforeSend: function (XHR) {
                //发送ajax请求之前向http的head里面加入验证信息
            },
            success: function (data) {
                var arrayData = JSON.parse(data);
                var testnumItem = 0;
                $.each(arrayData, function (list, item) {
                    var current_item = "<div id='rowid" + list + "' class='row'>" +
                        "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" +
                        "<p class='table_p'>" + item["c_image_num"] + "</p>" +
                        "</div>" +
                        "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseSystem' aria-expanded='true' aria-controls='collapseOne'>" +
                        "<p class='table_p'>" + item["c_forging_ratio"] + "</p>" +
                        "</div>" +
                        "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" +
                        "<p class='table_p'>" + item["c_tb_direction"] + "</p>" +
                        "</div>" +
                        "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" +
                        "<p class='table_p'>" + item["c_zuan_data"] + "</p>" +
                        "</div>" +
                        "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" +
                        "<p class='table_p'>" + item["c_image_path"] + "</p>" +
                        "</div>" +
                        "<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" +
                        "<button class='btn btn-success btn-xs' id='changeid" + testnumItem + "' data-toggle='modal' data-target='#changeSource'  style='margin-left: 10px;'>修改</button>" +
                        "<button class='btn btn-danger btn-xs' id='deleteid" + testnumItem + "' data-toggle='modal' data-target='#deleteSource' style='margin-left: 10px;'>删除</button>" +
                        "</div>" +
                        "</div>";
                    $('.tablebody').append(current_item);

                    $("#changeid" + testnumItem).on('click', null, function () {
                        console.log("change id");
                        $("#mFigure").attr("value", item["c_image_num"]);
                    })

                    $("#deleteid" + testnumItem).on('click', null, function () {
                        console.log("delete id");
                        div2remove = "#rowid" + list;
                        delimgnum = item["c_image_num"];
                    })


                    testnumItem++;

                })

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("数据加载失败");
            }
        });
    }

    $(".finishaddid").bind("click", function () {
        window.opener.document.location.reload();
    })

    $("#confirmdelid").click(function () {
        console.log("confirmdelid");
        $(div2remove).remove();
        var json = { "dtestnum": delimgnum };
        $.ajax({
            type: "GET",
            url: ipconfig + "autoppm/public/index/Index/admindelectOneRowData.html",
            contentType: "application/json",
            data: json,
            traditional: true,
            dataType: "text",
            async: true,
            beforeSend: function (XHR) {
                //发送ajax请求之前向http的head里面加入验证信息
            },
            success: function (data) {
                layer.open({
                    title: '删除成功'
                    , content: '资源已成功删除'
                });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.open({
                    title: '添加失败'
                    , content: '资源添加失败'
                });
            }
        });
    })

    function addresource() {
        var json = {
            "sFigure": $("#imgnumid").val(),
            "sForging": $("#dzbid").val(),
            "sCoupon": $("#sbfxid").val(),
            "sDrill": $("#zuanid").val(),
            "imagePath": "image"
            // "imagePath": $("#imgurlid").val()
        };
        console.log("json:" + json);
        $.ajax({
            type: "GET",
            url: ipconfig + "autoppm/public/index/Index/adminCommonTableAdd.html",
            contentType: "application/json",
            data: json,
            traditional: true,
            dataType: "text",
            async: true,
            beforeSend: function (XHR) {
                //发送ajax请求之前向http的head里面加入验证信息
            },
            success: function (data) {
                layer.open({
                    title: '添加成功'
                    , content: '资源已添加成功'
                });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.open({
                    title: '添加失败'
                    , content: '资源添加失败'
                });
            }
        });
    }
});
