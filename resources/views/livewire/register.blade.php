<div style="text-align: center">
    <form wire:submit.prevent="register">
        <label for="name">名前</label>
        <input type="text" id="name" wire:model="name">
        <br>
        <br>
        <label for="email">メールアドレス</label>
        <input type="email" id="email" wire:model="email">
        <br>
        <br>
        <label for="password">パスワード</label>
        <input type="password" id="password" wire:model="password">
        <br>
        <br>
        <button>登録する</button>
    </form>
</div>
