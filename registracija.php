<?php  

if(isset($_SESSION['login']) && $_SESSION['login'] === true){
    header("location: index.php");
    exit;
}

if(isset($_POST['gumb'])){
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $razina = 0;
    $hashed_pass = password_hash($pass, CRYPT_BLOWFISH);


    $dbc = mysqli_connect('localhost', 'root', '', 'lobs');
    $query = "SELECT * FROM korisnik WHERE user = ?";
    $stmt = mysqli_stmt_init($dbc);
    if(mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, 's', $user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    if(mysqli_stmt_num_rows($stmt) > 0) {
        $ime_error = "Korisničko ime se već koristi"; 
    }else{
        $query = "INSERT INTO korisnik (ime, prezime, user, pass, razina) 
        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($dbc);
        if(mysqli_stmt_prepare($stmt, $query)){
            mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $user, $hashed_pass, $razina);
            mysqli_stmt_execute($stmt);
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['razina'] = $razina;
            $_SESSION['user'] = $user;
            header("location:index.php");
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
    <title>Registracija | L'Obs</title>
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
                <h1 style="font-size: 30px; text-align:center; text-transform: uppercase;">Registracija</h1>
                <form enctype="multipart/form-data" action="registracija.php" method="POST">
                    <div class="forma">
                        <label for="ime">Ime</label><br>
                        <input type="text" name="ime" id="ime"><br>
                        <span id="porukaIme" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="prezime">Prezime</label><br>
                        <input type="text" name="prezime" id="prezime"><br>
                        <span id="porukaPrezime" style="color: red;"></span>
                        <br><br>
                    </div>


                    <div class="forma">
                        <label for="user">Korisničko ime</label><br>
                        <input type="text" name="user" id="user"><br>
                        <span id="porukaUser" style="color: red;"></span>
                        <span style="color:red"><?php if(isset($ime_error)){echo $ime_error;} ?></span>
                        <br><br>

                    </div>

                    <div class="forma">
                        <label for="pass">Lozinka</label><br>
                        <input type="password" name="pass" id="pass"><br>
                        <span id="porukaPass" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="pass2">Ponovite lozinku</label><br>
                        <input type="password" name="pass2" id="pass2"><br>
                        <span id="porukaPass2" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <button id="gumb" class="button" type="submit" name="gumb">Registriraj se</button>
                    </div>
                </form>
                <br><br><br>
                <p style="text-align: center;">Već ste registirani? <a style="text-decoration: none;"
                        href="login.php">Prijavite se</a>.</p>
            </div>
        </div>
        <script type="text/javascript">
        document.getElementById("gumb").onclick = function(event) {
            var slanje_forme = true

            var poljeIme = document.getElementById("ime")
            var ime = poljeIme.value

            if (ime.length == 0) {
                slanje_forme = false;
                poljeIme.style.border = "1px dashed red"
                document.getElementById("porukaIme").innerHTML = "Unesite ime!"
            } else {
                poljeIme.style.border = "1px solid green"
                document.getElementById("porukaIme").innerHTML = ""
            }

            var poljePrezime = document.getElementById("prezime")
            var prezime = poljePrezime.value

            if (prezime.length == 0) {
                slanje_forme = false;
                poljePrezime.style.border = "1px dashed red"
                document.getElementById("porukaPrezime").innerHTML = "Unesite prezime!"
            } else {
                poljePrezime.style.border = "1px solid green"
                document.getElementById("porukaPrezime").innerHTML = ""
            }

            var poljeUser = document.getElementById("user")
            var user = poljeUser.value

            if (user.length < 3) {
                slanje_forme = false;
                poljeUser.style.border = "1px dashed red"
                document.getElementById("porukaUser").innerHTML = "Korisničko ime treba imati minimalno 3 znaka!"
            } else {
                poljeUser.style.border = "1px solid green"
                document.getElementById("porukaUser").innerHTML = ""
            }

            var poljePass = document.getElementById("pass")
            var pass = poljePass.value

            if (pass.length < 5) {
                slanje_forme = false;
                poljePass.style.border = "1px dashed red"
                document.getElementById("porukaPass").innerHTML = "Lozinka treba imati minimalno 5 znakova!"
            } else {
                poljePass.style.border = "1px solid green"
                document.getElementById("porukaPass").innerHTML = ""
            }

            var poljePass2 = document.getElementById("pass2")
            var pass2 = poljePass2.value

            if (pass2 != pass) {
                slanje_forme = false;
                poljePass2.style.border = "1px dashed red"
                document.getElementById("porukaPass2").innerHTML = "Lozinke trebaju biti jednake!"
            } else {
                poljePass2.style.border = "1px solid green"
                document.getElementById("porukaPass2").innerHTML = ""
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