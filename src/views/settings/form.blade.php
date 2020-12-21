@extends('admin::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row pt-2 pb-2">
        <div class="col-sm-9"><h4 class="page-title">Settings</h4></div>
        <div class="col-sm-3">
            <div class="btn-group float-sm-right">
                @if(Auth::guard('admin')->user()->role->isAvailable('admin.settings.save'))
                <button type="button" class="btn btn-success waves-effect waves-light" onclick="$('#config-form').submit();">
                    <i class="fa fa-check-circle"></i>
                    <span>Save Config</span>
                </button>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form id="config-form" action="{{ route('admin.settings.save') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div id="settings-accordion">
                @if(count(config('settings', [])) )
                    @php
                        $settings = config('settings');
                        ksort($settings);
                    @endphp
                    @foreach($settings as $groupIndex => $groudData)
                        <div class="card mb-2">
                            <div class="card-header bg-secondary">
                                <button type="button" class="btn btn-link shadow-none text-white" data-toggle="collapse" data-target="#collapse-{{ $groupIndex }}" aria-expanded="false" aria-controls="collapse-{{ $groupIndex }}">
                                    {{ $groudData['label'] }}
                                </button>
                            </div>
                            <div id="collapse-{{ $groupIndex }}" class="collapse" data-parent="#settings-accordion">
                                <div class="card-body">
                                @foreach($groudData['fields'] as $index => $field)
                                    <div class="form-group row">
                                        <label for="{{ $groupIndex }}_{{ $index }}" class="col-sm-3 col-form-label">{{ $field['label'] }}</label>
                                        <div class="col-sm-9">
                                            @includeIf('admin::widget.form.field.' . $field['type'], [
                                                'id'          => $groupIndex . '_' . $index,
                                                'name'        => $groupIndex . '[' . $index . ']',
                                                'value'       => $field['type'] == 'rows' ? \Settings::getConfigValueArray($groupIndex . '/' . $index) : \Settings::getConfigValue($groupIndex . '/' . $index),
                                                'publicValue' => $field['type'] == 'image' ? \Settings::getConfigValueUrl($groupIndex . '/' . $index) : \Settings::getConfigValue($groupIndex . '/' . $index),
                                                'columns'     => !empty($field['columns']) ? $field['columns'] : [],
                                                'source'      => !empty($field['source']) ? $field['source'] : false,
                                            ])
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection