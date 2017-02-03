@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Статистика</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group" role="group">
                                <a href="{{ url('/admin/statistics/generals') }}" class="btn btn-default">Общая</a>
                                <a href="{{ url('/admin/statistics/browsers') }}" class="btn btn-default">Браузеры</a>
                                <a href="{{ url('/admin/statistics/os') }}" class="btn btn-default">Оси</a>
                                <a href="{{ url('/admin/statistics/geos') }}" class="btn btn-default">Гео</a>
                                <a href="{{ url('/admin/statistics/refs') }}" class="btn btn-default">Рефы</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
