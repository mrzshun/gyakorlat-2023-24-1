1. feladat
Írjunk egy PHP programot, amely generál egy nevet és egy hozzá tartozó email címet és ezt kiírja egy html dokumentum body részébe. Minden betöltésnél random nevet adjunk vissza.

Legyen 3 db. tömbünk: vezetéknevek, keresztnevek és email végződések. Generáljunk nevet Vezetéknév + Keresztnév random kiválasztásával és konkatenálásával, legyen ez a $name, majd ebből generáljunk email előtatot a keresztnév első betűje + vezetéknévből, emögé konkatenáljunk @-ot és random email végződést, legyen ez a $email.

2. feladat
Írjunk az előző feladat megoldásához egy alternatívát, ahol faker-t használunk a név és email cím generálására.

3. feladat
Generáljunk faker segítségével blogposztokat. Egy blogposzt álljon az alábbi adatokból:
ID - id
Cím - title
Szerző - author
Összefoglaló - description
Szöveg - text
Ezt másoljuk ki egy blogdata.json file-ba.

4. feladat
A fenti JSON-t használva készítsünk egy blog.php oldalt, amely ha nem kap GET paraméterként valid (a fájlban létező) id-t, akkor kilistázza az összes blogposztot (cím+bevezető+details link), egy linkkel a poszt végoldalára, amennyiben pedig GET paraméterként átadunk neki egy valid / létező id-t, akkor kiírja azt a blogposztot annak összes adatával.