### Dokumentacja Aplikacji Quizowej

Niniejsza dokumentacja szczegółowo opisuje strukturę, działanie oraz kluczowe komponenty aplikacji quizowej, zbudowanej na frameworku Laravel. Aplikacja została stworzona z myślą o prostocie zarządzania i spójności wizualnej, bazując na Bootstrapie.

---

#### 1. Podstawy Laravel i Routing

**Czym jest i jak działa:**
Aplikacja została zbudowana na frameworku **Laravel**, który dostarcza solidnej podstawy dla aplikacji webowych, w tym: ORM (Eloquent), system routingu, walidację formularzy i wiele innych. Struktura projektu jest zgodna ze standardami Laravela, co ułatwia rozwijanie i utrzymanie.

**Realizacja w projekcie:**
*   **Struktura projektu:** Pliki aplikacji są logicznie posegregowane w katalogach takich jak `app/Http` (kontrolery, middleware), `routes` (definicje tras), `resources/views` (szablony Blade), `database` (migracje, seedery, fabryki) oraz `public` (publicznie dostępne zasoby).
*   **Routing (trasy):** Trasy webowe aplikacji są zdefiniowane w pliku `routes/web.php`.
    *   **Strona główna (`/`):**
        ```php
        Route::get('/', function () {
            return view('home');
        })->name('welcome');
        ```
        Ta trasa mapuje główny adres URL (`/`) do widoku `home.blade.php`. Nazwa `welcome` pozwala na łatwe odwoływanie się do tej strony w kodzie (np. `route('welcome')`).
    *   **Lista quizów (`/quizzes`):**
        ```php
        Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
        ```
        Ta trasa kieruje żądanie na adres `/quizzes` do metody `index` w `App\Http\Controllers\QuizController`. Metoda ta pobiera wszystkie dostępne quizy z bazy danych i przekazuje je do widoku `quizzes.index.blade.php`.
    *   **Szczegóły quizu (`/quizzes/{quiz}`):**
        ```php
        Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
        ```
        Wyświetla szczegóły konkretnego quizu, identyfikowanego przez jego ID (`{quiz}`), używając metody `show` w `QuizController`.
    *   **Obsługa formularza quizu (`/quizzes/{quiz}/submit`):**
        ```php
        Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
        ```
        Przyjmuje odpowiedzi użytkownika z formularza quizu, przetwarza je i oblicza wynik.
    *   **Strona wyników (`/quizzes/{quiz}/results`):**
        ```php
        Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');
        ```
        Wyświetla wynik quizu dla użytkownika.
    *   **Trasy Uwierzytelniania (`Auth::routes()`):** Zapewniają gotowe trasy dla logowania, rejestracji, resetowania hasła i wylogowania.
    *   **Panel Administratora (`/admin/...`):**
        ```php
        Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
            Route::get('/dashboard', function () {
                return 'Admin Dashboard'; // Placeholder
            })->name('dashboard');
            Route::resource('quizzes', AdminQuizController::class);
            Route::resource('quizzes.questions', AdminQuestionController::class);
        });
        ```
        Ta grupa tras zawiera wszystkie funkcjonalności panelu administracyjnego. Jest chroniona przez middleware `auth` (wymagane zalogowanie) i `admin` (wymagane bycie administratorem). Używa `Route::resource` do automatycznego tworzenia tras CRUD dla quizów i pytań (zagnieżdżone).

---

#### 2. Modele Eloquent i Baza Danych (PDO)

**Czym jest i jak działa:**
Laravel wykorzystuje **Eloquent ORM** (Object-Relational Mapper), który pozwala na interakcję z bazą danych przy użyciu obiektów PHP, zamiast pisania surowego SQL. Pod spodem, do komunikacji z bazą danych, Laravel używa **PDO (PHP Data Objects)**.
**Migracje** to system kontroli wersji dla schematu bazy danych, a **Seeder’y** służą do wypełniania bazy danych danymi początkowymi.

**Realizacja w projekcie:**
*   **Modele Eloquent:**
    *   `app/Models/Quiz.php`: Reprezentuje tabelę `quizzes`. Definiuje relację `hasMany` do `Question`. Posiada `$fillable = ['title', 'description']` dla bezpiecznego masowego przypisywania.
    *   `app/Models/Question.php`: Reprezentuje tabelę `questions`. Definiuje relacje `belongsTo` do `Quiz` i `hasMany` do `Answer`. Posiada `$fillable = ['text', 'quiz_id']`.
    *   `app/Models/Answer.php`: Reprezentuje tabelę `answers`. Definiuje relację `belongsTo` do `Question`. Posiada `$fillable = ['text', 'is_correct', 'question_id']`.
*   **Migracje:**
    *   Pliki w `database/migrations` (np. `create_quizzes_table.php`, `create_questions_table.php`, `create_answers_table.php`) definiują strukturę tabel: kolumny (`id`, `title`, `description`, `text`, `is_correct`), ich typy danych oraz klucze obce (np. `question_id` w `answers`).
    *   Uruchamia się je za pomocą `php artisan migrate`.
