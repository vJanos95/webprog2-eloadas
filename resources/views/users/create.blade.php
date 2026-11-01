<x-mainpage>
    <h1>Új felhasználó létrehozása</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div>
            <label for="username">Felhasználónév</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                required
            >
        </div>

        <div>
            <label for="name">Teljes név</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div>
            <label for="email">E-mail cím</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
            >
        </div>

        <div>
            <label for="password">Jelszó</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <div>
            <label for="password_confirmation">Jelszó megerősítése</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
            >
        </div>

        <div>
            <label for="role">Szerepkör</label>
            <select id="role" name="role" required>
                <option value="2" {{ old('role', '2') == '2' ? 'selected' : '' }}>
                    Tanár
                </option>
                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>
                    Admin
                </option>
            </select>
        </div>

        <button type="submit">Létrehozás</button>
    </form>

    <p>
        <a href="{{ route('users.index') }}">Vissza a felhasználókhoz</a>
    </p>
</x-mainpage>