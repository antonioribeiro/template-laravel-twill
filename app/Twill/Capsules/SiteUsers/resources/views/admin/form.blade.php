@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'name',
        'label' => 'Name',
        'maxlength' => 250,
    ])

    @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('input', [
                'name' => 'created_at_string',
                'label' => 'Created at',
                'disabled' => true,
            ])
        @endslot

        @slot('right')
            @formField('input', [
                'name' => 'updated_at_string',
                'label' => 'Last updated at',
                'disabled' => true,
            ])
        @endslot
    @endcomponent
@stop
