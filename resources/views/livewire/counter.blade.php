<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <div class="mb-8"></div>
    <input type="text" wire:model="name">
    {{-- <input type="text" wire:model.debounce.2000ms="name"> --}}
    {{-- <input type="text" wire:model.lazy="name"> --}}
    {{-- <input type="text" wire:model.defer="name"> --}}
    <br>
    こんにちは、{{ $name }} さん
</div>
