
<x-mainpage>
    <h1>Regisztráció</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div>
            <label for="username">Felhasználónév</label>
            <input
                id="username"
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
                maxlength="255"
                autocomplete="username"
            >
        </div>

        <div>
            <label for="name">Teljes név</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                maxlength="255"
                autocomplete="name"
            >
        </div>

        <div>
            <label for="password">Jelszó (legalább 8 karakter)</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                minlength="8"
                autocomplete="new-password"
            >
        </div>

        <div>
            <label for="password_confirmation">Jelszó megerősítése</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                minlength="8"
                autocomplete="new-password"
            >
        </div>

        <button type="submit">Regisztráció</button>
    </form>

    <p>
        Már van fiókod?
        <a href="{{ route('login') }}">Bejelentkezés</a>
    </p>
</x-mainpage>
