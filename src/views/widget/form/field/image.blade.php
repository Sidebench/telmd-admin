<div class="input-group">
    <div class="custom-file">
        @if(empty($readonly))
        <input type="hidden" name="{{ $name }}" value="{{ $value }}" />
        <input type="file" name="{{ $name }}[file]" class="custom-file-input" id="{{ !empty($id) ? $id : $name }}FileInput" value="{{ $value }}" />
        <label class="custom-file-label" for="{{ !empty($id) ? $id : $name }}FileInput">{{ $value ?: 'Choose file' }}</label>
        @endif
    </div>
    @if(!empty($publicValue))
    <div class="input-group-append">
        <a href="{{ $publicValue }}" target="_blank">
            <img src="{{ $publicValue }}" style="height: calc(2.25rem + 2px);" />
        </a>
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