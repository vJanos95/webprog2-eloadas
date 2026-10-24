<x-mainpage>
    <h1>Diákok</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (auth()->user()->role == 1)
        <p>
            <a href="{{ route('students.create') }}">Új diák hozzáadása</a>
        </p>
    @endif

    @if ($students->isEmpty())
        <p>Nincs megjeleníthető diák.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Azonosító</th>
                    <th>Név</th>
                    <th>Osztály</th>
                    <th>Nem</th>
                    @if (auth()->user()->role == 1)
                        <th>Műveletek</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->nev }}</td>
                        <td>{{ $student->osztaly }}</td>
                        <td>{{ $student->fiu ? 'Fiú' : 'Lány' }}</td>

                        @if (auth()->user()->role == 1)
                            <td>
                                <a href="{{ route('students.edit', $student->id) }}">
                                    Szerkesztés
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('students.destroy', $student->id) }}"
                                    onsubmit="return confirm('Biztosan törlöd ezt a diákot?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit">Törlés</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p><a href="{{ route('dashboard') }}">Vissza</a></p>
</x-mainpage>
