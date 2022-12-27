## IV Projeto integrador 

Neste projeto, juntamente com a equipe do 4° semestre em Administração, fizemos toda a parte de sistemas da empresa criada por eles, We.

O site é composto por um front-end impecavel e um back-end sensacional, utilizando as seguintes tecnologias:

<li>PHP</li>
<li>Laravel</li>
<li>JavaScript</li>
<li>HTML5</li>
<li>CSS</li>
<li>MySQL</li>
<li>PHPMyAdmin</li>

<body>

    <div class="container" id="container_index">
        <form method="post">
            @csrf
            <div class="imgcontainer">
            </div>
              
                <div class="container" id="login-wrap">
                    <div class="imgcontainer">
                    <img id="welogo" src="./img/logo_preta.svg" alt="img" class="img">
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <form class="container" id="emailSenha">
                        <label for="email"><b>Email:</b></label>
                        <input id="inputEmail" type="email" placeholder="E-mail" name="email" required>
    
                        <label for="senha" id="textSenha"><b>Senha:</b></label>
                        <input id="inputSenha" type="password" placeholder="••••••••••" name="senha" required>
                        <span id="olhoAberto" onclick="mostrarOcultarSenha()"><ion-icon name="eye-outline"></ion-icon></span>
                        <span id="olhoFechado" onclick="mostrarOcultarSenha()"><ion-icon name="eye-off-outline"></ion-icon></span>
                        
                        <input type="text" style="display: none" name="option" value="login">
                        <div id="esqueciSenha">
                            <a id="linkEsqueciSenha" style="float:right">Esqueci minha senha</a>
                        </div>
    
                        <button id="acessar" type="submit">Acessar</button>
                    </form>
                </div>
            </div>
        </form>
    </div>

</body>

    <form method='POST' style="display: none" >
        @csrf
        <input type="text" id="form_email" name="form_email">
        <input type="text" name="option" value="email">
        <button id="btnEmail" type="submit"></button>
    </form>
</html>


<script>
    $('#linkEsqueciSenha').on('click', function() {
        Swal.fire({
            title: 'Alterar senha',
            text: 'Informe seu E-Mail: ',
            input: 'email',
            confirmButtonText: 'Enviar',
            showLoaderOnConfirm: true,
        }).then((event) => {
            $('#form_email').val(event.value)
            document.getElementById('btnEmail').click();
        })
    })

    $('#olhoAberto').hide();

    function mostrarOcultarSenha(){
        var senha = document.getElementById('inputSenha');

        if(senha.type ==  "password"){
            senha.type = 'text';
            $('#olhoFechado').hide();
            $('#olhoAberto').show();
        }else{
            senha.type = 'password';
            $('#olhoAberto').hide();
            $('#olhoFechado').show();
        }
    }
</script>
