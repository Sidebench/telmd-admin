@extends('admin::layouts.app')

@section('content')
<div class="container-fluid form">
    <div class="row pt-2 pb-2">
        <div class="col-sm-12">
            <div class="btn-group float-sm-right">
            @foreach ($form->getButtons() as $data)
                @includeIf('admin::widget.button', $data)
            @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                @include('admin::widget.form.content')
            </div>
        </div>
    </div>
</div>
@endsection