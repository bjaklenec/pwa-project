<?php  
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
        header("location: login.php");
        exit;
    }


if(isset($_POST['gumb'])){
$album = $_POST['album'];
    $izvodac = $_POST['izvodac'];
    $godina = $_POST['godina'];
    $zanr = $_POST['zanr'];
    $prijedlog = $_POST['prijedlog'];
    $ocjena = $_POST['ocjena'];
    
    $ispis = '';
    $ispis .= "<Album>\n";
    $ispis .= "<ImeAlbuma>" . $album . "</ImeAlbuma>\n";
    $ispis .= "<Izvodac>" . $izvodac . "</Izvodac>\n";
    $ispis .= "<Godina>" . $godina . "</Godina>\n";
    $ispis .= "<Zanr>" . $zanr . "</Zanr>\n";
    $ispis .= "<Prijedlog>" . $prijedlog . "</Prijedlog>\n";
    $ispis .= "<Ocjena>" . $ocjena . "</Ocjena>\n";
    $ispis .= "</Album>\n";

    $filename = 'Albumi.xml';
    if(file_exists($filename)){
        $dok = file_get_contents($filename);
        $dok = str_replace("</Albumi>\n", '', $dok);
        file_put_contents($filename, $dok);
        file_put_contents($filename, $ispis, FILE_APPEND);
        file_put_contents($filename,"</Albumi>\n",FILE_APPEND);
    }else{
        $file = '';
        $file .= "<?xml version='1.0' encoding='UTF-8' standalone='no' ?>\n";
$file .= "<Albumi>\n";
    $file .= $ispis;
    $file .= "</Albumi>\n";
file_put_contents($filename, $file);
}



}?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600&display=swap" rel="stylesheet">
    <title>XML | L'Obs</title>
</head>

<body>
    <header>

        <div class="clearfix">
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo.svg" style="width: 200px;" alt="">
                </a>
            </div>

            <p style="text-align: center;"><?php echo $_SESSION['user']; ?>
                <a href="logout.php" style="text-decoration: none; color:#b9b9b9;">(Odjavi se)</a>
            </p>

            <nav>
                <ul>
                    <div class="topnav" id="myTopnav">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="administracija.php">ADMINISTRACIJA</a></li>
                        <li><a href="kategorija.php?id=Glazba" class="">GLAZBA</a></li>
                        <li><a href="kategorija.php?id=Sport">SPORT</a></li>
                        <li><a href="unos_vijesti.php">UNOS VIJESTI</a></li>
                        <li><a href="xml-projekt.php">UNOS XML</a></li>
                        <li><a target="_blank" href="Albumi.xml">PREGLED
                                XML</a></li>
                        <li><a href="javascript:void(0);" class="icon" onclick="menu()">
                                <i class="fa fa-bars"></i>
                            </a></li>
                    </div>

                </ul>
            </nav>
        </div>
        <script type="text/javascript">
        function menu() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
        </script>
    </header>

    <hr>

    <main>
        <div class="wrapper">
            <div class="clearfix">
                <br><br>
                <h1 id="unos">Napišite recenziju albuma</h1><br><br>
                <form enctype="multipart/form-data" action="xml-projekt.php" method="POST">
                    <div class="forma">
                        <label for="album">Ime albuma</label><br>
                        <input type="text" name="album" id="album"><br>
                        <span id="porukaAlbum" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="izvodac">Izvođač</label><br>
                        <input type="text" name="izvodac" id="izvodac"><br>
                        <span id="porukaIzvodac" style="color: red;"></span>
                        <br><br>
                    </div>


                    <div class="forma">
                        <label for="godina">Godina izdanja</label><br>
                        <input type="number" name="godina" id="godina"><br>
                        <span id="porukaGodina" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="zanr">Žanr albuma</label><br>
                        <input type="text" name="zanr" id="zanr"><br>
                        <span id="porukaZanr" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="prijedlog">Predlažete li album</label><br>
                        <select name="prijedlog" id="prijedlog">
                            <option disabled selected value>Odaberite
                                kategoriju</option>
                            <option value="Predlažem">Da</option>
                            <option value="Ne predlažem">Ne</option>
                        </select><br>
                        <span id="porukaPrijedlog" style="color: red;"></span><br><br>
                    </div>

                    <div class="forma">
                        <label for="ocjena">Vaša ocjena albuma</label><br>
                        <input type="range" min="1" max="5" step="1" class="slider" name="ocjena" id="ocjena"><br>
                        <span id="prikaz"></span><br><br>
                        <button id="gumb" class="button" type="submit" name="gumb">Spremi
                            kao XML</button>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        document.getElementById("gumb").onclick = function(event) {
            var slanje_forme = true

            var poljeAlbum = document.getElementById("album")
            var album = poljeAlbum.value

            if (album.length == 0) {
                slanje_forme = false;
                poljeAlbum.style.border = "1px dashed red"
                document.getElementById("porukaAlbum").innerHTML = "Unesite ime albuma!"
            } else {
                poljeAlbum.style.border = "1px solid green"
                document.getElementById("porukaAlbum").innerHTML = ""
            }

            var poljeIzvodac = document.getElementById("izvodac")
            var izvodac = poljeIzvodac.value

            if (izvodac.length == 0) {
                slanje_forme = false;
                poljeIzvodac.style.border = "1px dashed red"
                document.getElementById("porukaIzvodac").innerHTML = "Unesite ime izvođača!"
            } else {
                poljeIzvodac.style.border = "1px solid green"
                document.getElementById("porukaIzvodac").innerHTML = ""
            }

            var poljeGodina = document.getElementById("godina")
            var godina = poljeGodina.value

            if (godina < 1900 || godina > 2100) {
                slanje_forme = false;
                poljeGodina.style.border = "1px dashed red"
                document.getElementById("porukaGodina").innerHTML = "Unesite valjanu godinu!"
            } else {
                poljeGodina.style.border = "1px solid green"
                document.getElementById("porukaGodina").innerHTML = ""
            }

            var poljeZanr = document.getElementById("zanr")
            var zanr = poljeZanr.value

            if (zanr.length == 0) {
                slanje_forme = false;
                poljeZanr.style.border = "1px dashed red"
                document.getElementById("porukaZanr").innerHTML = "Unesite žanr albuma!"
            } else {
                poljeZanr.style.border = "1px solid green"
                document.getElementById("porukaZanr").innerHTML = ""
            }

            var poljePrijedlog = document.getElementById("prijedlog")

            if (document.getElementById("prijedlog").selectedIndex == 0) {
                slanje_forme = false;
                poljePrijedlog.style.border = "1px dashed red"
                document.getElementById("porukaPrijedlog").innerHTML = "Odaberite jednu od opcija!"
            } else {
                poljePrijedlog.style.border = "1px solid green"
                document.getElementById("porukaPrijedlog").innerHTML = ""
            }

            if (slanje_forme != true) event.preventDefault()
        }
        </script>
    </main>

    <script type="text/javascript">
    var ocjena = document.getElementById("ocjena")
    var prikaz = document.getElementById("prikaz")
    prikaz.innerHTML = ocjena.value

    ocjena.oninput = function() {
        prikaz.innerHTML = this.value
    }
    </script>
    <div class="footer">
        <footer>
            <p>L'Obs copyright 2020. Borna Jaklenec,
                bjaklenec@tvz.hr</p>
        </footer>
    </div>


</body>

</html>