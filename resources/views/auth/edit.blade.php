@extends('auth.layouts')

@section('content')
<div class="flex justify-center mt-5">
    <div class="w-1/2 bg-white p-4 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold mb-4">Edit Profile</h1>
        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Change Photo</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="remove_photo" class="block text-gray-700 text-sm font-bold mb-2">Remove Photo</label>
                <input type="checkbox" id="remove_photo" name="remove_photo">
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover-bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
