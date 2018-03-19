<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商城 api - 接口文档</title>

    <!-- Bootstrap core CSS -->
    <link href="css/api/bootstrap.css" rel="stylesheet">
    <link href="css/api/default.css" rel="stylesheet">

    <style type="text/css">
        html, body {
            overflow: hidden;
            height: 100%;
        }

        .content {
            background-color: rgba(255, 255, 255, 0.92);
            height: 100%;
        }

        h2 {
            margin: 0;
            padding: 25px 0;
        }

        #sidebar {
            overflow-y: auto;
            padding-right: 20px;
            padding-left: 20px;
            padding-top: 20px;
            box-shadow: 2px 2px 3px rgba(223, 223, 223, 0.59);
        }

        #result .input-group {
            margin-right: 50px;
            box-shadow: 2px 2px 3px rgba(223, 223, 223, 0.59);
            margin-bottom: 10px;
        }

        .item-result {
            margin-bottom: 15px;
            margin-right: 50px;
        }

        .item-result pre {
            overflow-y: scroll;
            background-color: rgba(221, 221, 221, 0.22);
            box-shadow: 2px 2px 3px rgba(223, 223, 223, 0.59);
            clear: both;
            margin-bottom: 20px;
        }

        .item-result h5 {
            float: right;
            position: relative;
            margin-bottom: -28px;
            margin-right: 16px;
            background-color: rgba(197, 197, 197, 0.28);
            padding: 6px 14px;
            color: green;
        }

        .item-doc {
            border: 1px solid #ccc;
            padding: 0 10px;
            margin-bottom: 5px;
            border-radius: 3px;
            box-shadow: 2px 2px 3px rgba(223, 223, 223, 0.59);
        }

        .item-doc form {
            padding-bottom: 10px;
            display: none;
        }

        .item-doc em {
            color: red;
        }

        .item-doc .input-group {
            margin-bottom: 10px;
            width: 95%;
        }

        .item-doc .input-group-addon {
            width: 45%;
            text-align: right;
        }

        .item-doc h5 {
            cursor: pointer;
        }

        .item-doc h5 .link {
            color: #2a6496;
        }

        .alert-warning {
            background-color: rgba(245, 236, 189, 0.52);
        }
    </style>
</head>
<body>
<div class="content">

    <!--h2 class="text-center">api - 接口文档</h2-->

    <div class="row">
        <div class="col-md-3" style="margin-top: 15px">
            <ul class="nav sidebar-nav" id="sidebar">
                <li>
                    <!--h3>api接口列表</h3-->

                </li>
            </ul>
        </div>

        <div class="col-md-9" id="result"  style="margin-top: 40px">
            <div class="input-group">
                <span class="input-group-addon">请求URL</span><input id="url" value="" type="text" class="form-control"
                                                                   onclick="this.select()"/>
            </div>
            <div class="item-result">
                <h5>json</h5>
                <pre></pre>
            </div>
            <div class="item-result">
                <h5>文本</h5>
                <pre></pre>
            </div>
        </div>
    </div>


</div>
<script src="js/api/jquery-1.9.1.min.js"></script>
<script src="js/api/jquery.form.js"></script>
<script src="js/api/highlight.pack.js"></script>
<!--<script src="static/lib/bootstrap/js/bootstrap.min.js"></script>-->
<script>
    var JsonUti = {
        //定义换行符
        n: "\n",
        //定义制表符
        t: "   ",
        //转换String
        convertToString: function (obj) {
            return JsonUti.__writeObj(obj, 1);
        },
        //写对象
        __writeObj: function (obj //对象
            , level //层次（基数为1）
            , isInArray) { //此对象是否在一个集合内
            //如果为空，直接输出null
            if (obj == null) {
                return "null";
            }
            //为普通类型，直接输出值
            if (obj.constructor == Number || obj.constructor == Date || obj.constructor == String || obj.constructor == Boolean) {
                var v = obj.toString();
                var tab = isInArray ? JsonUti.__repeatStr(JsonUti.t, level - 1) : "";
                if (obj.constructor == String || obj.constructor == Date) {
                    //时间格式化只是单纯输出字符串，而不是Date对象
                    return tab + ("\"" + v + "\"");
                }
                else if (obj.constructor == Boolean) {
                    return tab + v.toLowerCase();
                }
                else {
                    return tab + (v);
                }
            }
            //写Json对象，缓存字符串
            var currentObjStrings = [];
            //遍历属性
            for (var name in obj) {
                var temp = [];
                //格式化Tab
                var paddingTab = JsonUti.__repeatStr(JsonUti.t, level);
                temp.push(paddingTab);
                //写出属性名
                temp.push("\"" + name + "\" : ");
                var val = obj[name];
                if (val == null) {
                    temp.push("null");
                }
                else {
                    var c = val.constructor;
                    if (c == Array) { //如果为集合，循环内部对象
                        temp.push(JsonUti.n + paddingTab + "[" + JsonUti.n);
                        var levelUp = level + 2; //层级+2
                        var tempArrValue = []; //集合元素相关字符串缓存片段
                        for (var i = 0; i < val.length; i++) {
                            //递归写对象
                            tempArrValue.push(JsonUti.__writeObj(val[i], levelUp, true));
                        }
                        temp.push(tempArrValue.join("," + JsonUti.n));
                        temp.push(JsonUti.n + paddingTab + "]");
                    }
                    else if (c == Function) {
                        temp.push("[Function]");
                    }
                    else {
                        //递归写对象
                        temp.push(JsonUti.__writeObj(val, level + 1));
                    }
                }
                //加入当前对象“属性”字符串
                currentObjStrings.push(temp.join(""));
            }
            return (level > 1 && !isInArray ? JsonUti.n : "") //如果Json对象是内部，就要换行格式化
                + JsonUti.__repeatStr(JsonUti.t, level - 1) + "{" + JsonUti.n //加层次Tab格式化
                + currentObjStrings.join("," + JsonUti.n) //串联所有属性值
                + JsonUti.n + JsonUti.__repeatStr(JsonUti.t, level - 1) + "}"; //封闭对象
        },
        __isArray: function (obj) {
            if (obj) {
                return obj.constructor == Array;
            }
            return false;
        },
        __repeatStr: function (str, times) {
            var newStr = [];
            if (times > 0) {
                for (var i = 0; i < times; i++) {
                    newStr.push(str);
                }
            }
            return newStr.join("");
        }
    };
