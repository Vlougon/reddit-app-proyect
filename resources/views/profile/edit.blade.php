@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@include('flash-message')

@error('imageUpload')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

<form action="/profile/store" method="POST" id="updateImage" enctype="multipart/form-data">
    @csrf
    <input type="file" name="imageUpload" id="imageUpload" class="form-control" value="{{old('imageUpload')}}" required />
    <input type="submit">
</form>

<img src="/storage/{{$userProfile ? $userProfile->imageUpload : 'images/default.png' }}" alt="A" width="200" height="200">