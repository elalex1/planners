@extends('app')


@section('title', 'Error')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col s12">
                    <h5 class="card-title">Error</h5>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <p class="card-text">{{$data['error']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="">
                    <a href="{{$data['previous_url']}}"
                        class="btn waves-effect waves-light blue right">
                        Reintentar
                    </a>
                </div>
            </div>
            
        </div>
    </div>
@endsection
