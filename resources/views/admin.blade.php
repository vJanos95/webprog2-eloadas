<x-mainpage>
    <h1>Adminisztráció</h1>

    <p>
        Az adminisztrációs felületen kezelheted az alkalmazás adatait
        és felhasználóit.
    </p>

    <h2>Felhasználók</h2>

    <p>
        Itt megtekintheted, létrehozhatod, módosíthatod és törölheted
        a rendszer felhasználóit.
    </p>

    <p>
        <a href="{{ route('users.index') }}">
            Felhasználók kezelése
        </a>
    </p>
<!--    <h2>Adatbázis importálása</h2>

<p>
    Az iskola által biztosított diákok, tantárgyak és jegyek
    adatainak betöltése.
</p>

<p>
    <a href="{{ route('admin.database-import') }}">
        Adatbázis importálása
    </a>
</p> -->
</x-mainpage>