<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if(isset($_COOKIE["visitas"])){
            $visitas = $_COOKIE["visitas"] + 1;
        } else {
          
            $visitas = 1;
        }
        
        setcookie("visitas", $visitas, time() + 30*24*60*60);
        
        echo "Essa é sua visita numero {$visitas} em nosso site";
        ?>
    </body>
</html>
