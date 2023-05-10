<?php
/**
 * Created by PhpStorm.

 * Date: 11.12.2017
 * Time: 16:40
 */

namespace App\Repositories;


use App\User;
use Carbon\Carbon;
use DB;

class MobileActivationRepository
{

    protected $table = 'user_mobile';

    /**
     * @param User $user
     * @return int
     */
    public function createActivation(User $user)
    {

        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);

    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getActivation(User $user)
    {
        return DB::table($this->table)
            ->where('user_id', $user->id)
            ->first();
    }

    /**
     * @param User $user
     * @return int
     */
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

    /**
     * @return int
     */
    protected function getToken()
    {
        return rand(1000, 9999);
    }

    /**
     * @param User $user
     * @return int
     */
    private function regenerateToken(User $user)
    {

        $token = $this->getToken();
        DB::table($this->table)->where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    /**
     * More then 5 attempts to check code will remove all codes
     * @param User $user
     * @param $token
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getActivationByToken(User $user, $token)
    {
        DB::table($this->table)
            ->where('user_id', $user->id)
            ->update(['attempts' => DB::raw('attempts + 1')]);

        DB::table($this->table)
            ->where('user_id', $user->id)
            ->where('attempts', '>', 5)
            ->delete();

        return DB::table($this->table)
            ->where('user_id', $user->id)
            ->where('token', $token)
            ->first();
    }


    /**
     * @param User $user
     */
    public function deleteActivation(User $user)
    {
        DB::table($this->table)->where('user_id', $user->id)->delete();
    }
}