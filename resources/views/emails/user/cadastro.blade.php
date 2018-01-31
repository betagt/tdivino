@extends('emails.emailtemplate')
@section('titulo')
    <h3 style="font-size: 24px; margin-top: 0"><strong>Seja bem vindo, {{ucfirst($data['name'])}}</strong></h3>
@endsection
@section('content')
    <p style="margin: 15px 0; font-size: 18px">É com muita satisfação que lhe damos boas vindas a levez, e esperamos que neste ambiente feito especialmente
        para você, lhe proporcione bons negócios</p>

@endsection