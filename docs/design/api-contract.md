# TaskFlow – API Szerződés (REST API Contract)

## 1. Általános konvenciók

* **Base URL:** `/api/v1`
* **Adatformátum:** `application/json` (UTF-8)
* **Hitelesítés:** Bearer Token (`Authorization: Bearer <jwt_token>`) minden védett végponton.
* **Általános hibakódok:**
    * `400 Bad Request` – Érvénytelen kérés vagy validációs hiba (pl. üres feladatcím).
    * `401 Unauthorized` – Hiányzó vagy érvénytelen hitelesítési token.
    * `403 Forbidden` – Hitelesített felhasználó, de nem tagja az adott projektnek (vagy nincs megfelelő szerepköre).
    * `404 Not Found` – A kért projekt vagy feladat nem létezik.

---

## 2. Publikus végpontok összefoglalója

| Metódus | Végpont (Endpoint) | Rövid leírás | Sikeres válasz | Megjegyzés / Üzleti szabály |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/projects` | Felhasználó projektjeinek listázása | `200 OK` | Csak azokat a projekteket adja vissza, amelyeknek a hívó tagja (`FR-01`). |
| `POST` | `/projects/{projectId}/tasks` | Új feladat létrehozása a projektben | `201 Created` | Csak projekt tag hívhatja (`US-01`). A kezdő státusz mindig `BACKLOG`. |
| `GET` | `/projects/{projectId}/tasks` | Projekt feladatainak listázása és szűrése | `200 OK` | Támogatott query paraméterek: `?status=...&assigneeId=...` (`US-06`, `NFR-01`). |
| `PATCH` | `/projects/{projectId}/tasks/{taskId}/status` | Feladat státuszának módosítása | `200 OK` | Csak projekt tag módosíthatja (`US-02`). Érvényes értékek: `BACKLOG`, `IN_PROGRESS`, `REVIEW`, `DONE`. |
| `PATCH` | `/projects/{projectId}/tasks/{taskId}` | Feladat adatainak / felelősének módosítása | `200 OK` | Az `assigneeId` csak a projekt aktív tagja lehet (`US-04`). |
| `POST` | `/projects/{projectId}/tasks/{taskId}/comments` | Megjegyzés hozzáadása feladathoz | `201 Created` | Csak projekt tag kommentelhet (`US-05`). |
| `POST` | `/projects/{projectId}/members` | Új tag hozzáadása a projekthez | `201 Created` | Kizárólag `OWNER` szerepkörrel hívható (`US-07`). |

---

## 3. Részletes szerződés a fő folyamathoz (Vertikális slice)

### 3.1 Új feladat létrehozása (`POST /api/v1/projects/{projectId}/tasks`)

**Request Body:**
```json
{
  "title": "Login oldal validáció javítása",
  "description": "Üres jelszó mező esetén jelenjen meg hibaüzenet.",
  "assigneeId": "550e8400-e29b-41d4-a716-446655440000"
}
```
*(A `description` és az `assigneeId` opcionális; a `title` kötelező, max. 120 karakter.)*

**Sikeres válasz (`201 Created`):**
```json
{
  "id": "9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d",
  "projectId": "123e4567-e89b-12d3-a456-426614174000",
  "title": "Login oldal validáció javítása",
  "description": "Üres jelszó mező esetén jelenjen meg hibaüzenet.",
  "status": "BACKLOG",
  "assigneeId": "550e8400-e29b-41d4-a716-446655440000",
  "createdBy": "7c9e6679-7425-40de-944b-e07fc1f90ae7",
  "createdAt": "2026-11-20T09:30:00Z"
}
```

**Hibaválasz példa (`400 Bad Request` – üres cím esetén):**
```json
{
  "error": "VALIDATION_ERROR",
  "message": "A feladat címe nem lehet üres.",
  "timestamp": "2026-11-20T09:30:05Z"
}
```

---

### 3.2 Feladat státuszának módosítása (`PATCH /api/v1/projects/{projectId}/tasks/{taskId}/status`)

**Request Body:**
```json
{
  "status": "IN_PROGRESS"
}
```

**Sikeres válasz (`200 OK`):**
```json
{
  "id": "9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d",
  "status": "IN_PROGRESS",
  "updatedAt": "2026-11-20T09:35:00Z"
}
```

