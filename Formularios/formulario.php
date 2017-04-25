<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" type="text/css" href="../lib/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="../lib/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../lib/css/formularios.css">
        <title>View : Formulario </title>
    </head>
    <body>
        <?php
        require '../load.php';
        require '../class/Conn.php'; 
        
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $erro = null;
        $valido = FALSE;
        //var_dump($post["estadocivil"]);
        if (isset($_REQUEST["validar"]) && $_REQUEST["validar"] == TRUE) {
            if (strlen(utf8_decode($post["nome"])) < 3) {
                $erro = "O nome deve ter mais que 3 caracters e não pode fica vazio!";
            } elseif (empty($post["email"])) {
                $erro = "Preencha o email!";
            } elseif (empty($post["dataNascimento"])) {
                $erro = "Qual sua Data de Nascimento?";
            } elseif (empty($post["sexo"])) {
                $erro = "Qual seu Sexo?";
            } elseif ($post["estadoCivil"] != "Solteiro(a)" && $post["estadoCivil"] != "Casado(a)" && $post["estadoCivil"] != "Divorciado(a)" && $post["estadoCivil"] != "Viúvo(a)") {
                $erro = "Qual seu Estado Civil?";
            } elseif (empty($post["senha"])) {
                $erro = "Digite sua senha!";
            } elseif ($post["senha"] != $post["rsenha"]) {
                $erro = "A Confirmação de Senha está diferente!";
            } else {
                $valido = TRUE;                         
            
                $conn = Conn::getConn();
                
                $sql = "insert into usuarios (nome, email, dataNascimento, sexo, estadoCivil, exatas, humanas, biologicas, senha) values (?,?,?,?,?,?,?,?,?)";
                
                $stmt = $conn->prepare($sql);
                
                $stmt->bindParam(1, $post["nome"]);
                $stmt->bindParam(2, $post["email"]);
                $stmt->bindParam(3, $post["dataNascimento"]);
                $stmt->bindParam(4, $post["sexo"]);
                $stmt->bindParam(5, $post["estadoCivil"]);
                
                $checkExaxtas = isset($post["exatas"]) ? 1 : 0;
                $stmt->bindParam(6, $checkExaxtas);
                $checkHumanas = isset($post["humanas"]) ? 1 : 0;
                $stmt->bindParam(7, $checkHumanas);
                $checkBiologicas = isset($post["biologicas"]) ? 1 : 0;
                $stmt->bindParam(8, $checkBiologicas);
                
                $stmt->bindParam(9, $post["senha"]);
                
                $stmt->execute();
                
                if($stmt->errorCode() != "00000"){
                    $valido = FALSE;
                    $erro = "Erro Código: {$stmt->errorCode()}:";
                    $erro .= implode(", ", $stmt->errorInfo());
                }
            }
        }
        ?>
        <div class="container">
            <div class="container_box">
                <?php if($valido == TRUE){ ?>
                <div class="menssagemSucesso" id="idMessagem">
                    <?php echo "<p>Dados Enviados com Sucesso!</p><br/>"; ?>
                    <a class="btn btn-success" href="lista.php">Listar Usuários</a>
                </div>
                <?php } else { if(isset($erro)){?>
                <div class="erroMessagem" id="idMessagem">
                    <?php echo "<p>{$erro}</p>"; ?>
                </div>    
                <?php } ?>
                
                <form method="post" action="?validar=true">
                    <fieldset>
                        <legend>Cadastro de Usuário</legend>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="nome">Nome</label>
                                <input class="form-control" type="text" name="nome" id="idNome" <?php if(isset($post["nome"])){ echo "value='{$post["nome"]}'";} ?>>
                            </div>
                            <div class="col-sm-12">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="idEmail" <?php if(isset($post["email"])){ echo "value='{$post["email"]}'";} ?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="dataNascimento">Data de Nascimento</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">                                
                                <input class="form-control" type="date" name="dataNascimento" id="idDataNascimento" <?php if(isset($post["dataNascimento"])){ echo "value='{$post["dataNascimento"]}'";} ?>>
                            </div>
                            <div class="col-sm-5">
                                <label for="sexo">Sexo: </label>
                                <div class="radio-inline">
                                    <input type="radio" name="sexo" id="idMasculino" value="M" <?php if(isset($post["sexo"]) && $post["sexo"] == "M"){ echo 'checked';} ?>><label>Masculino</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" name="sexo" id="idFeminino" value="F" <?php if(isset($post["sexo"]) && $post["sexo"] == "F"){  echo 'checked';} ?>><label>Feminino</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="estadoCivil">Estado Civil:  </label>
                                <select class="input-sm" name="estadoCivil">
                                    <option>Selecione...</option>
                                    <option <?php if(isset($post["estadoCivil"]) && $post["estadoCivil"] == "Solteiro(a)"){ echo "selected";} ?>>Solteiro(a)</option>
                                    <option <?php if(isset($post["estadoCivil"]) && $post["estadoCivil"] == "Casado(a)"){ echo "selected";} ?>>Casado(a)</option>
                                    <option <?php if(isset($post["estadoCivil"]) && $post["estadoCivil"] == "Divorciado(a)"){ echo "selected";} ?>>Divorciado(a)</option>
                                    <option <?php if(isset($post["estadoCivil"]) && $post["estadoCivil"] == "Viúvo(a)"){ echo "selected";} ?>>Viúvo(a)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="interece">Área de Interece:</label>
                                <label class="checkbox-inline"><input type="checkbox" name="exatas" <?php if(isset($post["exatas"])){ echo "checked";} ?>>Exatas</label>
                                <label class="checkbox-inline"><input type="checkbox" name="humanas" <?php if(isset($post["humanas"])){ echo "checked";} ?>>Humanas</label>
                                <label class="checkbox-inline"><input type="checkbox" name="biologicas" <?php if(isset($post["biologicas"])){ echo "checked";} ?>>Biologicas</label>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="senha">Senha</label>
                                <input class="form-control" type="password" name="senha" id="idSenha">
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="rsenha">Digite a Senha Novamente</label>
                                <input class="form-control" type="password" name="rsenha" id="idRsenha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 botao">
                                <input class="btn btn-success" type="submit" name="enviar" id="idEnviar" value="Cadastrar">
                            </div>
                        </div>
                    </fieldset>
                </form>
                      <?php } ?>
            </div>
        </div>
        <script type="text/javascript" src="../lib/js/jquery.js"></script>
        <script type="text/javascript" src="../lib/js/bootstrap.min.js"></script>
    </body>
</html>
