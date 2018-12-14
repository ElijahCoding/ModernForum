@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include ('threads._list')

                {{ $threads->render() }}
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Trending threads
                    </div>

                    <div class="panel-body">
                        fda
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
