<div>
    @php
        $name = $attributes->get('name');
    @endphp
    <x-input-label :for="$name" :value="$label ?? $name" />
    <x-text-input :id="$name" :name="$name" type="text" class="mt-1 block w-full" />
    <x-input-error class="mt-2" :messages="$errors->get($name)" />
</div>
