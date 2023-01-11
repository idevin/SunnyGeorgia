<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 11.12.2017
 * Time: 16:40
 */

namespace App\Repositories;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActivationRepository
{

    protected $table = 'user_activations';

    public function createActivation(User $user)
    {
        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);
    }

    public function getActivation(User $user)
    {
        return DB::table($this->table)->where('user_id', $user->id)->first();
    }

    private function createToken(User $user)
    {
        $token = $this->getToken();
        DB::table($this->table)->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    private function regenerateToken(User $user)
    {
        $token = $this->getToken();
        DB::table($this->table)->where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    public function getActivationByToken($token)
    {
        return DB::table($this->table)->where('token', $token)->first();
    }

    public function deleteActivation($token)
    {
        DB::table($this->table)->where('token', $token)->delete();
    }
}