<x-mainpage>
    <h1>Üdvözlünk az oldalon!</h1>

    <p>
        Kedves {{ auth()->user()->name }}!
        Sikeresen bejelentkeztél a rendszerbe.
    </p>

    <h2>Felhasználói adatok</h2>

    <table>
        <tbody>
            <tr>
                <th>Felhasználónév</th>
                <td>{{ auth()->user()->username }}</td>
            </tr>

            <tr>
                <th>Teljes név</th>
                <td>{{ auth()->user()->name }}</td>
            </tr>

            <tr>
                <th>Jogosultság</th>
                <td>
                    @if ((int) auth()->user()->role === 1)
                        Adminisztrátor
                    @else
                        Tanár
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <p>
        A bal oldali menüben találod az elérhető funkciókat.
    </p>
</x-mainpage>
