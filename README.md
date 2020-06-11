# pwa-project
Projekt za kolegij PWA

Projekt se sastoji od PHP file-a login.php preko kojeg se ulogiramo i koji nas zatim preusmjerava na naslovnicu index.php.
Ako nemamo racun, registriramo se na registracija.php te nas opet preusmjeri na naslovnicu.
Od tamo možemo pristupiti svakom clanku pojedinacno (clanak.php).
Kategorija.php ispisuje clanke iz kategorije koje smo odabrali (glazba ili sport).
Administracija.php sluzi za uredivanje clanaka, ali njoj imaju pristup samo administratori, odnosno korisnici koji u bazi imaju razinu 1.
Unos_vijesti.php sluzi za unos novih vijesti te ona salje formu na unos.php koja sprema clanak u bazu i prikazuje ga.
Xml-projekt.php je dio od XML projekta koji sluzi za unos recenzije albuma te sprema unos u Albumi.xml, a ako taj file ne postoji onda ga stvara.
Ako u navigaciji pritisnemo PREGLED XML, ona nam u novoj kartici ispisuje xml dokument sa svim unosima.
Logout.php je skripta kojom se prekida sesija i koja omogućava odjavu starog i prijavu novog korisnika.

Uz sami projekt prilazem i video koji objasnjava kako web stranica funkcionira.

