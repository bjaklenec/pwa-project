<?php  
    session_start();
    if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
        header("location: login.php");
        exit;
    }
    $dbc = mysqli_connect('localhost', 'root', '', 'lobs'); 
    define ('UPLPATH', 'img/');
    $kategorija = $_GET['id']; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600&display=swap" rel="stylesheet">
    <title><?php echo $kategorija ;?> | L'Obs</title>
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
            <div class="sredina">
                <section>
                    <?php 
                        $query = "SELECT * FROM clanci WHERE kategorija = '$kategorija' AND arhiva = 0 ORDER BY datum DESC";
                        $result = mysqli_query($dbc, $query);
                        while($row = mysqli_fetch_array($result)){
                            echo '<article>';
                            echo '<div class="img-container">';
                            echo '<div class="border">';
                            echo '<img class="in-img" src="' . UPLPATH . $row ['slika'] . '" style="width: 100%">';
                            echo '<div class="bijelo"><h3 class="tekst">';
                            echo '<a class="naslov_a" href="clanak.php?id='.$row['id'].'">';
                            echo $row['naslov'];
                            echo '</a></h3>';
                            echo '<p class="ispod_naslova">'.$row['datum'].'</p>';
                            echo '</div';
                            echo '</div></div>';
                            echo '</article>';
                        }
                    ?>
                    <div class="clearfix"></div>
                </section>
            </div>
        </div>
    </main>

    <div class="footer">
        <footer>
            <p>L'Obs copyright 2020. Borna Jaklenec,
                bjaklenec@tvz.hr</p>
        </footer>
    </div>


</body>

</html>