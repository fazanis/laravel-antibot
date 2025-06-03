<div style="text-align: center;">
    <h2>Подтвердите что вы не бот</h2>
    <form method="post" action="{{route('send.captcha')}}" >
        @csrf
        {!! captcha_img('math',attrs:['width'=>config('block-bots.width').'px']) !!}
        <p><input type="text" name="captcha"></p>
        <i style="color: red;">@error('captcha')</i>
        <div class="invalid-feedback">{{ $message }}</div> @enderror
        <p><button type="submit">Отправить</button></p>
    </form>
</div>
