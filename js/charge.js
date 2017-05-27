/**
 * Created by Cliven on 2017/5/15.
 */

;!(function () {
    var charge = $("#charge"),
        money = $("#money"),
        balance = $("#balance")
        , tip = $('#tip');

    var chargeUrl = "../../controller/user/modify.php",
        userInfoUrl = "../../controller/user/getUserInfo.php";

    // 打印错误
    function pterr(err) {
        console.error(err);
        layui.layer.msg(err, function () {
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


    charge.click(function () {
        var data = {
            id: userid,
            balance: money.val()
        };
        $.post(chargeUrl, data, function (response) {
            try {
                var data = doafterResponse(response);
                updataBalance();
            } catch (err) {
                pterr(err);
            }
        })
    });


    /**
     * 更新用户余额
     */
    function updataBalance() {
        $.post(userInfoUrl, {id: userid}, function (response) {
            try {
                var data = doafterResponse(response);
                balance.text(data.balance);
                money.val('');
            } catch (err) {
                pterr(err);
            }
        })
    }

    money.on('focus', function () {
        tip.hide('fast');
    });

    money.on("blur", function () {
        var value = money.val();

        if (value < 0) {
            charge.attr("disabled", "true");
            utils.shakebox($(this));
            utils.toggleAnm(tip);
        }
        else {
            charge.removeAttr("disabled", "false");
        }
    });

    $(function () {
        updataBalance();
    });
})();