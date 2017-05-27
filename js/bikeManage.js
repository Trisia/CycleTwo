/**
 * Created by Cliven on 2017/5/11.
 */

<!--0	搜索所有-->
<!---->
<!--1	查找未借车-->
<!---->
<!--2	根据状态查询-->
<!--bikestate 1-正常;2-损坏;3-待维修,默认1-->
<!---->
<!--3	关键字查询车牌-->
<!--keyword-->
<!---->
<!--4	车牌搜索-->
<!--bikecode-->

layui.use(['layer', 'laypage'], function () {
    var layer = layui.layer;

    var getBikeInfoUrl = "../../controller/bike/getBikeInfo.php"
        , sreachConditionUrl = "../../controller/bike/findAllByCondition.php"
        , addBikeUrl = "../../controller/bike/add.php"
        , deleteBikeUrl = "../../controller/bike/delete.php"
        , modifyBikeUrl = "../../controller/bike/modify.php";


    var LAYER_INDEXS = 0;

    var islendItem = $("#search_islendbox a")
        , bikestateItem = $("#search_bikestatebox a")
        , conditionbox = $("#conditionbox")
        , confirm = $("#confirm")
        , addnewbike = $("#addnewbike");


    var tablebody = $("#tablebody");


    /**
     * 条件控制事件统一注册
     */
    function conditionEventBind() {

        // 选择标题事件注册
        islendItem.on("click", function () {
            console.log("OK");
            islendItem.removeClass("curr");
            $(this).addClass("curr");
            // 赋值隐藏的input
            $("#is_lend").val($(this).data("is_lend"));
        });
        bikestateItem.on("click", function () {
            bikestateItem.removeClass("curr");
            $(this).addClass("curr");
            // 赋值隐藏的input
            $("#bikestate").val($(this).data("bikestate"));
        });

        /**
         *
         */
        confirm.on("click", function () {
            var request = getRequestData(1);
            // 更改搜索条件后 更新页码
            unpdataTotalPage(sreachConditionUrl, request);
        });

        /**
         * 给添加自行车窗口点击注册
         */
        addnewbike.on('click', function () {
            popModal(addNewBikeTpl(), function (index, layero) {
                $('#addnew').on('click', function () {
                    var data = $(this).parent().parent().serializeObject();
                    $.post(addBikeUrl, data, function (response) {
                        try {
                            utils.doafterResponse(response);
                            layer.msg(response.message);
                            clWind();
                        } catch (err) {
                            utils.pterr(err)
                        }
                    });
                })
            });
        });
    }


    function clWind() {
        LAYER_INDEXS !== undefined ? layer.close(LAYER_INDEXS) : "";
    }

    /**
     * 初始化
     */
    function init() {

        islendItem.first().addClass("curr");
        bikestateItem.first().addClass("curr");
    }


    // 总页码
    var totalPage = 1;


    /**
     * 获取请求条件
     * @param page
     * @returns {{page: *}}
     */
    function getRequestData(page) {
        var result = conditionbox.serializeObject();
        result.page = page;
        return result;
    }


    /**
     * 转态过滤器
     * @param state
     * @returns {string}
     */
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


    function isLending(state) {
        var result = "未知";
        switch (state) {
            case 0:
                result = "空闲";
                break;
            case 1:
                result = "使用中";
                break;
            default:
                result = "未知";
                break;
        }
        return result;
    }


    // 弹出模态
    function popModal(content, callback) {

        LAYER_INDEXS = layer.open({
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
     * 条数据的模板渲染
     * @param d
     * @returns {string}
     */
    function tupleTpl(d) {
        return ""
            + '<tr data-bikecode="' + d.bikecode + '">'
            + '<td>' + d.bikecode + '</td>'
            + '<td data-lng="' + d.lng + '" data-lat="' + d.lat + '">' + d.lng + ',' + d.lat + '</td>'
            + '<td data-bikestate=' + d.bikestate + '>' + bikeState(d.bikestate) + '</td>'
            + '<td data-is_lend=' + d.is_lend + '>' + isLending(d.is_lend) + '</td>'
            + '<td>' + d.pctime + '</td>'
            + '<td>'
            + '<a class="btn-full" modify-btn>修改车辆信息</a>'
            + '<a  class="btn-full delete-btn" delete-btn>删除</a>'
            + '</td>'
            + '</tr>';
    }


    /**
     * 添加新单车
     */
    function addNewBikeTpl() {
        return ""
            + '<form id="newbikeform">'
            + '<div id="bikecodeBox">'
            + '<p><label for="newbikecode">新车车牌</label></p>'
            + '<input type="text" class="tb-input" id="newbikecode" name="bikecode" placeholder="车牌号">'
            + '</div>'
            + '<div id="newbikepositionbox">'
            + '<p><span>车辆位置</span></p>'
            + '<label for="lng">经度:</label>'
            + '<input  type="number" class="tb-input" name="lng" placeholder="">'
            + '<span>&nbsp;&nbsp;&nbsp;</span>'
            + '<label for="lat">纬度:</label>'
            + '<input type="number" class="tb-input" name="lat" placeholder="">'
            + '</div>'
            + '<div id="addnewbox">'
            + '<a id="addnew">添 加</a>'
            + '</div>'
            + '</form>'
    }

    /**
     * 修改自行车模板
     * @param d
     * @returns {string}
     */
    function modifyBikeTpl(d) {
        return '<form id="modifybikeform">'
            + '<div id="bikecodebox">'
            + '<p>' + d.bikecode + '</p>'
            + '<input type="text" style="display: none" name="bikecode" value="' + d.bikecode + '">'
            + '</div>'
            + '<div id="bikestatebox" class="btn-modify">'
            + '<p><label for="newbikecode">车辆状态</label></p>'
            + '<a data-bikestate="1" ' + (d.bikestate == 1 ? 'class="curr"' : "") + '>正常</a>'
            + '<a data-bikestate="2" ' + (d.bikestate == 2 ? 'class="curr"' : "") + '>报废</a>'
            + '<a data-bikestate="3" ' + (d.bikestate == 3 ? 'class="curr"' : "") + '>待维修</a>'
            + '<input type="number" style="display: none" name="bikestate" value="1">'
            + '</div>'
            + '<div id="newbikepositionbox">'
            + '<p><span>车辆位置</span></p>'
            + '<label for="lng">经度:</label>'
            + '<input type="number" class="" name="lng" value="' + d.lng + '">'
            + '<span>&nbsp;&nbsp;&nbsp;</span>'
            + '<label for="lat">纬度:</label>'
            + '<input type="number" class="" name="lat" value="' + d.lat + '">'
            + '</div>'
            + '<div id="addnewbox">'
            + '<a id="modify">修 改</a>'
            + '</div>'
            + '</form>';

    }


    /**
     * 发送请求修改自行车
     */
    function modifyBike() {
        // 找到上级表单 序列化
        var data = $("#modifybikeform").serializeObject();
        console.log(data);
        $.post(modifyBikeUrl, data, function (response) {
            try {
                utils.doafterResponse(response);
                layer.msg(response.message);
                clWind();
            } catch (err) {
                utils.pterr(err)
            }
        });
    }

    /**
     * 删除
     * @param index
     * @param layero
     */
    function deleteBike(index, layero) {
        var bikeCode = $(layero).find("strong").text();
        // console.log(bikeCode);
        $.post(deleteBikeUrl, {bikecode: bikeCode}, function (response) {
            try {
                var data = utils.doafterResponse(response);
                layer.msg("删除成功", {
                    end: function () {
                        window.location.reload();
                    }
                });

            } catch (err) {
                utils.pterr(err);
            }
        })
    }

    /**
     * 渲染 元素
     * @param dataArray
     */
    function readerTable(dataArray) {
        // 模板渲染添加DOM
        dataArray.forEach(function (data) {
            tablebody.append(tupleTpl(data));
        });

        // 按钮事件绑定
        tablebody.find("[modify-btn]").on('click', function () {


            var target = $(this).parent().parent().find('[data-lng]')
                , lng = target.data('lng')
                , lat = target.data('lat');

            var data = {
                bikecode: $(this).parent().parent().data('bikecode')
                , bikestate: $(this).parent().parent().find('[data-bikestate]').data('bikestate')
                , lng: lng
                , lat: lat
            };


            /**
             * 弹出修改界面
             */
            popModal(modifyBikeTpl(data), function () {

                /**
                 * 转态修改注册
                 */
                $("#bikestatebox").find("a").on("click", function () {
                    $("#bikestatebox").find("a").removeClass("curr");
                    $(this).addClass("curr");
                    $("#bikestatebox input").val($(this).data("bikestate"));
                });

                /**
                 * 弹出后注册提交事件
                 */
                $('#modify').on('click', function () {
                    // 找到上级表单 序列化

                    var data = $("#modifybikeform").serializeObject();
                    // console.log(data);
                    $.post(modifyBikeUrl, data, function (response) {
                        try {
                            utils.doafterResponse(response);
                            layer.msg(response.message, {
                                end: function () {
                                    clWind();
                                    window.location.reload();
                                }
                            });

                        } catch (err) {
                            utils.pterr(err)
                        }
                    });
                });
            });

        });

        // 删除按钮
        tablebody.find("[delete-btn]").on('click', function () {
            var bikecode = $(this).parent().parent().data('bikecode');
            layer.msg("<p>你确定删除车牌为:</p>" + "<p><strong>" + bikecode + "</strong></p><p>的CycleTwo单车吗?</p>", {
                btn: ['删除', '取消'],
                shift: 6,
                shade: 0.3,
                time: 10000,
                shadeClose: true,
                btn1: deleteBike
            });
            return false;
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
        // REQUEST_DATA['page'] = page;
        $.post(sreachConditionUrl, requestData, function (response) {
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
        unpdataTotalPage(sreachConditionUrl, getRequestData(1));
        // 条件监听器绑定
        conditionEventBind();
        init();
    });
});
