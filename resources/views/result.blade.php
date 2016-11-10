@extends('app')

@section('content')

    @include('partials.header')

    <ul class="results">
        @foreach ($results as $result)
            <li class="{{ $result['passed'] ? 'passed' : 'failed' }} {{ str_slug($result['level']) }}">
                <span class="label">{{ $result['passed'] ? 'Passed' : $result['level'] }}</span>
                {!! md($result['message']) !!}
            </li>
        @endforeach
    </ul>

@stop
