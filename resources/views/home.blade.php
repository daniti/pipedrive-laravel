@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>Hi <b>{{Auth::user()->name}}</b></h3>
                        @if($data)
                            <h4>These are your deals:</h4>
                            <ul>
                                @foreach($data as $deal)
                                    <li>{{$deal->title}}</li>
                                @endforeach
                            </ul>
                        @else
                            No deals here...
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
