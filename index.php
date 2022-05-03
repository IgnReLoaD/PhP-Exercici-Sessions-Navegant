<?php
    session_start();
    $validacio = array("user_nom"=>"Administrador", "user_pass"=>"d099280fe056161c4e5a11002a8d4960");
                                                    // $usuariClau=MD5("12345"."HASH");
    $valor = '';
    $val_ok = '';

    // valida usuari i pass.
    if(isset($_POST['clauUsuari'])) {
        if(($_POST['nomUsuari']==$validacio['user_nom']) && (MD5($_POST['clauUsuari']."HASH")==$validacio['user_pass'])) {
            $_SESSION['logueado'] = 'SI';
            $_POST['pagina'] = 'private01';
            $val_ok = '';
        }else {
            $_POST['pagina'] = 'private01';
            $val_ok = 'ERROR';
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex"/>
    <meta name="keywords" content="IFCD0210, programacion web, HTML, CSS, PHP"/>
    <meta name="author" content="Curs Cet"/>
    <meta name="description" content="Cadenes de text"/>
    <link rel="stylesheet" href="./css/global.css" type="text/css">
    <title>Navegacio PHP</title>
  </head>

  <body>
    <br>
    <hr color= "blue">
    <h1>NAVEGACIO i VALIDACIO USUARI AMB PHP</h1>
    <section class="menu">
        <form action="index.php" method="post">
            <nav>
                <button type="submit" name="pagina" value="public01" style="background-color: #80ff80">
                    Pagina publica 1</button>
                <button type="submit" name="pagina" value="public02" style="background-color: #80ff80">
                    Pagina publica 2</button>
                <button type="submit" name="pagina" value="private01" style="background-color: #8080ff">
                    Pagina privada 1</button>
                <?php
                    // Mostra botons de pagina 2 i tencar sessio nomès si se està loguejat.
                    if(isset($_SESSION['logueado']) && $_SESSION['logueado'] == 'SI') {
                        echo
                        '<button type="submit" name="pagina" value="private02"style="background-color:
                            #8080ff">Pagina privada 2</button>';
                        echo
                        '<button type="submit" name="pagina" value="tencar_sessio" style="background-color:
                            #ff8080">Tencar sessio</button>';
                    }
                ?>
            </nav>
        </form>
    </section>
    <br>
    <hr color= "blue">
    <br>
    <div class="pantalla">
        <?php
            // Si han fet click a qualsevol boto.
            if(isset($_POST['pagina'])) {
                $pagina = $_POST['pagina'];
                // Pregunta per pagines publiques i carga contingut
                switch ($pagina) {
                    case 'public01':
                        $valor = "Pàgina PUBLICA 01";
                        break;
                    case 'public02':
                        $valor = "Pàgina PUBLICA 02";
                        break;
                }
                // Pregunta per pagines privades i carga contingut sols si esta loguejat l'usuari
                if(isset($_SESSION['logueado']) && $_SESSION['logueado'] == 'SI') {
                    switch ($pagina) {
                        case 'private01':
                            $valor = "Pàgina PRIVADA 01";
                            break;
                        case 'private02':
                            $valor = "Pàgina PRIVADA 02";
                            break;
                        case 'tencar_sessio':
                            session_unset();
                            session_destroy();
                            echo '<script type="text/JavaScript"> location.reload(); </script>';
                            break;
                    }
                }else{
                    // Cas contrari no esta loguejat i mostra formulari per validar-se.
                    if ($pagina == 'private01') {
                        echo '
                        <h2>Per veure les pàgines privades cal validar-se</h2>
                        <form class="valida_private" action="index.php" method="post">
                            <label for="nomUsuari">Usuari</label>
                            <input type="text" name="nomUsuari" required>
                            <label for="clauUsuari">Password</label>
                            <input type="password" name="clauUsuari" required>
                            <button type="submit" name="valida_private" value="valida_private">Validar</button>
                        </form>
                        ';
                        // Mostra error si la validació no es correcte.
                        if ($val_ok == 'ERROR'){
                            echo '<h2>USUARI o PASSWORD INCORRECTE</h2>';
                        }
                    }
                }
                // Presenta contingut de pagina.
                echo $valor;
            }
        ?>
    </div>
  </body>
</html>
