<div wire:ignore x-data="{
    value: @entangle($attributes->wire('model')),
    isFocused() { return document.activeElement !== this.$refs.trix },
    setValue() {
        if (this.$refs.trix && this.$refs.trix.editor) {
            this.$refs.trix.editor.loadHTML(this.value);
        }
    },
}" x-init="setValue();
$watch('value', () => isFocused() && setValue())" x-on:trix-initialize="setValue()"
    x-on:trix-focus="setValue()" {{ $attributes->whereDoesntStartWith('wire:model') }} wire:ignore
    {{ $attributes->merge(['class' => 'mt-1 rounded-md']) }}>
    <input id="x" type="hidden">
    <trix-editor x-on:trix-change="$dispatch('input', event.target.value)" x-data wire:key="uniqueKey" x-ref="trix"
        input="x" class="
    // Add your css class here
    "></trix-editor>
</div>
