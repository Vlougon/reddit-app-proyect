<form method="POST" action="/community">
    @csrf
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="What is the title of your article?">
    </div>

    <div class="form-group">
        <label for="link">Link:</label>
        <input type="text" class="form-control" id="link" name="link" placeholder="What is the URL?">
    </div>

    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @error('link')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="form-group pt-3">
        <button class="btn btn-primary">Contribute!</button>
    </div>
</form>