*   **Seeder’y:**
    *   Plik `database/seeders/DatabaseSeeder.php` zawiera logikę wypełniania bazy danych danymi testowymi/początkowymi.
    *   Tworzy użytkownika testowego (`admin@example.com`), a następnie trzy quizy (HTML, CSS, Laravel) z odpowiednimi pytaniami i odpowiedziami (w tym oznaczenie poprawnej odpowiedzi).
    *   Seeder jest uruchamiany komendą `php artisan db:seed` lub `php artisan migrate:fresh --seed`.

---

#### 3. Widoki (Blade)

**Czym jest i jak działa:**
**Blade** to prosty, ale potężny silnik szablonów dostarczany przez Laravel. Pozwala na pisanie czytelnego kodu PHP w plikach HTML, ułatwiając tworzenie dynamicznych stron. Kluczową koncepcją są układy (layouts), które pozwalają na ponowne wykorzystanie kodu HTML.

**Realizacja w projekcie:**
*   **Główny układ (`resources/views/layouts/app.blade.php`):**
    *   Definiuje wspólną strukturę strony (nagłówek, nawigacja, stopka) dla całej aplikacji.
    *   Używa `@yield('content')` do wskazania miejsca, gdzie wstrzykiwana będzie unikalna zawartość podstron.
    *   Zawiera dynamiczne linki do logowania/rejestracji/wylogowania oraz warunkowy link do "Panelu Admina" widoczny tylko dla `admin@example.com`.
*   **Układ panelu admina (`resources/views/layouts/admin.blade.php`):**
    *   Podobny do głównego układu, ale z nawigacją dostosowaną do panelu administracyjnego (np. link do zarządzania quizami i powrót do strony głównej).
*   **Widoki quizów (`resources/views/quizzes/`):**
    *   `index.blade.php`: Wyświetla listę quizów w formie kart, dynamicznie generowanych na podstawie danych przekazanych z kontrolera (`$quizzes`).
    *   `show.blade.php`: Wyświetla pojedynczy quiz z pytaniami i odpowiedziami, osadzonymi w formularzu.
    *   `results.blade.php`: Prezentuje wynik quizu, dynamiczną wiadomość i procentowy wynik, bazując na danych z sesji.
*   **Widoki panelu admina (`resources/views/admin/`):**
    *   `quizzes/index.blade.php`: Wyświetla listę quizów w tabeli z opcjami edycji i usuwania.
    *   `quizzes/create.blade.php`: Formularz do dodawania nowego quizu.
    *   `quizzes/edit.blade.php`: Formularz do edycji quizu oraz lista pytań należących do tego quizu z opcjami zarządzania.
    *   `questions/create.blade.php`: Formularz do dodawania pytania i wielu odpowiedzi do konkretnego quizu.
    *   `questions/edit.blade.php`: Formularz do edycji pytania i wielu odpowiedzi.
*   **Przekazywanie danych:** Kontrolery przekazują dane do widoków za pomocą funkcji `compact()` (np. `view('...', compact('quizzes'))`).

---

#### 4. Formularze i Walidacja

**Czym jest i jak działa:**
Laravel oferuje rozbudowany system tworzenia formularzy i walidacji danych, co jest kluczowe dla bezpieczeństwa i integralności danych. Walidacja odbywa się po stronie serwera, co gwarantuje, że dane są poprawne zanim trafią do bazy danych.

**Realizacja w projekcie:**
*   **Formularz quizu (`quizzes/show.blade.php`):**
    *   Każde pytanie jest prezentowane z grupą przycisków radiowych (`<input type="radio">`) dla odpowiedzi. Nazwa `answers[ID_PYTANIA]` grupuje odpowiedzi dla danego pytania.
    *   Przycisk "Zatwierdź" przesyła formularz metodą `POST` do kontrolera.
    *   Dodano JavaScript, który pozwala na odznaczenie zaznaczonej odpowiedzi radiowej poprzez ponowne jej kliknięcie, co zwiększa elastyczność UX.
*   **Walidacja (`QuizController@submit`):**
    *   Kontroler dynamicznie buduje reguły walidacji, aby upewnić się, że użytkownik udzielił odpowiedzi na **każde** pytanie (`'answers.' . $question->id => 'required'`).
    *   Sprawdza również, czy przesłane ID odpowiedzi faktycznie istnieją w bazie (`'exists:answers,id'`).
    *   W przypadku błędu walidacji, użytkownik jest przekierowywany z powrotem do formularza, a jego wcześniej wybrane odpowiedzi są zachowywane (`old()`).
*   **Wyświetlanie błędów:**
    *   W widoku `quizzes/show.blade.php`, dyrektywa `@error('answers.' . $q->id)` wyświetla konkretne komunikaty o błędach bezpośrednio pod pytaniem, którego dotyczy błąd. Karta pytania jest również wizualnie oznaczana czerwoną ramką (`border-danger`).
