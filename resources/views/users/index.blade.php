<x-mainpage>
    <h1>Felhasználók kezelése</h1>

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

    <p>
        <a href="{{ route('users.create') }}">Új felhasználó hozzáadása</a>
    </p>

    @if ($users->isEmpty())
        <p>Nincs regisztrált felhasználó.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Azonosító</th>
                    <th>Felhasználónév</th>
                    <th>Név</th>
                    <th>E-mail</th>
                    <th>Szerepkör</th>
                    <th>Műveletek</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email ?? '–' }}</td>
                        <td>
                            {{ (int) $user->role === 1 ? 'Admin' : 'Tanár' }}
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}">
                                Szerkesztés
                            </a>

                            <form
                                method="POST"
                                action="{{ route('users.destroy', $user) }}"
                                onsubmit="return confirm('Biztosan törölni szeretnéd ezt a felhasználót?');"
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

    <p>
        <a href="{{ route('admin') }}">Vissza az adminisztrációhoz</a>
    </p>
</x-mainpage>