
<x-mainpage>
    <h1>Új tantárgy hozzáadása</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('subjects.store') }}">
        @csrf

        <div>
            <label for="nev">Tantárgy neve</label>
            <input
                id="nev"
                type="text"
                name="nev"
                value="{{ old('nev') }}"
                maxlength="255"
                required
            >
        </div>

        <div>
            <label for="kategoria">Kategória</label>
            <input
                id="kategoria"
                type="text"
                name="kategoria"
                value="{{ old('kategoria') }}"
                maxlength="255"
                required
            >
        </div>

        <button type="submit">Tantárgy mentése</button>
    </form>

    <p>
        <a href="{{ route('subjects.index') }}">Vissza a tantárgyakhoz</a>
    </p>
</x-mainpage>
