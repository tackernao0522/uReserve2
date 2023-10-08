<div class="text-center">
    <form wire:submit.prevent="register">
        <label for="name">名前</label>
        <input type="text" id="name" wire:model="name">
        <br>
        @error('name')
            <div class="text-red-400">{{ $message }}</div>
        @enderror
        <br>
        <label for="email">メールアドレス</label>
        <input type="email" id="email" wire:model="email">
        <br>
        @error('email')
            <div class="text-red-400">{{ $message }}</div>
        @enderror
        <br>
        <label for="password">パスワード</label>
        <input type="password" id="password" wire:model="password">
        <br>
        @error('password')
            <div class="text-red-400">{{ $message }}</div>
        @enderror
        <br>
        <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded">登録する</button>
    </form>
</div>
