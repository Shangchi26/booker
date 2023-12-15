@extends('admin')
@section('manager')
    <div class="container pt-5">
        <h1 class="text-3xl font-bold">All Contacts</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Massage</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->text }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
