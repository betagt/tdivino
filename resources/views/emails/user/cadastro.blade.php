@extends('emails.emailtemplate')
@section('titulo')
    <h3 style="font-size: 24px; margin-top: 0"><strong>Seja bem vindo, {{ucfirst($data['name'])}}</strong></h3>
@endsection
@section('content')
    <p style="margin: 15px 0; font-size: 18px">É com muita satisfação que lhe damos boas vindas ao portal qImob, e esperamos que neste ambiente feito especialmente
        para você, lhe proporcione bons negócios</p>
    <p style="margin: 15px 0; font-size: 18px"><strong>Não perca tempo, anuncie agora mesmo</strong></p>
    <a class="btn" href="http://www.qimob.com.br/anuncio/cadastro" rel="noreferrer" target="_blank"  role="button" style="color: #fff; background-color: #5cb85c; border-color: transparent; padding: 10px 16px; font-size: 18px; line-height: 2; border-radius: 6px; text-decoration: none">Anunciar agora</a>
@endsection