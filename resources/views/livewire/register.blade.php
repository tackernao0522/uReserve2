<div style="text-align: center">
    <form wire:submit.prevent="register">
        <label for="name">名前</label>
        <input type="text" id="name" wire:model="name">
        <br>
        @error('name')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <br>
        <label for="email">メールアドレス</label>
        <input type="email" id="email" wire:model="email">
        <br>
        @error('email')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>
        <label for="password">パスワード</label>
        <input type="password" id="password" wire:model="password">
        <br>
        @error('password')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>
        <button>登録する</button>
    </form>
</div>