</script>
<script>
    $(function () {

        $.getJSON("./api.json", function (result) {
            var postHtml = "";
            $.each(result, function (i, field) {
                postHtml += '<div class="item-doc">';
                postHtml += '<h5>['+ (i+1) +']'+ field.desc + ':<br/> <small class="link">&nbsp;&nbsp;' + field.url + '</small></h5>';
                postHtml += '<form role="form" action="' + field.url + '">';
                postHtml += '<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />';
                $.each(field.params, function (j, item) {
                    var isStar = "";
                    if (item.is_require == "1") {
                        isStar = "*";
                    }
                    if (item.is_image != "1") {
                        postHtml += '<div class="input-group">';
                        postHtml += '<span class="input-group-addon"><em>' + isStar + '</em>' + item.field + '[' + item.fieldDesc + ']' + '</span><input name="' + item.field + '" placeholder="' + item.fieldDesc + '" value="" type="text" class="form-control">';
                        postHtml += '</div>';
                    } else {
                        postHtml += '<div class="input-group">';
                        postHtml += '<span class="input-group-addon"><em>' + isStar + '</em>' + item.field + '[' + item.fieldDesc + ']' + '</span><input name="' + item.field + '" placeholder="' + item.fieldDesc + '" value="" type="file" class="form-control">';
                        postHtml += '</div>';
                    }
                });
                postHtml += '<div class="input-group">';
                postHtml += '<span class="input-group-addon"><em> * </em>请求方式</span><div style="border: 1px solid #cccccc; line-height: 2;padding-left: 18px;"><input type="radio" name="request_method" value="post" style="display: inline-block;margin:0 10px;"><span style="margin-right: 10px;">post</span><input type="radio" name="request_method" value="get" style="display: inline-block;margin:0 10px;"><span style="margin-right: 10px;">get</span></div>';
                postHtml += '</div>';

                postHtml += '<button type="submit" class="btn btn-primary">Submit</button>';
                postHtml += '&nbsp;<button type="button" class="btn btn-primary getParams" data-id ="requestDesc'+i+'">请求参数说明</button>';
                postHtml += '&nbsp;<button type="button" class="btn btn-primary getParams" data-id ="resultDesc'+i+'">返回结果说明</button>';
                postHtml += '<div style="display: none" id="requestDesc'+i+'">'+field.requestDesc+'</div>';
                postHtml += '<div style="display: none" id="resultDesc'+i+'">'+field.resultDesc+'</div>';
                postHtml += '</form></div>';
            });
            $("#sidebar li").append(postHtml);
            functionReload();
        });


        functionReload();
        function functionReload() {
            var $result = $('#result')
                , $sidebar = $('#sidebar')
                , $children = $result.children()
                , $pre = $children.find('pre')
                , offsetTop = $result.offset().top;
            $(window).resize(function () {
                var height = (document.documentElement.clientHeight - offsetTop - 140) / 2;
                $pre.eq(0).height(height * 0.7 * 2);
                $pre.eq(1).height(height * 0.3 * 2);
                $sidebar.height(document.documentElement.clientHeight - offsetTop - 35);
            }).trigger('resize');

            function getUrl($form) {
                return $form.attr('action')
            }

            $('.getParams').click(function() {
                var id = $(this).attr("data-id");
                $pre.eq(0).html($('#'+id).html());
            });

            $('form').on('submit',function (e) {
                e.stopPropagation();
                var $this = $(this);
                var url = getUrl($this);
                var request_method =$this.find('input[name="request_method"]:checked').val();
                $pre.html('');
                $('#url').val(window.location.origin + url);
                $this.ajaxSubmit({
                    type: request_method,
                    url: url,
                    dataType: 'text',
                    success: function (jsonText) {
                        var text = jsonText;
                        try {
                            var json = $.parseJSON(jsonText);
                            jsonText = JsonUti.convertToString(json);
                        } catch (e) {
                        }
                        $pre.eq(0).html(jsonText);
                        $pre.eq(1).html(text);
                        hljs.highlightBlock($pre[0]);
                        hljs.highlightBlock($pre[1]);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $pre.html('');
                        $pre.eq(0).html('status:' + XMLHttpRequest.status + '<br><br>' + XMLHttpRequest.responseText);
                    }
                });
                return false;
            });

            $('#sidebar h5').click(function () {
                $(this).next('form').toggle();
            })
        }
    });
</script>
</body>
</html>