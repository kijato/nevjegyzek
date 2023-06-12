# Keresés a "Lechner-es" névjegyzékekben

Aki napi szinten keresgél az "[ingatlanrendezői névjegyzék publikus változatában](https://lechnerkozpont.hu/oldal/ingatlanrendezoi-nevjegyzek-publikus-valtozata), vagy [az aktuális földmérő igazolványok publikus listájában](https://lechnerkozpont.hu/oldal/foldmero-igazolvanyok-publikus-listaja), az nap, mint nap többször is szembesül azzal, hogy a két jegyzékben történő azonos paraméterek szerinti, párhuzamos keresgélés egyáltalán nem hatékony.
Ennek a problémának a kezelésére született az itt bemutatott megoldás, mely a két jegyzékben párhuzamosan keres és az oldalak által adott eredményt egyetlen lapon megjeleníti.

## Előfeltételek

A webalkalmazás működéséhez gyakorlatilag csak egy "PHP képes" webszerverre van szükség. Ennek beszerzésére az egyik legegyszerűbb lehetőség, a jelen oldalon lévő [Releases](https://github.com/kijato/nevjegyzek/releases) szekcióban elérhető minimalista futtatókörnyezet letöltése, de a teljes körű [XAMPP](https://www.apachefriends.org/)-pal is működnie kell az alkalmazásnak. Ez utóbbi telepítése során elegendő az Apache és a PHP összetevőt megjelölni. 
Fontos tudni, hogy az alkalmazás igényli a php.ini-ben a következő beállításokat:
* "allow_url_fopen = On" *(Ennek hiányában "Failed to open stream: No such file or directory in ..." hibaüzenetet kapunk)*
* "extension=openssl" sor aktiválása *(Erre akkor is szükség van, ha valójában nem is használunk SSL-t. Ennek hiányában "Unable to find the wrapper 'https'..." hibaüzenetet kapunk)*

Az minimalista futtatókörnyezetben előre "telepítve" van az alkalmazás. *(Az ebben lévő verziót nem tervezem naprakészen tartani!)* A használatához ki kell csomagolni a ZIP fájl tartalmát egy alkalmas helyre. *(Ha a főkönyvtár átnevezése szükségessé válik, akkor a **Apache\conf\serverroot.conf** fájlban meg kell adni az "ServerRoot" új elérési útját.)* Ha minden jól megy, akkor a szerver a **Apache\start.bat** szkripttel elindul és böngésző címsorába a [http://localhost:8081](http://localhost:8081) címet írva elérhető. A kezdőoldal a szerver dokumentumkönyvtára lesz, ott a [nevjegyzek](http://localhost:8081/nevjegyzek/) linkre kell kattintani. A szervert leállítani az ablak bezárásával a legegyszerűbb.
Amennyiben az alapértelmezett 8081-as port valamiért foglalt, akkor a **Apache\conf\listen.conf** fájlban a "8081"-as értéket kell módosítani egy alapvetően tetszőleges _(1024-től 65535-ig lehet bármi, amit nem használ más folyamat)_ értékre, a szervert el/újraindítani és értelemszerűen ezután ezt a portszámot kell a címsorba írni.

## Használat

Az alkalmazás "telepítése" annyiból áll, hogy a webszerever kezdőkönyvtárába be kell másolni a 2 db HTML, illetve 1 db PHP fájlt. *(Erre a minimalista futtatókörnyezet használata esetén csak újabb verzió "telepítésekor" lehet szükség.)*
Ha a webszerver fut *(elegendő a helyi gépen futnia, azaz a "localhost"-on)*, akkor egy böngészővel fel kell keresni a [http://localhost:8081](http://localhost:8081) címet, majd követően *(, ha az eredeti oldalakat valaki képes használni, akkor)* a dolog magától értetődik...
