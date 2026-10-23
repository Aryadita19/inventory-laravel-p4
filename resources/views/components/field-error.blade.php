@props(['name'])
@error($name)
    <small class="err">{{ $message }}</small>
@enderror
