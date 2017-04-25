<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" type="text/css" href="../lib/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="../lib/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../lib/css/formularios.css">
        <title>Lista - Usuários</title>
    </head>
    <body>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Nascimento</th>
                <th>Sexo</th>
                <th>Estado Civil</th>
                <th>Exatas</th>
                <th>Humanas</th>
                <th>Biológicas</th>
                <th>Hash da Senha</th>
            </tr>
            <?php
            require '../load.php';
            require '../class/Conn.php';           
            
            $conn = Conn::getConn();
            
            if(isset($_REQUEST["excluir"]) && $_REQUEST["excluir"] == TRUE){
                $stmt = $conn->prepare("delete from usuarios where id = ?");
                $stmt->bindParam(1, $_REQUEST["id"]);
                $stmt->execute();
                
                if($stmt->errorCode() != "00000"){
                    echo "Codigo de erro: {$stmt->errorCode()} :";
                    echo implode(", ", $stmt->errorInfo());
                } else {
                    echo "<div class='menssagemSucesso'><p>Usuário removido com sucesso</p></div>";
                }
            }

            $rs = $conn->prepare("select * from usuarios");

            if($rs->execute()){
                while ($registro = $rs->fetch(PDO::FETCH_OBJ)){
                    echo "<tr>";
                    echo "<td>{$registro->nome}</td>";
                    echo "<td>{$registro->email}</td>";
                    echo "<td>{$registro->dataNascimento}</td>";
                    echo "<td>{$registro->sexo}</td>";
                    echo "<td>{$registro->estadoCivil}</td>";
                    echo "<td>{$registro->exatas}</td>";
                    echo "<td>{$registro->humanas}</td>";
                    echo "<td>{$registro->biologicas}</td>";
                    echo "<td>{$registro->senha}</td>";
                    echo "<td>";
                    echo "<a class='btn btn-sm btn-danger' href='?excluir=true&id={$registro->id}'>Excluir</a>";
                    echo "<a class='btn btn-sm btn-success' href='alterar.php?id={$registro->id}'>Editar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "Não foi possivel consultar usuários!";
            }
            ?>
        </table>
        
        <a class="btn btn-success" href="formulario.php">Cadastrar um Novo Usuário</a>
        
        <script type="text/javascript" src="../lib/js/jquery.js"></script>
        <script type="text/javascript" src="../lib/js/bootstrap.min.js"></script>
    </body>
</html>
