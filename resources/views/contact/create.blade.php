<x-mainpage>
    <h1>Kapcsolat</h1>

    <p>
        Az alábbi űrlap segítségével üzenetet küldhetsz az oldal tulajdonosa számára.
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('contact.store') }}">
        @csrf

        <div>
            <label for="name">Név</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                maxlength="255"
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
                maxlength="255"
                required
            >
        </div>

        <div>
            <label for="subject">Tárgy</label>
            <input
                type="text"
                id="subject"
                name="subject"
                value="{{ old('subject') }}"
                maxlength="255"
                required
            >
        </div>

        <div>
            <label for="message">Üzenet</label>
            <textarea
                id="message"
                name="message"
                rows="6"
                maxlength="5000"
                required
            >{{ old('message') }}</textarea>
        </div>

        <button type="submit">Üzenet küldése</button>
    </form>
</x-mainpage>