<x-mainpage>
    <h1>Adatbázis importálása</h1>

    <p>
        Ezen az oldalon töltheted fel az iskola által biztosított
        adatállományokat az adatbázisba.
    </p>

    <p>
        <strong>Figyelem:</strong> Az importálás csak üres adatbázistáblák
        esetén végezhető el. A három fájlt egyszerre kell feltölteni.
    </p>

    @if ($errors->any())
        <div>
            <h3>Hiba történt!</h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('import_success'))
        <div>
            <h3>Az importálás sikeres!</h3>
            <ul>
                <li>Diákok: {{ session('import_success.diak') }}</li>
                <li>Tantárgyak: {{ session('import_success.targy') }}</li>
                <li>Jegyek: {{ session('import_success.jegy') }}</li>
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.database-import.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="fields">
            <div class="field">
                <label for="diak">Diákok (diak.txt)</label>
                <input
                    type="file"
                    name="diak"
                    id="diak"
                    accept=".txt,text/plain"
                    required
                >
            </div>

            <div class="field">
                <label for="targy">Tantárgyak (targy.txt)</label>
                <input
                    type="file"
                    name="targy"
                    id="targy"
                    accept=".txt,text/plain"
                    required
                >
            </div>

            <div class="field">
                <label for="jegy">Jegyek (jegy.txt)</label>
                <input
                    type="file"
                    name="jegy"
                    id="jegy"
                    accept=".txt,text/plain"
                    required
                >
            </div>
        </div>

        <ul class="actions">
            <li>
                <button type="submit" class="primary">
                    Adatok importálása
                </button>
            </li>
        </ul>
    </form>
</x-mainpage>
