<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class LogLogin extends Model
{
    use HasFactory;


    protected $table = 'log_login';
    public static string $OPERATION_REGISTER = 'register';
    public static string $OPERATION_LOGIN = 'login';
    public static string $OPERATION_LOGOUT = 'logout';
    protected $fillable = [
        'ip',
        'user_agent',
        'username',
        'success',
        'operation',
        'error',
    ];
    protected $casts = [
        'error' => 'array'
    ];
}
