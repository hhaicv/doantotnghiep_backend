<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('vouchers', function () {
    return true; // Kênh công khai nên luôn trả về true
});
Broadcast::channel('promotions', function () {
    return true; // Nếu cần bảo mật hơn, thêm điều kiện kiểm tra user tại đây.
});
