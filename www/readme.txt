Olvass el :)

Ha telepíteni akarod a rendszert, nincs sok dolgod, csak az alábbi lépések végigvitele:
- 1. Adatbázis előkészítése
- 2. Adatbázis telepítése
- 3. Rendszerbeállítások megadása

1. Adatbázis előkészítése
- Csinálj egy mysql db-t a webhely alá
- Nyisd meg a "db" mappát, azon belül pedig a "db_connect.php" fájlt egy szerkesztőben (notepad, notepad++)
- Állítsd be a fájl első soraiban a db-nevet, usert, passwordot. A "localhost" marad.

2. Adatbázis telepítése
- Másold a "db" mappa tartalmát a webhelyre
- Nyisd meg egy böngészőben az "install_tables.php" fájlt. Ne aggódj, ha jelennek meg errorok, lekezeli.
- Töröld ki a db mappa tartalmát a webhelyről

3. Rendszerbeállítások megadása
- Nyisd meg a "config.php" fájlt egy szerkesztőben (notepad, notepad++)
- Állítsd be az első sorokban található dolgokat. Kérdezz :)
  - Google Map-hez kell két API id, (hagyhatod a mostanit) 
  - Facebook App id, (hagyhatod a mostanit)
  - Adatbázis dolgok (A "localhost" marad.)
  - Alapértelmezett url
- Másolj fel minden fájlt és mappát (kivéve a "db" mappát)