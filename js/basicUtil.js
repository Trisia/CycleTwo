/**
 * Created by Cliven on 2017/5/11.
 */


var utils = (function ($) {

    var Container = function () {

    };
    var fn = Container.prototype;


    /**
     * 错误弹出提示
     * @param err
     */
    fn.pterr = function (err) {
        console.error(err);
        layer.msg(err, {anim: 6, time: 3000});
    };

    /**
     * 检测是响应是否正确
     * @param response
     * @returns {*}
     */
    fn.doafterResponse = function (response) {
        var result = null;
        if (!response || !response.success) {
            throw response ? response.message : "响应参数为空";
        } else
            result = response.data;
        return result;
    };

    fn.shakebox = function (obj) {
        obj.toggleClass('shake_effect');
        setTimeout(function () {
            obj.toggleClass('shake_effect')
        }, 500);
    };


    /**
     * 触发动画
     * @param obj
     * @param time
     */
    fn.toggleAnm = function (obj, time) {
        time = time === undefined ? "fast" : time;
        obj.animate({
            height: 'toggle',
            opacity: 'toggle'
        }, time);
    };

    /**
     * toggle模态框
     * @param obj
     */
    fn.openMotal = function (obj) {
        // var value = obj.css('z-index') > 0 ? -19960723 : 19960723;
        // var opacity = obj.css('opacity') >= 0 ? 0.5 : 0;

        // console.log("open");
        obj.css('z-index', 19960723);
        obj.css('opacity', 0.5);
    };

    /**
     * 关闭模态框
     */
    fn.closeMotal = function (obj) {
        // console.log('close');
        obj.css('z-index', -19960723);
        obj.css('opacity', 0);
    };

    // ******************** 注入到jquery ***********************
    /**
     * 表单对象序列化为JS对象
     */
    $.fn.serializeObject = function () {
        var result = {};
        // console.log(this);
        var arr = this.serializeArray();
        $.each(arr, function () {
            // 数组判断
            if (result[this.name] !== undefined) {
                // 迁移为数组
                if (!result[this.name].push) {
                    result[this.name] = [result[this.name]];
                }
                // 放入数组
                result[this.name].push(this.value || '');
            } else {
                // 普通参数直接赋值
                result[this.name] = this.value || '';
            }
        });
        return result;
    };



    return new Container();
})(jQuery);



