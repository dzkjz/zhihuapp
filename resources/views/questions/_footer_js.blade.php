<script type="text/javascript">
    // 实例化编辑器
    var ue = UE.getEditor('container', {
        toolbars: [
            ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'insertimage', 'fullscreen']
        ],
        elementPathEnabled: false,
        enableContextMenu: false,
        autoClearEmptyNode: true,
        wordCount: false,
        imagePopup: false,
        autotypeset: {indent: true, imageBlockLine: 'center'}
    });
    ue.ready(function () {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });
    $(document).ready(function () {
        // Select2多选js
        $('.js-example-basic-multiple').select2({
            // 设置属性及初始化值
            tags: true,
            placeholder: '选择相关话题',
            miniumInputLength: 2,

            ajax: {
                url: '/api/topics',
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                delay: 250,
                data: function (params) {
                    return {
                        // term : The current search term in the search box.
                        //     q : Contains the same contents as term.
                        // _type: A "request type". Will usually be query, but changes to query_append for paginated requests.
                        // page : The current page number to request. Only sent for paginated (infinite scrolling) searches.
                        q: params.term, // search term
                        // page: params.page 暂时不需要分页
                    };
                },
                processResults: function (data, params) {
                    // 解析结果为Select2期望的格式
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    return {
                        results: data
                    };
                },
                cache: true,
            },
            //模板样式
            templateResult: formatTopic,
            //模板样式 【选择项】
            templateSelection: formatTopicSelection,
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });

    //格式化话题
    function formatTopic(topic) {
        return "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" +
        topic.name ? topic.name : "Laravel" +
            "</div></div></div>";
    }

    //格式化话题选项
    function formatTopicSelection(topic) {
        return topic.name || topic.text;
    }
</script>
