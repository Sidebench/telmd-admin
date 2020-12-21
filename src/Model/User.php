<?php
namespace WFN\Admin\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use WFN\Admin\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    
    use Notifiable;

    protected $table = 'admin_user';

    protected $fillable = [
        'role_id', 'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(User\Role::class);
    }

    public function sendPasswordResetNotification($token)
    {
        if(class_exists('\WFN\Emails\Model\Transport\Mandrill')) {
            \MandrillMail::send('admin-password-reset', $this->email, [
                'reset_password_link' => url(route('admin.password.reset', ['token' => $token]))
            ]);
        } else {
            $this->notify(new ResetPasswordNotification($token));
        }
    }

}