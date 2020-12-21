<script src="{{ asset('adminhtml/tinymce/tinymce.min.js') }}"></script>
<textarea
    id="content-editor-{{ str_replace('[', '-', str_replace(']', '', $name)) }}" 
    class="form-control"
    @if(!empty($required))
    required
    @endif
    @if(!empty($readonly))
    readonly disabled
    @endif
    name="{{ $name }}">{{ $value }}</textarea>
<script type="text/javascript">
$(function() {
    var widgetTitles = {!! json_encode(\WFN\CMS\Model\Source\Widgets::getInstance()->getOptions()) !!}
    var widgetInitialItem = {
        type: 'selectbox',
        name: 'widget',
        items: {!! json_encode(\WFN\CMS\Model\Source\Widgets::getInstance()->getWidgetOptionsSelect()) !!},
        label: 'Select widget'
    };
    var widgetsConfig = {
        title: 'Insert Widget',
        currentWidget: false,
        body: {
            type: 'panel',
            items: [widgetInitialItem],
        },
        buttons: [
            {type: 'submit', text: 'Save'}
        ],
        onChange: (dialogApi, details) => {
            var data = dialogApi.getData();
            if(data.widget != widgetsConfig.currentWidget) {
                widgetsConfig.currentWidget = data.widget;
                dialogApi.block('');
                widgetsConfig._getWidgetData(data.widget, function() {
                    dialogApi.unblock();
                    dialogApi.redial(widgetsConfig);
                });
            }
        },
        onSubmit: function(dialogApi) {
            var data = dialogApi.getData();
            var title = widgetTitles[data.widget];
            window.editor.insertContent('<span id="' + btoa(JSON.stringify(data)) + '" class="mceNonEditable" contenteditable="false">' + title + '</span>');
            dialogApi.close();
        },
        _getWidgetData: function(widget, callback) {
            $.ajax({
                url: "{{ route('admin.cms.wysiwyg.widget.detail') }}?widget=" + widget,
                success: function(response) {
                    try {
                        widgetsConfig.body.items = [widgetInitialItem];
                        $(response).each(function(index, value) {
                            widgetsConfig.body.items.push(value);
                        });

                        widgetsConfig.initialData = {
                            'widget': widget,
                        };

                        callback();
                    } catch (e) {
                        console.log(e);
                    }
                }
            });
        }
    };

    /* General Config */
    var config = {
        selector: '#content-editor-{{ str_replace('[', '-', str_replace(']', '', $name)) }}',
        height: 650,
        plugins : 'link image hr table code lists',
        menubar: 'edit view insert',
        toolbar: 'formatselect | bold italic underline | bullist numlist | link image | customInsertButton',
        document_base_url : "/",
        relative_urls : false,
        remove_script_host : true,
        @if(Auth::guard('admin')->user()->role->isAvailable('admin.cms.wysiwyg.widget'))
        setup: function (editor) {
            window.editor = editor;
            editor.ui.registry.addButton('customInsertButton', {
                icon: 'embed-page',
                tooltip: 'Insert / Update Widget',
                onAction: function () {
                    var content = $(editor.selection.getContent());
                    if(content.length) {
                        var data = JSON.parse(atob(content.attr('id')));
                        widgetsConfig._getWidgetData(data.widget, function() {
                            widgetsConfig.initialData = data;
                            editor.windowManager.open(widgetsConfig);
                        });
                    } else {
                        editor.windowManager.open(widgetsConfig);
                    }
                },
            });
            editor.on('change', function () {
                editor.save();
            });
        },
        @endif
        content_style: [
            '.mce-content-body [contentEditable=false] {outline: 3px solid #138206;}'
        ],
    };

    /* Images Uploader Config */
    var imagesConfig = {
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', "{{ route('admin.cms.wysiwyg.image.upload') }}");

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Image has not been uploaded');
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
        image_dimensions: false,
        image_list: function(success) {
            $.ajax({
                url: "{{ route('admin.cms.wysiwyg.image.list') }}",
                success: function(response) {
                    success(response);
                },
            });
        },
    };

    Object.assign(config, imagesConfig);
    tinymce.init(config);
});
</script>