<x-mainpage>
    <h1>Jegy szerkesztése</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="diakid">Diák:</label>
            <select id="diakid" name="diakid" required>
                @foreach ($students as $student)
                    <option
                        value="{{ $student->id }}"
                        @selected(old('diakid', $grade->diakid) == $student->id)
                    >
                        {{ $student->nev }} ({{ $student->osztaly }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="targyid">Tantárgy:</label>
            <select id="targyid" name="targyid" required>
                @foreach ($subjects as $subject)
                    <option
                        value="{{ $subject->id }}"
                        @selected(old('targyid', $grade->targyid) == $subject->id)
                    >
                        {{ $subject->nev }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="datum">Dátum:</label>
            <input
                type="date"
                id="datum"
                name="datum"
                value="{{ old('datum', $grade->datum) }}"
                required
            >
        </div>

        <div>
            <label for="ertek">Érdemjegy:</label>
            <select id="ertek" name="ertek" required>
                @foreach ([1, 2, 3, 4, 5] as $gradeValue)
                    <option
                        value="{{ $gradeValue }}"
                        @selected(old('ertek', $grade->ertek) == $gradeValue)
                    >
                        {{ $gradeValue }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="tipus">Jegy típusa:</label>
            <select id="tipus" name="tipus" required>
                @foreach ($types as $type)
                    <option
                        value="{{ $type }}"
                        @selected(old('tipus', $grade->tipus) == $type)
                    >
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Módosítás mentése</button>
        <a href="{{ route('grades.index') }}">Mégse</a>
    </form>
</x-mainpage>