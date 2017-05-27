/**
 * Created by Cliven on 2017/5/14.
 */

layui.use(['layer'], function () {
    var layer = layui.layer;

    var layerIndex;


    var unReturnBikeUrl = "../../controller/user/unreturnbike.php",
        returnUrl = "../../controller/bike/return.php";
    // 弹出模态

    function getModalTpl(d) {
        return ""
            + '<div id="costbox">'
            + '<h3>本次骑行花费:</h3>'
            + '<h3><span>' + d.hour + '</span><span>:</span><span>' + d.min + '</span></h3>'
            + '<br>'
            + '<span class="money">' + d.cost + '</span><span>元</span>'
            + '<div><a id="clostTip" class="btn">确 定</a></div>'
            + '</div>';
    }

    var lat = Math.random() * 200,
        lng = Math.random() * 200;


    var haslended = $("#haslended")
        , unlend = $("#unlend")
        , bikecode = $("#bikecode")
        , rbtime = $("#rbtime")
        , usetime = $("#usetime")
        , returnBikeBtn = $("#returnBikeBtn")
        , hourbox = $('#hour')
        , minbox = $('#min')
        , secbox = $("#sec");


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


    /**
     * 切换显示界面
     */
    function switchShowInfo() {
        $('.switchInfo').animate({
            height: 'toggle',
            opacity: 'toggle'
        }, 'slow');
    }

    returnBikeBtn.on("click", function () {
        returnBike();
        return false;
    });


    /**
     * 还车
     */
    function returnBike() {
        $.post(returnUrl, {
            lat: lat,
            lng: lng
        }, function (response) {
            try {
                var data = utils.doafterResponse(response);

                data.hour = $('#hour').text();
                data.min = $('#min').text();
                data.sec = $('#sec').text();

                layerIndex = layer.msg(getModalTpl(data), {
                    success: function () {
                        $("#clostTip").on("click", function () {
                            layer.close(layerIndex);
                        });
                    }
                });
                switchShowInfo();
            } catch (err) {
                utils.pterr(err);
            }
        });
    }

    function updateTime() {
        var result = (new Date()).getTime() - Date.parse(new Date(rbtime.text()));
        result = parseInt(result / 1000);


        var hour = parseInt(result / (60 * 60)),
            min = parseInt((result / 60) % 60);
        hour = hour < 10 ? "0" + hour : hour;
        min = min < 10 ? "0" + min : min;
        hourbox.text(hour);
        minbox.text(min);

    }

    /**
     * 渲染数据到界面
     * @param data
     */
    function pestDataToView(data) {
        bikecode.text(data.bikecode);
        rbtime.text(data.rbtime);
        updateTime();
        setInterval(updateTime, 1000);
    }

    $(function () {


        $.post(unReturnBikeUrl, {}, function (response) {
            // console.log(response);
            if (response.success) {
                pestDataToView(response.data);
            } else {
                switchShowInfo();
            }
        });
        // 计时器

    });


});