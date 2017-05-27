function EmailAutoComplete(options) {
    this.config = {
        targetCls: '.inputElem',
        parentCls: '.parentCls',
        hiddenCls: '.hiddenCls',
        searchForm: '.jqtransformdone',
        hoverBg: 'hoverBg',
        inputValColor: 'black',
        mailArr: ["@qq.com", "@gmail.com", "@126.com", "@163.com", "@hotmail.com", "@yahoo.com", "@yahoo.com.cn", "@live.com", "@sohu.com", "@sina.com"],
        isSelectHide: true,
        callback: null
    };
    this.cache = {onlyFlag: true, currentIndex: -1, oldIndex: -1};
    this.init(options)
}
EmailAutoComplete.prototype = {
    constructor: EmailAutoComplete, init: function (options) {
        this.config = $.extend(this.config, options || {});
        var self = this, _config = self.config, _cache = self.cache;
        $(_config.targetCls).each(function (index, item) {
            $(item).keyup(function (e) {
                var target = e.target, targetVal = $.trim($(this).val()), keycode = e.keyCode,
                    elemHeight = $(this).outerHeight(), elemWidth = $(this).outerWidth(),
                    parentNode = $(this).closest(_config.parentCls);
                $(parentNode).css({'position': 'relative'});
                if (targetVal == '') {
                    $(item).attr({'data-html': ''});
                    $(_config.hiddenCls, parentNode).val('');
                    _cache.currentIndex = -1;
                    _cache.oldIndex = -1;
                    $(".auto-tip", parentNode) && !$(".auto-tip", parentNode).hasClass('hidden') && $(".auto-tip", parentNode).addClass('hidden');
                    self._removeBg(parentNode)
                } else {
                    $(item).attr({'data-html': targetVal});
                    $(_config.hiddenCls, parentNode).val(targetVal);
                    $(".auto-tip", parentNode) && $(".auto-tip", parentNode).hasClass('hidden') && $(".auto-tip", parentNode).removeClass('hidden');
                    self._renderHTML({
                        keycode: keycode,
                        e: e,
                        target: target,
                        targetVal: targetVal,
                        height: elemHeight,
                        width: elemWidth,
                        parentNode: parentNode
                    })
                }
            })
        });
        $(_config.searchForm).each(function (index, item) {
            $(item).keydown(function (e) {
                var keyCode = e.keyCode;
                if (keyCode == 13) {
                    return false
                }
            })
        });
        $(document).click(function (e) {
            e.stopPropagation();
            var target = e.target, tagCls = _config.targetCls.replace(/^\./, '');
            if (!$(target).hasClass(tagCls)) {
                $('.auto-tip') && $('.auto-tip').each(function (index, item) {
                    !$(item).hasClass('hidden') && $(item).addClass('hidden')
                })
            }
        });
    }, _renderHTML: function (cfg) {
        var self = this, _config = self.config, _cache = self.cache, curVal;
        var curIndex = self._keyCode(cfg.keycode);
        $('.auto-tip', cfg.parentNode).hasClass('hidden') && $('.auto-tip', cfg.parentNode).removeClass('hidden');
        if (curIndex > -1) {
            self._keyUpAndDown(cfg.targetVal, cfg.e, cfg.parentNode)
        } else {
            if (/@/.test(cfg.targetVal)) {
                curVal = cfg.targetVal.replace(/@.*/, '')
            } else {
                curVal = cfg.targetVal
            }
            if (_cache.onlyFlag) {
                $(cfg.parentNode).append('<input type="hidden" class="hiddenCls"/>');
                var wrap = '<ul class="auto-tip">';
                for (var i = 0; i < _config.mailArr.length; i++) {
                    wrap += '<li class="p-index' + i + '">' + '<span class="output-num"></span><em class="em" data-html="' + _config.mailArr[i] + '">' + _config.mailArr[i] + '</em></li>'
                }
                wrap += '</ul>';
                _cache.onlyFlag = false;
                $(cfg.parentNode).append(wrap);
                $('.auto-tip', cfg.parentNode).css({
                    'position': 'absolute',
                    'top': cfg.height,
                    'width': cfg.width - 2 + 'px',
                    'left': 0,
                    'border': '1px solid #ccc',
                    'z-index': 10000
                })
            }
            $('.auto-tip li', cfg.parentNode).each(function (index, item) {
                $('.output-num', item).html(curVal);
                !$('.output-num', item).hasClass(_config.inputValColor) && $('.output-num', item).addClass(_config.inputValColor);
                var emVal = $.trim($('.em', item).attr('data-html'));
                $(item).attr({'data-html': curVal + '' + emVal})
            });
            self._accurateMate({target: cfg.target, parentNode: cfg.parentNode});
            self._itemHover(cfg.parentNode);
            self._executeClick(cfg.parentNode)
        }
    }, _accurateMate: function (cfg) {
        var self = this, _config = self.config, _cache = self.cache;
        var curVal = $.trim($(cfg.target, cfg.parentNode).attr('data-html')), newArrs = [];
        if (/@/.test(curVal)) {
            var prefix = curVal.replace(/@.*/, ""), suffix = curVal.replace(/.*@/, "");
            $.map(_config.mailArr, function (n) {
                var reg = new RegExp(suffix);
                if (reg.test(n)) {
                    newArrs.push(n)
                }
            });
            if (newArrs.length > 0) {
                $('.auto-tip', cfg.parentNode).html('');
                $(".auto-tip", cfg.parentNode) && $(".auto-tip", cfg.parentNode).hasClass('hidden') && $(".auto-tip", cfg.parentNode).removeClass('hidden');
                var html = '';
                for (var j = 0, jlen = newArrs.length; j < jlen; j++) {
                    html += '<li class="p-index' + j + '">' + '<span class="output-num"></span><em class="em" data-html="' + newArrs[j] + '">' + newArrs[j] + '</em></li>'
                }
                $('.auto-tip', cfg.parentNode).html(html);
                $('.auto-tip li', cfg.parentNode).each(function (index, item) {
                    $('.output-num', item).html(prefix);
                    !$('.output-num', item).hasClass(_config.inputValColor) && $('.output-num', item).addClass(_config.inputValColor);
                    var emVal = $.trim($('.em', item).attr('data-html'));
                    $(item).attr('data-html', '');
                    $(item).attr({'data-html': prefix + '' + emVal})
                });
                _cache.currentIndex = -1;
                _cache.oldIndex = -1;
                $('.auto-tip .output-num', cfg.parentNode).html(prefix);
                self._itemHover(cfg.parentNode);
                self._executeClick(cfg.parentNode)
            } else {
                $(".auto-tip", cfg.parentNode) && !$(".auto-tip", cfg.parentNode).hasClass('hidden') && $(".auto-tip", cfg.parentNode).addClass('hidden');
                $('.auto-tip', cfg.parentNode).html('')
            }
        }
    }, _itemHover: function (parentNode) {
        var self = this, _config = self.config, _cache = self.cache;
        $('.auto-tip li', parentNode).hover(function (index, item) {
            !$(this).hasClass(_config.hoverBg) && $(this).addClass(_config.hoverBg)
        }, function () {
            $(this).hasClass(_config.hoverBg) && $(this).removeClass(_config.hoverBg)
        })
    }, _removeBg: function (parentNode) {
        var self = this, _config = self.config;
        $(".auto-tip li", parentNode).each(function (index, item) {
            $(item).hasClass(_config.hoverBg) && $(item).removeClass(_config.hoverBg)
        })
    }, _keyUpAndDown: function (targetVal, e, parentNode) {
        var self = this, _cache = self.cache, _config = self.config;
        if ($('.auto-tip' + ' li', parentNode) && $('.auto-tip' + ' li').length > 0) {
            var plen = $('.auto-tip' + ' li', parentNode).length, keyCode = e.keyCode;
            _cache.oldIndex = _cache.currentIndex;
            if (keyCode == 38) {
                if (_cache.currentIndex == -1) {
                    _cache.currentIndex = plen - 1
                } else {
                    _cache.currentIndex = _cache.currentIndex - 1;
                    if (_cache.currentIndex < 0) {
                        _cache.currentIndex = plen - 1
                    }
                }
                if (_cache.currentIndex !== -1) {
                    !$('.auto-tip .p-index' + _cache.currentIndex, parentNode).hasClass(_config.hoverBg) && $('.auto-tip .p-index' + _cache.currentIndex, parentNode).addClass(_config.hoverBg).siblings().removeClass(_config.hoverBg);
                    var curAttr = $('.auto-tip' + ' .p-index' + _cache.currentIndex, parentNode).attr('data-html');
                    $(_config.targetCls, parentNode).val(curAttr);
                    $(_config.hiddenCls, parentNode).val(curAttr)
                }
            } else if (keyCode == 40) {
                if (_cache.currentIndex == plen - 1) {
                    _cache.currentIndex = 0
                } else {
                    _cache.currentIndex++;
                    if (_cache.currentIndex > plen - 1) {
                        _cache.currentIndex = 0
                    }
                }
                if (_cache.currentIndex !== -1) {
                    !$('.auto-tip .p-index' + _cache.currentIndex, parentNode).hasClass(_config.hoverBg) && $('.auto-tip .p-index' + _cache.currentIndex, parentNode).addClass(_config.hoverBg).siblings().removeClass(_config.hoverBg);
                    var curAttr = $('.auto-tip' + ' .p-index' + _cache.currentIndex, parentNode).attr('data-html');
                    $(_config.targetCls, parentNode).val(curAttr);
                    $(_config.hiddenCls, parentNode).val(curAttr)
                }
            } else if (keyCode == 13) {
                var curVal = $('.auto-tip' + ' .p-index' + _cache.oldIndex, parentNode).attr('data-html');
                $(_config.targetCls, parentNode).val(curVal);
                $(_config.hiddenCls, parentNode).val(curVal);
                if (_config.isSelectHide) {
                    !$(".auto-tip", parentNode).hasClass('hidden') && $(".auto-tip", parentNode).addClass('hidden')
                }
                _config.callback && $.isFunction(_config.callback) && _config.callback();
                _cache.currentIndex = -1;
                _cache.oldIndex = -1
            }
        }
    }, _keyCode: function (code) {
        var arrs = ['17', '18', '38', '40', '37', '39', '33', '34', '35', '46', '36', '13', '45', '44', '145', '19', '20', '9'];
        for (var i = 0, ilen = arrs.length; i < ilen; i++) {
            if (code == arrs[i]) {
                return i
            }
        }
        return -1
    }, _executeClick: function (parentNode) {
        var _self = this, _config = _self.config;
        $('.auto-tip' + ' li', parentNode).unbind('click');
        $('.auto-tip' + ' li', parentNode).bind('click', function (e) {
            var dataAttr = $(this).attr('data-html');
            $(_config.targetCls, parentNode).val(dataAttr);
            if (_config.isSelectHide) {
                !$(".auto-tip", parentNode).hasClass('hidden') && $(".auto-tip", parentNode).addClass('hidden')
            }
            $(_config.hiddenCls, parentNode).val(dataAttr);
            _config.callback && $.isFunction(_config.callback) && _config.callback()
        })
    }
};
$(function () {
    new EmailAutoComplete({})
});