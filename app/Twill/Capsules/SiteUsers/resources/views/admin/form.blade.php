@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'email',
        'label' => 'Email',
        'maxlength' => 255,
        'disabled' => true
    ])
@stop
