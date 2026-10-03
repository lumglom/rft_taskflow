
### Funkcionális követelmények (User Story-k)

| Formátum: |  |
| --- | --- |
| **ID, Title** | US-01, Szabadszöveges keresés a feladatokban |
| **Description:** | As a projekt tag, I want feladatokra kulcsszó alapján keresni so that gyorsan megtaláljam a konkrét hibaüzeneteket vagy témákat. |
| **Acceptance criterias:** | Given a felhasználó a keresősávban van, when beír legalább 3 karaktert then a rendszer listázza a címben vagy leírásban egyező feladatokat. |

| Formátum: |  |
| --- | --- |
| **ID, Title** | US-02, Határidő (Due Date) beállítása |
| **Description:** | As a projekt tag, I want határidőt rendelni egy feladathoz so that a csapat lássa, mikorra kell befejezni az adott munkát. |
| **Acceptance criterias:** | Given a feladat szerkesztő nézete nyitva van, when a felhasználó kiválaszt egy jövőbeli dátumot a naptárból és menti then a dátum megjelenik a feladat kártyáján. |

### Nem funkcionális követelmények

* **Használhatóság (Usability):** A feladatkártyák "drag and drop" mozgatása a Kanban táblán teljesen reszponzív legyen, és érintőképernyőn (táblagépen, mobilon) is hibátlanul, akadásmentesen működjön.
* **Hordozhatóság:** A webes kliensfelület hiba nélkül jelenjen meg és működjön a legfrissebb Chrome, Firefox és Safari asztali böngészőkben (Windows, macOS, Linux rendszereken).
