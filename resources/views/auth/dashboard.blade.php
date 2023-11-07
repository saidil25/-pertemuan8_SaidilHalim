@extends('auth.layouts')

@section('content')
<div class="flex justify-center mt-5">
    <div class="w-1/2 bg-white p-4 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>
        @if (isset($user))
            <div class="bg-white p-4 rounded shadow-md">
                <table class="table-auto w-full">
                    <tr>
                        <td class="font-semibold p-2">Name:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold p-2">Email:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold p-2">Photo:</td>
                        <td>
                            @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" width="150px" alt="User Photo">

                            @else
                                Tidak ada foto
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="mt-4">
                    <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Photo</a>
                </div>
            </div>
        @else
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Info!</strong>
                <span class="block sm:inline">You are logged in!</span>
            </div>
        @endif
    </div>
</div>
@endsection
