/**
 * Created by Cliven on 2017/5/15.
 */



layui.use(['layer', 'laypage'], function () {
    var layer = layui.layer
        , laypage = layui.laypage;


    var lat = Math.random() * 200,
        lng = Math.random() * 200;

    var unusedBikeUrl = "../../controller/bike/unusedBike.php",
        lendBikeUrl = "../../controller/bike/lend.php",
        getBikeInfoUrl = "../../controller/bike/getBikeInfo.php",
        unReturnBikeUrl = "../../controller/user/unreturnbike.php",
        userBikeUrl = "usingBike.php";
    // 总页码
    var totalPage = 1;

    var tablebody = $("#tablebody");

    function bikeState(state) {
        var result = "未知";
        switch (state) {
            case 1:
                result = "正常";
                break;
            case 2:
                result = "故障";
                break;
            case 3:
                result = "待维修";
                break;
            default:
                result = "未知";
                break;
        }
        return result;
    }


    // 弹出模态
    function popModal(data, callback) {
        var content = getBikeInfoTpl(data);
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            skin: 'modal',
            content: content,
            success: callback
        });
    }


    // 组装模板
    function getBikeInfoTpl(data) {
        var tlp = ""
            + '<div class="bikeInfoTable">'
            + '<div class="pricingTable-header">'
            + '<h2 class="bikeInfo-heading">' + data.bikecode + '</h2>'
            + '<span class="price-value">'
            + '<span class="currency">￥</span>0.1'
            + '<span class="yuan">/元</span>'
            + '</span>'
            + '</div>'
            + '<div class="infobox">'
            + '<ul>'
            + '<li>超过<span style="color: #09b1c5">10小时</span> 1元/天</li>'
            + '<li>账户余额大于<span style="color: #09b1c5">199元</span>才可借车</li>'
            + '</ul>'
            + '<a  class="lend-btn" id="lend">骑 车</a>'
            + '</div>'
            + '</div>';

        return tlp;
    }


    function tulpe(d) {
        var lend = "lend";
        var tlp = '<tr data-bikecode="' + d.bikecode + '">'     // 自行车记录id
            + '<td>' + d.bikecode + '</td>' // 车牌
            + '<td>' + d.lng + ',' + d.lat + '</td>'
            + '<td>' + bikeState(d.bikestate) + '</td>'
            + '<td>'
            + '<a class="btn-full" lend-btn>租 车</a>'
            + '</td>'
            + '</tr>';
        return tlp;
    }

    // 打印错误
    function pterr(err) {
        console.error(err);
        layer.msg(err, function () {
        });
    }

    /**
     * 检测是响应是否正确
     * @param response
     * @returns {*}
     */
    function doafterResponse(response) {
        var result = null;
        if (!response || !response.success) {
            throw response ? response.message : "响应参数为空";
        } else
            result = response.data;
        return result;
    }

    // 初始化页码
    $.post(unusedBikeUrl, {page: 1}, function (response) {
        try {
            var data = doafterResponse(response);
            totalPage = data.total;
            laypagefn();
        } catch (err) {
            pterr(err);
        }
    });

    // 重定向
    function redirect(url) {
        window.location = url;
    }

    // 是否已经借车
    function lendBikeDirect() {
        $.post(unReturnBikeUrl, {}, function (response) {
            response.success && redirect(userBikeUrl);
        });
    }


    // 借车按钮绑定
    function btnBikeEventBind() {
        var lendBtn = $("#lend");
        lendBtn.on("click", function () {
            var bikecode = $(".bikeInfo-heading").text();

            console.log(bikecode);
            $.post(lendBikeUrl, {
                "bikecode": bikecode,
                "lat": lat,
                "lng": lng
            }, function (response) {
                try {
                    console.log(response);
                    var data = doafterResponse(response);
                    redirect(userBikeUrl);
                } catch (err) {
                    pterr(err);
                }
            });
        });
    }


    // 渲染 元素
    function readerTable(dataArray) {
        // 模板渲染
        dataArray.forEach(function (data) {
            tablebody.append(tulpe(data));
        });

        // 按钮事件绑定
        tablebody.find("[lend-btn]").on('click', function () {
            var bikecode = $(this).parent().parent().data('bikecode');

            $.post(getBikeInfoUrl, {
                "bikecode": bikecode
            }, function (response) {
                try {
                    console.log(response);
                    var data = doafterResponse(response);
                    popModal(data, btnBikeEventBind);
                } catch (err) {
                    pterr(err);
                }
            })

        });
    }


    // 获取数据 然后渲染
    function getdata(curr) {
        $.post(unusedBikeUrl, {page: curr}, function (response) {
            try {
                var data = doafterResponse(response);
                readerTable(data.data);
            } catch (err) {
                pterr(err);
            }
        })
    }

    /**
     * 分页初始化
     */
    function laypagefn() {


        // layer 分页
        laypage({
            cont: 'pagecontent'
            , pages: totalPage
            , skin: '#1E9FFF'
            , jump: function (obj) {
                tablebody.children().remove();
                getdata(obj.curr);
            }
        });

    }

    $(function () {
        lendBikeDirect();
    });
});