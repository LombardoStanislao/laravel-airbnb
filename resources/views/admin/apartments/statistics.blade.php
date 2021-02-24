@extends('layouts.dashboard')

@section('page-title', 'Statistiche appartamento')

@section('scripts')
    <script type="text/javascript" defer>
        var views = "{{ $views }}";
        var messages = "{{ $messages }}";
    </script>
@endsection


@section('content')
    <div id="statistics" class="container">
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <h1>Statistiche appartamento {{ $apartment_id }} relative a visualizzazioni e messaggi</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <canvas id="chart" :class="chartselected=='' ? 'd-block' : 'd-none'"></canvas>
                <canvas id="monthchart" :class="chartselected!='' ? 'd-block' : 'd-none'"></canvas>
                <div>
                    <label>Periodo:</label>
                    <select name="" @change="ChangeChartFilter($event)" v-model="chartselected">
                        <option value="">Da sempre</option>
                        <option v-for="view_labels in views_labels" :value="view_labels">@{{view_labels}}</option>
                    </select>
                    <label>Tipo:</label>
                    <select class="" name="" @change="changeChartType()" v-model="chartType">
                        <option value="line">Linea</option>
                        <option value="bar">Barra</option>
                        <option value="radar">Radar</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection
