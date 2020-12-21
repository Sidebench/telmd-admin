<div class="input-group">
    <div class="custom-file">
        <input type="hidden" @if(!empty($readonly)) disabled="disabled" @endif name="{{ $name }}" value="{{ $value }}" />
        <input type="file" @if(!empty($readonly)) disabled="disabled" @endif name="{{ $name }}[file]" class="custom-file-input" id="{{ !empty($id) ? $id : $name }}FileInput" value="{{ $value }}" />
        <label class="custom-file-label" for="{{ !empty($id) ? $id : $name }}FileInput">{{ $value ?: 'Choose file' }}</label>
    </div>
    @if(!empty($publicValue) || (!empty($form) && is_callable([$form->getInstance(), 'getAttributeUrl']) && $publicValue = $form->getInstance()->getAttributeUrl($name)))
    <div class="input-group-append">
        <a href="{{ $publicValue }}" target="_blank">View</a>
    </div>
    @endif
</div>
<script type="text/javascript">
$(function() {
    $('#{{ !empty($id) ? $id : $name }}FileInput').change(function() {
        if(typeof this.files[0].name != 'undefined') {
            $('label[for={{ !empty($id) ? $id : $name }}FileInput]').html(this.files[0].name);
        }
    });
});
</script>