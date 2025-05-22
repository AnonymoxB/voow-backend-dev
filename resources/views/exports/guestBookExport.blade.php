<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Address</th>
    </tr>
    </thead>
    <tbody>
    @foreach($guestBook as $guest)
        <tr>
            <td>{{ $guest->name }}</td>
            <td>{{ $guest->phone_number }}</td>
            <td>{{ $guest->address }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
