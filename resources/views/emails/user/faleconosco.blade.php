@extends('emails.emailtemplate')
@section('titulo')
    <h3><strong> {{ucfirst($data['nome'])}} entrou em contato relatando:</strong></h3>
@endsection
@section('content')
<p style="margin: 14px 0; font-size: 16px">
    <strong>{{ucfirst($data['assunto'])}}</strong> <br /><br />

    <strong>E-mail:</strong> {{$data['email']}} <br />
    <strong>Telefone:</strong> {{$data['telefone']}} <br />
    <strong>Website:</strong> {{$data['website']}} <br /><br />
    {{$data['mensagem']}} <br />
</p>
@endsection