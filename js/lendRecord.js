/**
 * Created by Cliven on 2017/5/14.
 */


;!(function () {
    var layer = layui.layer
        , laypage = layui.laypage;


    var tablebody = $('#tablebody')
        , showMore = $('#showMore');


    var UserAllRecordUrl = "../../controller/record/findAllByCondition.php";

    /**
     * 条件控制事件统一注册
     */
    function conditionEventBind() {

        showMore.on('click', disploy);
    }

    var current_page = 1;


    /**
     * 获取记录模板
     * @param d
     * @returns {string}
     */
    function reocrdTpl(d) {
        return '' +
            '<tr style="display: none" data-id="' + d.id + '">'     // 自行车记录id
            + '<td>' + d.stime + '</td>'
            + '<td>' + (d.etime == null ? "未结束" : d.etime) + '</td>'
            + '<td>' + (d.bikecode == null ? "车牌失效" : d.bikecode) + '</td>'
            + '<td>' + d.cost + '</td>'
            + '</tr>';
    }


    /**
     * 渲染 元素
     * @param dataArray
     */
    function readerTable(dataArray) {
        // 模板渲染添加DOM
        dataArray.forEach(function (data) {
            tablebody.append(reocrdTpl(data));
            var last = $('#tablebody tr:last');
            utils.toggleAnm(last, 700);
            // last.slideDown(7000);
        });

    }


    /**
     * 获取数据 然后渲染
     * @param page
     */
    function disploy() {


        var requestData = {
            page: current_page
            , userid: userid
            , orderby: {'stime': 1}
        };

        $.post(UserAllRecordUrl, requestData, function (response) {
            try {
                var data = utils.doafterResponse(response);
                if (data.data.length > 0) {
                    current_page++;
                    readerTable(data.data);
                }
                else {
                    showMore.text("没有了");
                    // showMore.hide('fast');
                }
            } catch (err) {
                utils.pterr(err);
            }
        });
    }


    $(function () {

        // 显示第一页数据
        disploy();
        // 事件绑定
        conditionEventBind();
    });
})();