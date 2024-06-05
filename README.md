# Keresés a "Lechner-es" névjegyzékekben és a GEOSZAKI-ban

Aki napi szinten keresgél az [ingatlanrendezői névjegyzék publikus változatában](https://lechnerkozpont.hu/oldal/ingatlanrendezoi-nevjegyzek-publikus-valtozata), vagy [az aktuális földmérő igazolványok publikus listájában](https://lechnerkozpont.hu/oldal/foldmero-igazolvanyok-publikus-listaja), az nap, mint nap többször is szembesül azzal, hogy a két jegyzékben történő azonos paraméterek szerinti, párhuzamos keresgélés egyáltalán nem hatékony.
Hasonlóan problémás az [E-Ing földmérői névjegyzéke](geoszaki-portal.eing.foldhivatal.hu/), melyből sajnos nem derül ki a keresést követően azonnal, hogy az adott jogosultság, mettől, meddig érvényes. Ehhez az információhoz még legalább 2 kattintás szükséges *(miközben az adatok már a böngészőben vannak, a szem elől elrejtve)*, a túlzottan szellős megjelenítés miatti potenciális csúszka-használat mellett. *(Érthetetlen, hogy a weboldal megjelenése, miért nem alkalmazkodik a megjelenítőhőz...?)*

Ezen a problémának a kezelésére született az itt bemutatott megoldás, mely az első két jegyzékben párhuzamosan keres, a harmadikban egy lépésben mutatja az adatokat, majd az oldalak által adott eredményt egyetlen lapon megjeleníti.

Az alkalmazás ki is próbálható a [http://kjt.nhely.hu/nevjegyzek](http://kjt.nhely.hu/nevjegyzek) oldalon.

## Előfeltételek

A webalkalmazás működéséhez gyakorlatilag csak egy "PHP képes" webszerverre van szükség. Ennek beszerzésére az egyik legegyszerűbb lehetőség, a jelen oldalon lévő [Releases](https://github.com/kijato/nevjegyzek/releases) szekcióban elérhető minimalista futtatókörnyezet letöltése, de a teljes körű [XAMPP](https://www.apachefriends.org/)-pal is működnie kell az alkalmazásnak. Ez utóbbi telepítése során elegendő az Apache és a PHP összetevőt megjelölni. 
Fontos tudni, hogy az alkalmazás igényli a php.ini-ben a következő beállításokat:
* "allow_url_fopen = On" *(Ennek hiányában "Failed to open stream: No such file or directory in ..." hibaüzenetet kapunk)*
* "extension=openssl" sor aktiválása *(Erre akkor is szükség van, ha valójában nem is használunk SSL-t. Ennek hiányában "Unable to find the wrapper 'https'..." hibaüzenetet kapunk)*

Az minimalista futtatókörnyezetben előre "telepítve" van az alkalmazás. *(Az ebben lévő verziót nem tervezem naprakészen tartani!)* A használatához ki kell csomagolni a ZIP fájl tartalmát egy alkalmas helyre. Ha a főkönyvtár *-azaz az "Apache" könyvtár-* átnevezése szükségessé válik, vagy NEM A GYÖKÉRKÖNYVTÁRBA kerül a főkönyvtár, akkor a **\Apache\conf\serverroot.conf** fájlban meg kell adni az "ServerRoot" új elérési útját. *(A meghajtó betűjelet nem szükséges megadni. A szóközt is tartalmazó elérési utak nem javasoltak!)* Ha minden jól megy, akkor a szerver folyamat a **\Apache\start.bat** szkripttel elindul és a szerver, a böngésző címsorába a [http://localhost:8081](http://localhost:8081) címet írva, elérhető. A kezdőoldal a szerver dokumentumkönyvtára *(\Apache\htdocs)* lesz, ott a [nevjegyzek](http://localhost:8081/nevjegyzek/) linkre kell kattintani. A szervert leállítani az ablak bezárásával a legegyszerűbb.
Amennyiben az alapértelmezett 8081-as port valamiért foglalt, akkor a **Apache\conf\listen.conf** fájlban a "8081"-as értéket kell módosítani egy alapvetően tetszőleges _(1024-től 65535-ig lehet bármi, amit nem használ más folyamat)_ értékre, a szervert el/újraindítani és értelemszerűen ezután ezt a portszámot kell a címsorba írni.

## Használat

Az alkalmazás "telepítése" annyiból áll, hogy a webszerever kezdőkönyvtárába be kell másolni a 2 db HTML, illetve 1 db PHP fájlt. *(Erre a minimalista futtatókörnyezet használata esetén csak újabb verzió "telepítésekor" lehet szükség.)*
Ha a webszerver fut *(elegendő a helyi gépen futnia, azaz a "localhost"-on)*, akkor egy böngészővel fel kell keresni a [http://localhost:8081](http://localhost:8081) címet, majd ezt követően *(, ha az eredeti oldalakat valaki képes használni, akkor)* a dolog magától értetődik...
