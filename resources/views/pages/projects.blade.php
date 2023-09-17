@extends('layouts.default')
@section('content')

    <h1>proects list:</h1>

    @foreach ($projects as $post)
{{--        {{  dd($post) }}--}}
        <tr>
            <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $post->title }}</td>
            <img src="{{ url('storage/'.$post->cover) }}" alt="">
        </tr>
    @endforeach
@stop
