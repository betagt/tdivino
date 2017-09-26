<!DOCTYPE html>
<html lang="pt-br" style="font-family: sans-serif; min-width: 485px">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="portal imobiliário qative tecnologia">
    <meta name="keywords" content="imoveis, alugar, comprar, casas, imobiliária, portal imobiliário, palmas, tocantins">
    <meta property="og:title" content="Portal qImob"/>
    <meta property="og:site_name" content="Portal qImob"/>
    <meta property="og:description" content="Uma nova experiência para encontrar o seu imovel"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="http://www.qimob.com.br/assets/img/og-qimob-thumbnail.jpg"/>
    <meta property="og:url" content="http://www.qimob.com.br"/>
    <link rel="icon" type="image/x-icon" href="http://www.qimob.com.br/assets/img/ico/favicon.png">
    <link rel="shortcut icon" href="http://www.qimob.com.br/assets/img/ico/favicon.png">
    <title>Portal qImob</title>

</head>

<body>
<div style="padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto">
    <div style="width: 100%; background-color: #f28111">
        <div class="header-top" style="display: flex; align-items: center; padding: 10px; font-size: 12px; width: 90%; margin: 0 auto">
            <div class="header-left" style="width: 50%; float: left; display: flex; align-items: center">
                <a href="tel:(63)%203225-7500" value="+556332257500" rel="noreferrer" target="_blank" style="color: #fff; text-decoration: none; font-size: 14px; margin-right: 30px">(63) 3225-7500</a>
                <!--<span style="color: #fff; margin-right: 10px; font-weight: bold">(63) 3225-7500</span>-->
                <a href="mailto:atendimento@qimob.com.br" target="_blank" style="color: #fff; text-decoration: none; font-size: 14px">atendimento@qimob.com.br</a>
                <!--<span style="color: #fff; margin-right: 10px; font-weight: bold">atendimento@qimob.com.br</span>-->
            </div>
            <div class="header-right" style="width: 50%; float: right">
                <ul style="display: inline-flex;padding: 0; float: right">
                    <li style="list-style-type: none">
                        <a href="https://www.facebook.com/qative" rel="noreferrer" target="_blank" style="color: rgb(255, 255, 255);position: relative;display: block;padding: 5px 10px;margin-left: 10px;text-decoration: none;background-color: rgb(247, 147, 30);" onmouseover="this.style.backgroundColor='#ce6905'" onmouseout="this.style.backgroundColor='#f7931e'">Facebook</a>
                    </li>
                    <li style="list-style-type: none">
                        <a href="https://www.instagram.com/qative" rel="noreferrer" target="_blank" style="color: rgb(255, 255, 255);position: relative;display: block;padding: 5px 10px;margin-left: 10px;text-decoration: none;background-color: rgb(247, 147, 30);" onmouseover="this.style.backgroundColor='#ce6905'" onmouseout="this.style.backgroundColor='#f7931e'">Instagram</a>
                    </li>
                    <li style="list-style-type: none">
                        <a href="https://www.linkedin.com/in/qative" rel="noreferrer" target="_blank" style="color: rgb(255, 255, 255);position: relative;display: block;padding: 5px 10px;margin-left: 10px;text-decoration: none;background-color: rgb(247, 147, 30);" onmouseover="this.style.backgroundColor='#ce6905'" onmouseout="this.style.backgroundColor='#f7931e'">Linkedin</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header" style="background-color: #f7931e">
            <div style="padding: 10px; height: 60px; display: flex; align-items: center; width: 90%;margin: 0 auto">
                <div class="header-left" style="width: 50%; float: left" >
                    <img alt="qAtive Tecnologia" class="img-logo" src="http://qative.com.br/wp-content/uploads/files/logo_qimob.png" style="width: 120px">
                </div>
                <div class="header-right" style="width: 50%; float: right">
                    <nav>
                        <ul class="nav nav-pills pull-right" style="display: inline-flex; float: right!important; padding-left: 0; margin-bottom: 0; list-style: none">
                            <li><a href="http://qimob.com.br" rel="noreferrer" target="_blank" style="color: #fff; position: relative; display: block; padding: 10px 15px; text-decoration: none"
                                   onMouseOver="this.style.backgroundColor='#f28111'" onMouseOut="this.style.backgroundColor='#f7931e'">qImob</a></li>
                            <li><a href="http://www.qimob.com.br/sobre-nos" rel="noreferrer" target="_blank"  style="color: #fff; position: relative; display: block; padding: 10px 15px; text-decoration: none"
                                   onMouseOver="this.style.backgroundColor='#f28111'" onMouseOut="this.style.backgroundColor='#f7931e'">Sobre nós</a></li>
                            <li><a href="http://www.qimob.com.br/fale-conosco" rel="noreferrer" target="_blank" style="color: #fff; position: relative; display: block; padding: 10px 15px; text-decoration: none"
                                   onMouseOver="this.style.backgroundColor='#f28111'" onMouseOut="this.style.backgroundColor='#f7931e'">Contato</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron" style="border-radius: 0 !important; margin: 0; padding: 30px 0; background-color: #eee">
        <div style="width: 90%; margin: auto">
            @yield('titulo')
        </div>
    </div>
    <div class="content" style="padding: 20px 0; background-color: #fdfdfd; width: 90%; margin: auto">
        @yield('content')
    </div>
    <footer>
        <div class="footer" style="padding: 20px; background-color: #787878; color: #fff; text-align: center">
            <img alt="qAtive Tecnologia" class="img-logo" src="http://qative.com.br/wp-content/uploads/files/logo_qative.png" style="width: 120px">
            <p style="line-height: 1; margin: 10px 0; font-size: 14px">106 Sul, Alameda 8, LT33. Plano Diretor Sul, Palmas - TO</p>
            <p style="line-height: 1; margin: 10px 0; font-size: 14px">CEP:77020-076 /
                <a href="tel:(63)%203225-7500" value="+556332257500" target="_blank" style="color: #fff; text-decoration: none"> (63) 3225-7500</a> - <a href="mailto:atendimento@qative.com.br" target="_blank" style="color: #fff; text-decoration: none">atendimento@qative.com.br</a></p>
        </div>
        <div class="footer-second" style="padding: 8px; background-color: #f7931e; color: #fff; text-align: center; font-size: 12px">
            <span class="copy-text">Copyright © 2017 <a href="http://qative.com.br/" rel="noreferrer" target="_blank" style="color: #626262">qAtive Tecnologia</a>&nbsp;|&nbsp;Todos os direitos reservados &nbsp;</span>
        </div>
    </footer>
</div>
</body>
</html>
