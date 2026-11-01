<x-mainpage>
    <h1>Felhasználó szerkesztése</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="username">Felhasználónév</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $user->username) }}"
                required
            >
        </div>

        <div>
            <label for="name">Teljes név</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
            >
        </div>

        <div>
            <label for="email">E-mail cím</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
            >
        </div>

        <div>
            <label for="password">Új jelszó</label>
            <input
                type="password"
                id="password"
                name="password"
            >
            <small>Hagyd üresen, ha nem szeretnéd megváltoztatni.</small>
        </div>

        <div>
            <label for="password_confirmation">Új jelszó megerősítése</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
            >
        </div>

        <div>
            <label for="role">Szerepkör</label>

            @if ($user->id === auth()->id())
                <input type="hidden" name="role" value="{{ $user->role }}">
                <p>
                    {{ (int) $user->role === 1 ? 'Admin' : 'Tanár' }}
                    – a saját szerepköröd nem módosítható.
                </p>
            @else
                <select id="role" name="role" required>
                    <option
                        value="2"
                        {{ old('role', $user->role) == '2' ? 'selected' : '' }}
                    >
                        Tanár
                    </option>

                    <option
                        value="1"
                        {{ old('role', $user->role) == '1' ? 'selected' : '' }}
                    >
                        Admin
                    </option>
                </select>
            @endif
        </div>

        <button type="submit">Módosítás mentése</button>
    </form>

    <p>
        <a href="{{ route('users.index') }}">Vissza a felhasználókhoz</a>
    </p>
</x-mainpage>