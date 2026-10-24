
<x-mainpage>
    <h1>Diák szerkesztése</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('students.update', $student->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="nev">Név</label>
            <input
                id="nev"
                type="text"
                name="nev"
                value="{{ old('nev', $student->nev) }}"
                maxlength="255"
                required
            >
        </div>

        <div>
            <label for="osztaly">Osztály</label>
            <input
                id="osztaly"
                type="text"
                name="osztaly"
                value="{{ old('osztaly', $student->osztaly) }}"
                maxlength="50"
                required
            >
        </div>

        <div>
            <label for="fiu">Nem</label>
            <select id="fiu" name="fiu" required>
                <option
                    value="1"
                    @selected((string) old('fiu', $student->fiu) === '1')
                >
                    Fiú
                </option>
                <option
                    value="0"
                    @selected((string) old('fiu', $student->fiu) === '0')
                >
                    Lány
                </option>
            </select>
        </div>

        <button type="submit">Módosítások mentése</button>
    </form>

    <p><a href="{{ route('students.index') }}">Vissza a diákokhoz</a></p>
</x-mainpage>
