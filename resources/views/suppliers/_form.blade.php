<form method="POST" action="{{ $action }}">
    @csrf
    @if ($supplier->exists) @method('PUT') @endif
    @foreach (['name' => 'Nama', 'phone' => 'Telepon', 'email' => 'Email', 'address' => 'Alamat'] as $field => $label)
        <label>{{ $label }}</label>
        <input name="{{ $field }}" value="{{ old($field, $supplier->{$field}) }}">
        <x-field-error :name="$field" />
    @endforeach
    <p>
        <button class="btn" type="submit">Simpan</button>
        <a class="btn btn-gray" href="{{ route('suppliers.index') }}">Batal</a>
    </p>
</form>
