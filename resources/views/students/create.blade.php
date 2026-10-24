
<x-mainpage>
    <h1>Új diák hozzáadása</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('students.store') }}">
        @csrf

        <div>
            <label for="nev">Név</label>
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
            <label for="osztaly">Osztály</label>
            <input
                id="osztaly"
                type="text"
                name="osztaly"
                value="{{ old('osztaly') }}"
                maxlength="50"
                required
            >
        </div>

        <div>
            <label for="fiu">Nem</label>
            <select id="fiu" name="fiu" required>
                <option value="1" @selected(old('fiu') === '1')>Fiú</option>
                <option value="0" @selected(old('fiu') === '0')>Lány</option>
            </select>
        </div>

        <button type="submit">Diák mentése</button>
    </form>

    <p><a href="{{ route('students.index') }}">Vissza a diákokhoz</a></p>
</x-mainpage>
