<?php  

session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
        header("location: login.php");
        exit;
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
    <title>Unos vijesti | L'Obs'</title>
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
                <a href="logout.php" style="text-decoration: none;
                            color:#b9b9b9;">(Odjavi se)</a>
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
        <script>
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
                <h1 id="unos">Napišite novu vijest</h1><br><br>
                <form enctype="multipart/form-data" name="unos" action="unos.php" method="POST">
                    <div class="forma">
                        <label for="naslov">Naslov vijesti</label><br>
                        <input type="text" name="naslov" id="naslov"><br>
                        <span id="porukaNaslov" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="sazetak">Sažetak vijesti</label><br>
                        <textarea name="sazetak" id="sazetak" cols="20" rows="5"></textarea><br>
                        <span id="porukaSazetak" style="color: red;"></span>
                        <br><br>
                    </div>


                    <div class="forma">
                        <label for="tekst">Tekst vijesti</label><br>
                        <textarea name="tekst" id="tekst" cols="30" rows="20"></textarea><br>
                        <span id="porukaTekst" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="kategorija">Kategorija vijesti</label><br>
                        <select name="kategorija" id="kategorija">
                            <option disabled selected value>Odaberite
                                kategoriju</option>
                            <option value="Glazba">Glazba</option>
                            <option value="Sport">Sport</option>
                        </select><br>
                        <span id="porukaKategorija" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="slika">Odaberite sliku</label><br>
                        <input type="file" id="slika" class="input-file" name="slika" accept="image"><br>
                        <span id="porukaSlika" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="autor">Autor</label><br>
                        <input type="text" name="autor" id="autor"><br>
                        <span id="porukaAutor" style="color: red;"></span>
                        <br><br>
                    </div>

                    <div class="forma">
                        <label for="prikaz">Spremi u arhivu</label>
                        <input type="checkbox" name="arhiva" id="arhiva"><br>
                        <span id="prikaz"></span><br><br>

                        <button id="gumb" class="button" type="submit">Pošalji</button><br><br><br><br>
                    </div>
                </form>
            </div>
        </div>

        <script type="text/javascript">
        document.getElementById("gumb").onclick = function(event) {
            var slanje_forme = true

            var poljeNaslov = document.getElementById("naslov")
            var naslov = poljeNaslov.value

            if (naslov.length < 5 || naslov.length > 30) {
                slanje_forme = false;
                poljeNaslov.style.border = "1px dashed red"
                document.getElementById("porukaNaslov").innerHTML = "Naslov mora imati između 5 i 30 znakova!"
            } else {
                poljeNaslov.style.border = "1px solid green"
                document.getElementById("porukaNaslov").innerHTML = ""
            }

            var poljeSazetak = document.getElementById("sazetak")
            var sazetak = poljeSazetak.value

            if (sazetak.length < 10 || naslov.length > 100) {
                slanje_forme = false;
                poljeSazetak.style.border = "1px dashed red"
                document.getElementById("porukaSazetak").innerHTML = "Sažetak mora imati između 10 i 100 znakova!"
            } else {
                poljeSazetak.style.border = "1px solid green"
                document.getElementById("porukaSazetak").innerHTML = ""
            }

            var poljeTekst = document.getElementById("tekst")
            var tekst = poljeTekst.value

            if (tekst.length == 0) {
                slanje_forme = false;
                poljeTekst.style.border = "1px dashed red"
                document.getElementById("porukaTekst").innerHTML = "Tekst mora biti unesen!"
            } else {
                poljeTekst.style.border = "1px solid green"
                document.getElementById("porukaTekst").innerHTML = ""
            }

            var poljeKategorija = document.getElementById("kategorija")

            if (document.getElementById("kategorija").selectedIndex == 0) {
                slanje_forme = false;
                poljeKategorija.style.border = "1px dashed red"
                document.getElementById("porukaKategorija").innerHTML = "Kategorija mora biti odabrana!"
            } else {
                poljeKategorija.style.border = "1px solid green"
                document.getElementById("porukaKategorija").innerHTML = ""
            }

            var poljeSlika = document.getElementById("slika")
            var slika = poljeSlika.value

            if (slika.length == 0) {
                slanje_forme = false;
                poljeSlika.style.border = "1px dashed red"
                document.getElementById("porukaSlika").innerHTML = "Slika mora biti odabrana!"
            } else {
                poljeSlika.style.border = "1px solid green"
                document.getElementById("porukaSlika").innerHTML = ""
            }

            var poljeAutor = document.getElementById("autor")
            var autor = poljeAutor.value

            if (autor.length == 0) {
                slanje_forme = false;
                poljeAutor.style.border = "1px dashed red"
                document.getElementById("porukaAutor").innerHTML = "Ime autora mora biti uneseno!"
            } else {
                poljeAutor.style.border = "1px solid green"
                document.getElementById("porukaAutor").innerHTML = ""
            }

            if (slanje_forme != true) event.preventDefault()
        }
        </script>
    </main>

    <footer>
        <p>L'Obs copyright 2020. Borna Jaklenec, bjaklenec@tvz.hr</p>
    </footer>
</body>

</html>