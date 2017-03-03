<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function teacher(){
        return $this->hasMany('App\SubjectClassDivision','teacher_id');
    }
    public function moduleAcl()
    {
        return $this->hasMany('App\ModuleAcl','user_id');
    }

    public function Message(){
        return $this->hasMany('App\Message','to_id');
    }

    public function getRememberToken()
    {
        return null; // not supported
    }

    public function setRememberToken($value)
    {
        // not supported
    }

    public function getRememberTokenName()
    {
        return null; // not supported
    }

    public function studentExtraInfo()
    {
        return $this->hasOne('App\StudentExtraInfo','student_id');
    }

    public function studentFamilyInfo()
    {
        return $this->hasOne('App\StudentFamily','student_id');
    }
    public function StudentSibling()
    {
        return $this->hasMany('App\StudentSibling','student_id');
    }
    public function StudentPreviousSchool()
    {
        return $this->hasOne('App\StudentPreviousSchool','student_id');
    }
    public function StudentSpecialAptitude()
    {
        return $this->hasMany('App\StudentSpecialAptitude','student_id');
    }
    public function StudentHobby()
    {
        return $this->hasMany('App\StudentHobby','student_id');
    }


    /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
}
