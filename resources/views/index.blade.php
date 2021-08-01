@extends('layouts.main')

@section('title')
    @if(auth()->check())
        | Select User
    @else
        | Sign in
    @endif
@endsection

@section('body')
    @if(auth()->check())
        <x-messenger-input :preview="true"/>
    @else
        <x-messenger-input :preview="true" :previewText="'Sign in to your account'"/>
    @endif
@endsection
