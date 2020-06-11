<?php  
    session_start();
    $dbc = mysqli_connect('localhost', 'root', '', 'lobs'); 
    define ('UPLPATH', 'img/');
    if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
        header("location: login.php");
        exit;
    }
    
    if(isset($_POST['delete'])){
            $id=$_POST['id'];
            $query = "DELETE FROM clanci WHERE id=$id";
            $result = mysqli_query($dbc, $query);
            }

            if(isset($_POST['update'])){
            $naslov = $_POST['naslov'];
            $sazetak = $_POST['sazetak'];
            $tekst = $_POST['tekst'];
            $kategorija = $_POST['kategorija'];
            $slika = $_FILES['slika']['name'];
            $autor = $_POST['autor'];
            $datum = date('d.m.Y. G:i');
            if(isset($_POST['arhiva'])){
            $arhiva = 1;
            }else{
            $arhiva = 0;
            }
            $target = 'img/' . $slika;
            move_uploaded_file($_FILES['slika']['tmp_name'], $target);

            $id = $_POST['id'];
            $query = "UPDATE clanci SET naslov = '$naslov', sazetak = '$sazetak', tekst = '$tekst',
            slika = '$slika', autor = '$autor', datum = '$datum', kategorija = '$kategorija', arhiva = '$arhiva'
            WHERE id = $id";
            $result = mysqli_query($dbc, $query);
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
    <title>Administracija | L'Obs</title>
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

            <?php
        if(isset($_SESSION['razina']) && $_SESSION['razina'] == 1){

            
            
   
            $query = "SELECT * FROM clanci ORDER BY datum DESC";
            $result = mysqli_query($dbc, $query);

            while($row = mysqli_fetch_array($result)){
            echo '<form enctype="multipart/form-data" action="administracija.php" method="POST">
                <div class="forma">
                    <label for="naslov">Naslov vijesti</label><br>
                    <input type="text" name="naslov" id="naslov" value="'.$row['naslov'].'"><br><br>
                </div>

                <div class="forma">
                    <label for="sazetak">Sažetak vijesti</label><br>
                    <textarea name="sazetak" id="sazetak" cols="20" rows="5">'.$row['sazetak'].'</textarea><br><br>
                </div>


                <div class="forma">
                    <label for="tekst">Tekst vijesti</label><br>
                    <textarea name="tekst" id="tekst" cols="30" rows="20">'.$row['tekst'].'</textarea><br><br>
                </div>

                <div class="forma">
                    <label for="kategorija">Kategorija vijesti</label><br>
                    <select name="kategorija" id="kategorija" value="'.$row['kategorija'].'">
                        <option disabled selected value>Odaberite
                            kategoriju</option>
                        <option value="Glazba">Glazba</option>
                        <option value="Sport">Sport</option><br>
                        </select><br>
                        <span id="porukaKategorija" style="color: red;"></span>
                        <br><br>
                </div>

                <div class="forma">
                    <label for="slika">Odaberite sliku</label><br>
                    <input type="file" id="slika" class="input-file" value="'.$row['slika'].'" name="slika"
                        accept="image"><br><br>
                    <img src="' . UPLPATH . $row['slika'] . '" width=25%>
                </div>

                <div class="forma">
                    <label for="autor">Autor vijesti</label><br>
                    <input type="text" name="autor" id="autor" value="'.$row['autor'].'"><br><br>
                </div>

                <div class="forma">
                    <label>Spremi u arhivu:<br><br>';
                        if($row['arhiva']==0){
                        echo '<input type="checkbox" name="arhiva" id="arhiva" /> Arhiviraj<br>';
                        }else{
                        echo '<input type="checkbox" name="arhiva" id="arhiva" checked />Arhiviraj<br>';
                        }
                        echo '</label>
                </div>

                <div class="forma">
                    <input type="hidden" name="id" class="input-file" value="'.$row['id'].'">
                    <button class="button2" type="reset" value="Poništi">Poništi</button>
                    <button class="button2" type="submit" name="update" id="gumb" value="Prihvati">Izmjeni</button>
                    <button class="button2" type="submit" name="delete" value="Izbriši">Izbriši</button><br><br><br><br>
                </div>
            </form>';

            }
        }else{
            echo '<br><br><p style="text-align: center;">Nemate pristup ovoj stranici!</p>';
        }
        ?>
        </div>

        <script type="text/javascript">
        document.getElementById("gumb").onclick = function(event) {
            var slanje_forme = true

            var poljeKategorija = document.getElementById("kategorija")

            if (document.getElementById("kategorija").selectedIndex == 0) {
                slanje_forme = false;
                poljeKategorija.style.border = "1px dashed red"
                document.getElementById("porukaKategorija").innerHTML = "Kategorija mora biti odabrana!"
            } else {
                poljeKategorija.style.border = "1px solid green"
                document.getElementById("porukaKategorija").innerHTML = ""
            }

            if (slanje_forme != true) event.preventDefault()
        }
        </script>
    </main>
    <br><br>
    <footer>
        <p>L'Obs copyright 2020. Borna Jaklenec, bjaklenec@tvz.hr</p>
    </footer>
</body>

</html>