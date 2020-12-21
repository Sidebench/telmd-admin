<div class="card-header text-uppercase">{{ $form->getTitle() }}</div>
<div class="card-body">
    <form id="edit-form" action="{{ $form->getFormAction() }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div id="form-vertical">
            @foreach($form->getFields() as $group => $fields)
                <h3>{{ $form->getGroupLabel($group) }}</h3>
                <section>
                @foreach($fields as $field)
                    @if($field['type'] == 'hidden')
                        @includeIf('admin::widget.form.field.' . $field['type'], $field)
                    @else
                        <div class="form-group">
                            <label for="basic-{{ $field['type'] }}">
                                {{ $field['label'] }}
                                @if(!empty($field['required']))
                                <em class="text-danger">*</em>
                                @endif
                            </label>
                            @if(View::exists('admin.widget.form.field.' . $field['type']))
                                @include('admin.widget.form.field.' . $field['type'], $field)
                            @else
                                @includeIf('admin::widget.form.field.' . $field['type'], $field)
                            @endif
                            @if(!empty($field['note']))
                                <small class="text-muted">{{ $field['note'] }}</small>
                            @endif
                        </div>
                    @endif
                @endforeach
                </section>
            @endforeach
        </div>
        {!! $form->getAfterFormHtml() !!}
    </form>
</div>
<script type="text/javascript">
$(function() {
    $("#edit-form").validate();
});
</script>
@includeIf('admin::widget.confirmation')
