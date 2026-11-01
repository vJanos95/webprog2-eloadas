<x-mainpage>
    <h1>Jegyek</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>
        <a href="{{ route('grades.create') }}">Új jegy hozzáadása</a>
    </p>

    @if ($grades->isEmpty())
        <p>Még nincs rögzített jegy.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Diák</th>
                    <th>Osztály</th>
                    <th>Tantárgy</th>
                    <th>Dátum</th>
                    <th>Érdemjegy</th>
                    <th>Típus</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grades as $grade)
                    <tr>
                        <td>{{ $grade->diak_nev ?? 'Ismeretlen diák' }}</td>
                        <td>{{ $grade->diak_osztaly ?? '-' }}</td>
                        <td>{{ $grade->targy_nev ?? 'Ismeretlen tantárgy' }}</td>
                        <td>{{ $grade->datum }}</td>
                        <td>{{ $grade->ertek }}</td>
                        <td>{{ $grade->tipus }}</td>
                        <td>
                            <a href="{{ route('grades.edit', $grade->id) }}">
                                Szerkesztés
                            </a>

                            <form
                                action="{{ route('grades.destroy', $grade->id) }}"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Biztosan törlöd ezt a jegyet?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit">Törlés</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-mainpage>