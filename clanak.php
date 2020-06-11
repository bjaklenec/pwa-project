<?php  
    session_start();
    if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
        header("location: login.php");
        exit;
    }
    $dbc = mysqli_connect('localhost', 'root', '', 'lobs'); 
    define ('UPLPATH', 'img/');
    $id = $_GET['id']; 
    $query = "SELECT * FROM clanci WHERE id = $id";
    $result = mysqli_query($dbc, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600&display=swap" rel="stylesheet">
    <title><?php while($row = mysqli_fetch_assoc($result)) {echo $row['naslov'];} ;?> | L'Obs</title>
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
                $id = $_GET['id']; 
                $query = "SELECT * FROM clanci WHERE id = $id";
                $result = mysqli_query($dbc, $query);
                while($row = mysqli_fetch_array($result)){
                    echo '<p class="kategorija">
                <span>'.$row['kategorija'].'</span></p>
            <h1 class="naslov_clanak">'.$row['naslov'].'</h1>
            <p class="info">AUTOR: '.$row['autor'].'</p>
            <p class="info">OBJAVLJENO: '.$row['datum'].'</p>

            <section class="slika_clanak">
               <img style="width:100%;" src="' . UPLPATH . $row['slika']. '">
            </section>
            <section class="sazetak">
                <hr>
                <br>
                <p style="text-align: center;">
                    '.$row['sazetak'].'
                </p>
                <br>
                <hr>
            </section>
            <section class="tekst_clanak">
                <p style="text-align: justify;">
                    '.$row['tekst'].'
                </p>
            </section>';
            }

            ;?>
        </div>

    </main>

    <footer>
        <p>L'Obs copyright 2020. Borna Jaklenec, bjaklenec@tvz.hr</p>
    </footer>
</body>

</html>