*   **Zapamiętywanie odpowiedzi:** Użycie funkcji `old('answers.' . $q->id)` w atrybucie `checked` przycisków radiowych sprawia, że jeśli użytkownik wyśle formularz z błędami, jego wcześniej zaznaczone odpowiedzi zostaną automatycznie ponownie zaznaczone.
*   **Formularze Admina:** Formularze do dodawania/edycji quizów i pytań w panelu admina również korzystają z walidacji po stronie serwera, zapewniając integralność danych.

---

#### 5. CRUD dla Administratora dla Quizów i Pytań

**Czym jest i jak działa:**
CRUD (Create, Read, Update, Delete) to podstawowe operacje na danych. Panel administracyjny umożliwia zarządzanie quizami i ich pytaniami za pomocą tych operacji. System kontroli dostępu zapewnia, że tylko uprawnione osoby mogą modyfikować dane.

**Realizacja w projekcie:**
*   **Uwierzytelnianie (Authentication):**
    *   Zaimplementowano system logowania, rejestracji i wylogowania za pomocą pakietu `laravel/ui`.
    *   Użytkownik po zalogowaniu lub rejestracji jest przekierowywany na stronę główną (`/`).
*   **Autoryzacja (Authorization - kontrola dostępu):**
    *   Middleware `App\Http\Middleware\IsAdmin` chroni wszystkie trasy panelu administracyjnego.
    *   Logika middleware jest uproszczona: tylko użytkownik z adresem e-mail `admin@example.com` ma dostęp do panelu. Pozostali są przekierowywani na stronę główną.
*   **Kontrolery Panelu Admina:**
    *   `App\Http\Controllers\Admin\QuizController`: Obsługuje CRUD dla quizów (`index`, `create`, `store`, `edit`, `update`, `destroy`).
    *   `App\Http\Controllers\Admin\QuestionController`: Obsługuje CRUD dla pytań, które są zagnieżdżone w quizach (`create`, `store`, `edit`, `update`, `destroy`).
*   **Widoki Panelu Admina:**
    *   Strony `admin/quizzes/index.blade.php`, `admin/quizzes/create.blade.php`, `admin/quizzes/edit.blade.php` pozwalają na zarządzanie quizami.
    *   Strony `admin/questions/create.blade.php`, `admin/questions/edit.blade.php` (z dynamicznymi polami dla odpowiedzi) pozwalają na zarządzanie pytaniami i ich odpowiedziami w kontekście konkretnego quizu.
*   **Wyświetlanie wiadomości:** Po każdej operacji CRUD (utworzenie, edycja, usunięcie) system wyświetla komunikat sukcesu (flash message) na stronie listy.

---

#### 6. Zarządzanie Zasobami Front-end

**Czym jest i jak działa:**
Aplikacja wykorzystuje narzędzie **Vite** do kompilacji i pakowania zasobów front-end (CSS, JavaScript). Pozwala to na pisanie kodu w nowoczesnych standardach, a następnie optymalizację go dla przeglądarek.

**Realizacja w projekcie:**
*   **Pliki źródłowe:** CSS jest pisany w `resources/css/app.css` (importuje Bootstrap i zawiera własne style). JavaScript w `resources/js/app.js` (importuje Bootstrap JS i zawiera własny kod).
*   **Proces budowania:** Polecenie `npm run build` kompiluje te zasoby. Vite przetwarza pliki, łączy je, minifikuje i umieszcza w katalogu `public/build/assets` z unikalnymi nazwami plików (np. `app-Cso6OoMD.css`) dla lepszego buforowania. Tworzy również plik `public/build/manifest.json`, który mapuje oryginalne nazwy plików na te wygenerowane.
*   **Dołączanie zasobów:** Dyrektywa Blade `@vite(['resources/css/app.css', 'resources/js/app.js'])` w `layouts/app.blade.php` automatycznie dołącza odpowiednie, skompilowane pliki do strony, czytając ścieżki z `manifest.json`.
*   **Uproszczony Workflow:** Zamiast uruchamiania serwera deweloperskiego Vite (`npm run dev`), przyjęto uproszczony schemat: po każdej zmianie w zasobach front-endu należy jednorazowo uruchomić `npm run build`, a następnie odświeżyć stronę, aby zobaczyć zmiany.

---

#### 7. Najważniejsze Decyzje Projektowe i Uwag

*   **Prostota i spójność:** Priorytetem było utrzymanie kodu w prostocie i zgodności z Bootstrapem, unikając skomplikowanych bibliotek front-endowych.
*   **Bezpieczeństwo masowego przypisywania:** Dodanie `$fillable` do modeli Eloquent zapobiega lukom bezpieczeństwa związanym z masowym przypisywaniem.
*   **Intuicyjne komunikaty o błędach:** Walidacja formularzy i wyświetlanie błędów zostało zaprojektowane tak, aby było jak najbardziej zrozumiałe dla użytkownika (np. błędy pod konkretnym pytaniem).
*   **Łatwa rozbudowa:** Struktura projektu jest gotowa na dalszą rozbudowę, np. o zaawansowane role użytkowników czy bardziej rozbudowane widoki w panelu admina.

---

Ta dokumentacja powinna dać Ci pełny obraz tego, jak działa cała aplikacja i jakie technologie oraz wzorce zostały wykorzystane w jej budowie.