<?php
session_start();

if(isset($_SESSION['login']) && $_SESSION['login'] === true){
    header("location: index.php");
    exit;
}

if(isset($_POST['prijava'])){

        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $dbc = mysqli_connect('localhost', 'root', '', 'lobs');
        $sql = "SELECT user, pass, razina FROM korisnik WHERE user = ?";
        $stmt = mysqli_stmt_init($dbc);
        if(mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt, 's', $user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $ime, $hashed_pass, $razina);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($pass, $hashed_pass)){
                        session_start();
                        $_SESSION['login'] = true;
                        $_SESSION['razina'] = $razina;
                        $_SESSION['user'] = $user;
                        header("location:index.php");
                    }else{
                        $pass_error = "Pogrešna lozinka!";
                    }
                } 
            }else{
                $user_error = "Pogrešno korisničko ime!";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600&display=swap" rel="stylesheet">
    <title>Prijava | L'Obs</title>
</head>

<body>
    <header>

        <div class="clearfix">
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo.svg" style="width: 200px;" alt="">
                </a>
            </div>

        </div>

    </header>

    <hr>

    <main>
        <div class="wrapper">
            <div class="clearfix">
                <br>
                <h1 style="font-size: 30px; text-align:center; text-transform: uppercase;">Prijava</h1>
                <form enctype="multipart/form-data" action="login.php" method="POST">

                    <div class="forma">
                        <label for="user">Korisničko ime</label><br>
                        <input type="text" name="user" id="user"><br>
                        <span id="porukaUser" style="color: red;"></span>
                        <span style="color:red"><?php if(isset($user_error)){echo $user_error;} ?></span>
                        <br><br>

                    </div>

                    <div class="forma">
                        <label for="pass">Lozinka</label><br>
                        <input type="password" name="pass" id="pass"><br>
                        <span id="porukaPass" style="color: red;"></span>
                        <span style="color:red"><?php if(isset($pass_error)){echo $pass_error;} ?></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <button id="gumb" class="button" type="submit" name="prijava">Prijavi
                            se</button>
                    </div>
                </form>
                <br><br><br>
                <p style="text-align: center;">Nemate račun? <a style="text-decoration: none;"
                        href="registracija.php">Registrirajte se</a>.</p>
            </div>
        </div>
        <script type="text/javascript">
        document.getElementById("gumb").onclick = function(event) {
            var slanje_forme = true

            var poljeUser = document.getElementById("user")
            var user = poljeUser.value

            if (user.length < 3) {
                slanje_forme = false;
                poljeUser.style.border = "1px dashed red"
                document.getElementById("porukaUser").innerHTML = "Unesite korisničko ime!"
            } else {
                poljeUser.style.border = "1px solid green"
                document.getElementById("porukaUser").innerHTML = ""
            }

            var poljePass = document.getElementById("pass")
            var pass = poljePass.value

            if (pass.length == 0) {
                slanje_forme = false;
                poljePass.style.border = "1px dashed red"
                document.getElementById("porukaPass").innerHTML = "Unesite lozinku!"
            } else {
                poljePass.style.border = "1px solid green"
                document.getElementById("porukaPass").innerHTML = ""
            }

            if (slanje_forme != true) event.preventDefault()
        }
        </script>
    </main>

    <div class="footer">
        <footer>
            <p>L'Obs copyright 2020. Borna Jaklenec,
                bjaklenec@tvz.hr</p>
        </footer>
    </div>


</body>

</html>