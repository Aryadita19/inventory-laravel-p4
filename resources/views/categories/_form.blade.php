<form method="POST" action="{{ $action }}">
    @csrf
    @if ($category->exists) @method('PUT') @endif
    <label>Nama</label>
    <input name="name" value="{{ old('name', $category->name) }}">
    <x-field-error name="name" />
    <label>Deskripsi</label>
    <input name="description" value="{{ old('description', $category->description) }}">
    <x-field-error name="description" />
    <p>
        <button class="btn" type="submit">Simpan</button>
        <a class="btn btn-gray" href="{{ route('categories.index') }}">Batal</a>
    </p>
</form>
