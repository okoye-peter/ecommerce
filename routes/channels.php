<?php

use App\User;
use Illuminate\Support\Facades\Auth;
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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// Broadcast::channel('chat', function ($user) {
//     Auth::check();
//     return $user->only(['id','name','image']);
// });
Broadcast::channel('chat.{id}', function ($user, $id) {
    $admins = User::where('isadmin', 1)->pluck('id');
    if ((int) $user->id === (int) $id || in_array($user->id, $admins->toArray())) {
        return $user->only(['id', 'name', 'image']);
    }
});
