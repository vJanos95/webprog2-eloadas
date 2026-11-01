<x-mainpage>
    <h1>Beérkezett üzenetek</h1>

    @if ($messages->isEmpty())
        <p>Jelenleg nincs beérkezett üzenet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Küldés ideje</th>
                    <th>Név</th>
                    <th>E-mail cím</th>
                    <th>Tárgy</th>
                    <th>Üzenet</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <td>
                            {{ $message->created_at->format('Y.m.d. H:i') }}
                        </td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->subject }}</td>
                        <td>{{ $message->message }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-mainpage>