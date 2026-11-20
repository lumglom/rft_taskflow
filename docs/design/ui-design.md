# TaskFlow – UI/UX User Flow és Wireframe Terv

## 1. User Flow: Új feladat létrehozása (US-01)

A folyamat bemutatja, hogyan jut el a projekt tag a projekt táblától az új feladat rögzítéséig, beleértve a kliens- és szerveroldali validációt is (teljesítve az `NFR-04` előírást: legfeljebb 3 fő felhasználói lépés).

```mermaid
flowchart TD
    Start([Projekt tag megnyitja a projekt nézetet]) --> Step1[1. Kattint az '+ Új feladat' gombra]
    Step1 --> Modal[Megnyílik az 'Új feladat' modális ablak]
    Modal --> Step2[2. Kitölti a Cím mezőt, opcionálisan a Leírást és Felelőst]
    Step2 --> Step3[3. Kattint a 'Létrehozás' gombra]
    Step3 --> ClientCheck{Cím ki van töltve<br/>és <= 120 karakter?}

    ClientCheck -- Nem --> ClientErr[Kliensoldali hibaüzenet a mező alatt]
    ClientErr --> Step2

    ClientCheck -- Igen --> ApiCall[POST /api/v1/projects/{id}/tasks]
    ApiCall --> ApiResp{Szerver válasz}

    ApiResp -- 201 Created --> CloseModal[Modális ablak bezárul]
    CloseModal --> UpdateUI[Új kártya megjelenik a BACKLOG oszlop tetején]
    UpdateUI --> End([Folyamat vége])

    ApiResp -- 403 Forbidden / 400 --> ServerErr[Hibaüzenet megjelenítése az ablakban]
    ServerErr --> Step2
```

---

## 2. Wireframe vázlatok (Low-Fidelity)

### 2.1 Projekt Kanban Tábla nézet (Főképernyő)

```text
+---------------------------------------------------------------------------------------------------+
|  TaskFlow   |  Projekt: Website Redesign v  |  Szűrő: [ Státusz v ] [ Felelős v ]   [+ Új feladat] |
+---------------------------------------------------------------------------------------------------+
|                                                                                                   |
|  +-----------------------+  +-----------------------+  +-----------------------+  +-------------+ |
|  | BACKLOG (2)           |  | IN PROGRESS (1)       |  | REVIEW (1)            |  | DONE (1)    | |
|  +-----------------------+  +-----------------------+  +-----------------------+  +-------------+ |
|  | +-------------------+ |  | +-------------------+ |  | +-------------------+ |  | +---------+ | |
|  | | Login validáció   | |  | | API végpontok     | |  | | Adatbázis séma    | |  | | Repo init | | |
|  | | Felelős: Anna     | |  | | Felelős: Béla     | |  | | Felelős: Anna     | |  | | Felelős: -| | |
|  | | [Státusz váltás v]| |  | | [Státusz váltás v]| |  | | [Státusz váltás v]| |  | |           | | |
|  | +-------------------+ |  | +-------------------+ |  | +-------------------+ |  | +---------+ | |
|  |                       |  |                       |  |                       |  |             | |
|  | +-------------------+ |  |                       |  |                       |  |             | |
|  | | Reszponzív menü   | |  |                       |  |                       |  |             | |
|  | | Felelős: Nincs    | |  |                       |  |                       |  |             | |
|  | | [Státusz váltás v]| |  |                       |  |                       |  |             | |
|  | +-------------------+ |  |                       |  |                       |  |             | |
|  +-----------------------+  +-----------------------+  +-----------------------+  +-------------+ |
+---------------------------------------------------------------------------------------------------+
```

### 2.2 „Új feladat létrehozása” modális ablak (Wireframe)

```text
          +-------------------------------------------------------+
          |  Új feladat létrehozása                           [X] |
          +-------------------------------------------------------+
          |                                                       |
          |  Feladat címe * (kötelező, max. 120 karakter)         |
          |  +---------------------------------------------------+ |
          |  | pl. Login oldal validáció javítása                | |
          |  +---------------------------------------------------+ |
          |  [!] A feladat címe nem lehet üres. (validációs hely) |
          |                                                       |
          |  Leírás (opcionális)                                  |
          |  +---------------------------------------------------+ |
          |  | Részletes leírás a feladathoz...                  | |
          |  |                                                   | |
          |  +---------------------------------------------------+ |
          |                                                       |
          |  Felelős kiválasztása (opcionális)                    |
          |  +---------------------------------------------------+ |
          |  | -- Válassz projekttagot --                      v | |
          |  +---------------------------------------------------+ |
          |                                                       |
          |                            [ Mégse ]  [ Létrehozás ]  |
          +-------------------------------------------------------+
```

---

## 3. UI elemek és API/Adatmodell megfeleltetés

| UI elem | Típus | Kapcsolódó adatmező / API | Működési szabály |
| :--- | :--- | :--- | :--- |
| **`+ Új feladat` gomb** | Action Button | Megnyitja a 2.2 modált | Csak bejelentkezett projekt tagnak aktív. |
| **Feladat címe** | Text Input | `TASK.title` (`POST .../tasks`) | Kötelező, üresen nem küldhető be. |
| **Leírás** | Textarea | `TASK.description` | Opcionális szöveges mező. |
| **Felelős** | Dropdown | `TASK.assignee_id` | Csak a projekt aktív tagjait (`PROJECT_MEMBER`) listázza. |
| **Státusz váltás** | Dropdown / Drag | `TASK.status` (`PATCH .../status`) | Azonnali állapotfrissítés a táblán. |