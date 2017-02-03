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
                                <p>
                                    <a href="{{ url('/admin/statistics/generals') }}" class="btn btn-default">Общая</a>
                                    <a href="{{ url('/admin/statistics/browsers') }}" class="btn btn-default">Браузеры</a>
                                    <a href="{{ url('/admin/statistics/os') }}" class="btn btn-default">Оси</a>
                                    <a href="{{ url('/admin/statistics/geos') }}" class="btn btn-default">Гео</a>
                                    <a href="{{ url('/admin/statistics/refs') }}" class="btn btn-default active">Рефы</a>
                                    <a href="{{ url('/admin/statistics/news') }}" class="btn btn-default">Новости</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Рефы</th>
                                        <th>Хиты</th>
                                        <th>Уники по ip</th>
                                        <th>Уники по кукам</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data as $item): ?>
                                    <tr>
                                        <td><?= $item['referer'] ?></td>
                                        <td><?= $item['hits'] ?></td>
                                        <td><?= $item['uniques_ip'] ?></td>
                                        <td><?= $item['uniques_cookie'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
