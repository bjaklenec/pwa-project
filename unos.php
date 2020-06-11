<?php
    session_start();
    if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
        header("location: login.php");
        exit;
    }

    $naslov = $_POST['naslov'];
    $sazetak = $_POST['sazetak'];
    $tekst = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $slika = $_FILES['slika']['name'];
    $autor = $_POST['autor'];
    $datum = date('d.m.Y. H:i');
    if(isset($_POST['arhiva'])){
        $arhiva = 1;
    }else{
        $arhiva = 0;
    }
    $target = 'img/' . $slika;
    move_uploaded_file($_FILES['slika']['tmp_name'], $target);
        
    $dbc = mysqli_connect('localhost', 'root', '', 'lobs'); 
    $query = "INSERT INTO clanci (datum, naslov, sazetak, tekst, slika, kategorija, arhiva, autor)
    VALUES ('$datum', '$naslov', '$sazetak', '$tekst', '$slika', '$kategorija', '$arhiva', '$autor')";
    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
    mysqli_close($dbc);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600&display=swap" rel="stylesheet">
    <title><?php if(isset($naslov)) echo $naslov ;?> | L'Obs</title>
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
            <p class="kategorija">
                <?php if(isset($kategorija)) echo $kategorija ;?>
            </p>
            <h1 class="naslov_clanak">
                <?php if(isset($naslov)) echo $naslov ;?>
            </h1>
            <p class="info">AUTOR: <?php if(isset($autor)) echo $autor ;?></p>
            <p class="info">OBJAVLJENO: <?php echo $datum ;?></p>

            <section class="slika_clanak">
                <?php if(isset($slika)) echo "<img style='width:100%;' src='img/$slika'" ;?>
            </section>
            <section class="sazetak">
                <hr>
                <br>
                <p style="text-align: center;">
                    <?php if(isset($sazetak)) echo $sazetak ;?>
                </p>
                <br>
                <hr>
            </section>
            <section class="tekst_clanak">
                <p style="text-align: justify;">
                    <?php if(isset($tekst)) echo $tekst ;?>
                </p>
            </section>
        </div>

    </main>

    <footer>
        <p>L'Obs copyright 2020. Borna Jaklenec, bjaklenec@tvz.hr</p>
    </footer>
</body>

</html>