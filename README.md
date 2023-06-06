# Keresés a "Lechner-es" névjegyzékekben

## Miért született ez a "webalkalmazás"...? 

Aki napi szinten keresgél az "[ingatlanrendezői névjegyzék publikus változatában](https://lechnerkozpont.hu/oldal/ingatlanrendezoi-nevjegyzek-publikus-valtozata), vagy [az aktuális földmérő igazolványok publikus listájában](https://lechnerkozpont.hu/oldal/foldmero-igazolvanyok-publikus-listaja), az nap, mint nap többször is szembesül azzal, hogy a két jegyzékben történő azonos paraméterek szerinti, párhuzamos keresgélés egyáltalán nem hatékony.
Ennkek a kezelésére született az itt bemutatott megoldás, mely a két jegyzékben párhuzamosan keres és az oldalak által adott eredméynt egyetlen lapon megjeleníti.

## Előfeltételek

A webalkalmazás működéséhez gyakorlatilag csak egy "PHP képes" webszerverre van szükség. Talán a legegyszerűbb lehetőség erre a [XAMPPP](https://www.apachefriends.org/hu/index.html) letöltése és telepítése, mely során elegendő az Apache és a PHP összetevőt megjelölni. *(Amennyiben az adott gépen felhasználóként nincs jogosultság programok telepítésre, használahatóak a "portable" verziók is.)*
Fontos tudni, hogy az alkalmazás igényli a php.ini-ben a következő beállításokat:
* "allow_url_fopen = On" *(Ennek hiányában "Failed to open stream: No such file or directory in ..." hibaüzenetet kapunk)*
* "extension=openssl" sor aktiválása *(Feltéve, hogy https protokolt is szeretnénk használni, mert ennek hiányában "Unable to find the wrapper 'https'..." hibaüzenetet kapunk)*

## Használat

Az alkalmazás "telepítése" annyiból áll, hogy a webszerever kezdőkönyvtárába be kell másolni a 2 db HTML, illetve 1 db PHP fájlt. *(Természetesen más módon is működhet a dolog, csak akkor több helyen kell, többféle beállítással variálni.)*
Ha a webszerver fut *(elegendő a helyi gépen futnia, azaz a "localhost"-on)*, akkor egy böngészővel fel kell keresni a [http://localhost](http://localhost) címet és ezt követően, ha az eredeti oldalakat valaki képes használni, akkor a dolog magától értetődik...
