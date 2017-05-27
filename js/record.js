/**
 * Created by Cliven on 2017/5/13.
 */


layui.use(['layer', 'laypage'], function () {
    var layer = layui.layer;

    var conditionSearchUril = "../../controller/record/findAllByCondition.php";


    // var LAYER_INDEXS = 0;   // 弹出层layerui index 用于关闭

    var IS_FLODCONDITION = true;    // 是否折叠更多条件
    var IS_FLODSORT = true;      // 是否折叠排序选项
    // 排序规则
    var sortState = {
        id: 0
        , stime: 0
        , etime: 0
        , cost: 0
    };


    var tablebody = $("#tablebody")
        , more = $('#more')
        , conditionfrombox = $("#conditionfrombox")
        , id = $('#id')
        , id_search = $('#id_search')
        , confirm = $('#confirm')
        , sort = $("#sort")
        , sortRule = $('#sortRule')
        , allSortA = $('#sortRule a');


    /**
     * 条件控制事件统一注册
     */
    function conditionEventBind() {

        /**
         * 切换多条件搜索和但条件搜索
         */
        more.on('click', function () {
            if (more.text() == "更多条件") {
                more.text("收 起");

            } else {
                more.text("更多条件");
            }
            IS_FLODCONDITION = !IS_FLODCONDITION;
            $("[toggle]").animate({
                height: 'toggle',
                opacity: 'toggle'
            }, "fast");
        });


        /**
         * 精确搜索
         */
        id_search.on('click', function () {
            unpdataTotalPage(conditionSearchUril, {id: id.val()});
        });


        /**
         * 模糊搜索
         */
        confirm.on('click', function () {
            var data = getRequestData(1);
            unpdataTotalPage(conditionSearchUril, data);
        });


        /**
         * 折叠排序规则按钮
         */
        sort.on('click', function () {
            if (sort.text() == '排 序') {
                sort.text('收 起');
            } else {
                sort.text('排 序');
            }
            IS_FLODSORT = !IS_FLODSORT;
            sortRule.animate({
                height: 'toggle',
                opacity: 'toggle'
            }, "fast");
        });

        /**
         * 排序规则多次点击事件注册
         */
        allSortA.on('click', function () {
            var that = $(this);

            var key = that.data('key');

            sortState[key] = (sortState[key] + 1) % 3;
            console.log(sortState);
            // 移除不同的类
            if (sortState[key] == 1) {
                that.addClass('curr');
            } else if (sortState[key] == 2) {
                that.removeClass('curr');
                that.addClass('double');
            } else {
                that.removeClass('double');
            }
        });

    }


    // 总页码
    var totalPage = 1;


    /**
     * 获取请求条件
     * @param page
     * @returns {{page: *}}
     */
    function getRequestData(page) {
        var result;
        if (!IS_FLODCONDITION) {
            result = conditionfrombox.serializeObject();
            var orderby = {};

            // true 表示 降序 / false 升序
            if (sortState.id != 0)
                orderby.id = sortState.id == 2 ? 1 : 0;

            if (sortState.stime != 0)
                orderby.stime = sortState.stime == 2 ? 1 : 0;


            if (sortState.etime != 0)
                orderby.etime = sortState.etime == 2 ? 1 : 0;

            if (sortState.cost != 0)
                orderby.cost = sortState.cost == 2 ? 1 : 0;

            result.orderby = orderby;

        } else {
            result = {id: id.val()};
        }

        result.page = page;
        console.log(result);
        return result;
    }


    // 没条数据的模板渲染
    function tupleTpl(d) {
        return ""
            + '<tr data-id="' + d.id + '">'
            + '<td>' + d.id + '</td>'
            + '<td>' + d.stime + '</td>'
            + '<td>' + (d.etime == null ? "未结束" : d.etime) + '</td>'
            + '<td>' + (d.bikecode == null ? "车牌失效" : d.bikecode) + '</td>'
            + '<td>' + (d.username == null ? "用户失效" : d.username) + '</td>'
            + '<td>' + d.cost + '</td>'
            + '</tr>';
    }

    // 渲染 元素
    function readerTable(dataArray) {
        // 模板渲染添加DOM
        dataArray.forEach(function (data) {
            tablebody.append(tupleTpl(data));
        });
    }


    /**
     * 更新页码
     * @param url
     * @param dataparam
     */
    function unpdataTotalPage(url, dataparam) {
        $.post(url, dataparam, function (response) {
            try {
                var data = utils.doafterResponse(response);
                // 总页码
                totalPage = data.total;
                laypagefn(totalPage);
            } catch (err) {
                utils.pterr(err);
            }
        });
    }

    // 获取数据 然后渲染
    function getdata(page) {

        var requestData = getRequestData(page);

        $.post(conditionSearchUril, requestData, function (response) {
            try {
                var data = utils.doafterResponse(response);
                readerTable(data.data);
            } catch (err) {
                utils.pterr(err);
            }
        });
    }


    /**
     * 分页初始化
     */
    function laypagefn(totalPage) {
        var laypage = layui.laypage;
        // layer 分页
        laypage({
            cont: 'pagecontent'
            , pages: totalPage
            , skin: '#1E9FFF'
            , jump: function (obj) {    //  分页触发
                // 移除动画
                tablebody.hide();
                tablebody.children().remove();
                // 获取数据 响应后渲染数据
                getdata(obj.curr);
                tablebody.show("slow");
            }
        });
    }

    $(function () {
        // 更新页码
        unpdataTotalPage(conditionSearchUril, getRequestData(1));

        // 条件监听器绑定
        conditionEventBind();

    });
});
