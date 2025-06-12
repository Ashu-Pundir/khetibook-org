<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Crop;
use Pest\Arch\Objects\FunctionDescription;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'phone_number',
    //     'email',
    //     'password',

    // ];
    protected $guarded = [];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified' => 'boolean',
            'number_verified' => 'boolean',
            'otp_sent_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function crops(){

        return $this->hasMany(Crop::class, 'user_id');

    }

   private function checkIfFullyVerified(User $user)
    {
        if ($user->email_verified && $user->number_verified) {
            $user->user_verified = true;
            $user->save();
        }
    }



} 
