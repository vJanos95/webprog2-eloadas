
<x-mainpage>
    <h1>Tantárgyak</h1>

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
            <a href="{{ route('subjects.create') }}">
                Új tantárgy hozzáadása
            </a>
        </p>
    @endif

    @if ($subjects->isEmpty())
        <p>Nincs megjeleníthető tantárgy.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Azonosító</th>
                    <th>Megnevezés</th>
                    <th>Kategória</th>

                    @if (auth()->user()->role == 1)
                        <th>Műveletek</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->nev }}</td>
                        <td>{{ $subject->kategoria }}</td>

                        @if (auth()->user()->role == 1)
                            <td>
                                <a href="{{ route('subjects.edit', $subject->id) }}">
                                    Szerkesztés
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('subjects.destroy', $subject->id) }}"
                                    onsubmit="return confirm('Biztosan törlöd ezt a tantárgyat?');"
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
