(function ($) {
    $.fn.yiiBootstrapDialog = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.yiiBootstrapDialog');
            return false;
        }
    };

    var defaults = {
        url: undefined,
        containerId: undefined,
        jsName: undefined,
        selector: undefined,
        dialogOptions: {},
        buttons: [],
        open: false,
        pjaxOptions: {
            linkSelector: false,
            formSelector: false,
            push: false,
            replace: false,
            scrollTo: false
        }
    };

    var dialogData = {};

    var methods = {
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                var id = $e.attr('id');
                if (dialogData[id] === undefined) {
                    dialogData[id] = {};
                }

                dialogData[id] = $.extend(dialogData[id], {settings: settings});

                var dialogOptions = $.extend(settings.dialogOptions, {
                    onshow: function (dialog) {
                        dialog.setButtons(settings.buttons);
                        var target = dialog.getData('sender');
                        var url = dialog.getData('url');
                        if (!url && target && target.length) {
                            url = target.attr('href') || target.attr('data-url');
                        }
                        if (!url) {
                            url = settings.url;
                        }
                        console.log('pjax url:', url);
                        var pjaxOptions = $.extend(settings.pjaxOptions, {
                            url: url,
                            container: '#' + settings.containerId
                        });

                        var pjaxLoad = '<script type="text/javascript">' +
                            '$.pjax(' + JSON.stringify(pjaxOptions) + ');' +
                            '</script>';
                        dialog.$modalBody.html(
                            "<div id=\"" + settings.containerId + "\">" + pjaxLoad + "</div>"
                        );
                    }
                });

                $(document).on('pjax:success', '#' + settings.containerId, function (data, content) {
                    var title = $('<div>' + content + '</div>').find('title');
                    if (title.length) {
                        dialog.setTitle(title.text());
                    }
                    var options = dialog.getData('options');
                    if (!options) {
                        return;
                    }
                    $.each(options, function (key, value) {
                        var $elem = $('#' + settings.containerId).find('[data-dialog-attr="' + key + '"]');
                        if ($elem.length) {
                            if ($elem[0].tagName == 'INPUT' || $elem[0].tagName == 'TEXTAREA' || $elem[0].tagName == 'SELECT') {
                                $elem.val(value);
                            } else if ($elem[0].tagName == 'CHECKBOX') {
                                $elem.attr('checked', value ? 'checked' : false);
                            } else if ($elem[0].tagName == 'OPTION') {
                                $elem.attr('checked', value ? 'checked' : false);
                            } else {
                                $elem.html(value);
                            }
                        }
                    });
                });

                var dialog = new BootstrapDialog(dialogOptions);

                if (settings.selector) {
                    $(document).on('click', settings.selector, function (e) {
                        e.preventDefault();
                        dialog.setData('sender', $(this));
                        dialog.setTitle("Loading...");
                        dialog.open();
                    });
                }

                if (settings.jsName) {
                    window[settings.jsName] = dialog;
                }

                if (settings.open) {
                    dialog.open();
                }
            });
        }
    };
})(window.jQuery);
