<?php namespace Education\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash;
use Carbon\Carbon;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    public $timestamp = true;

    /**
     * The system types array
     *
     * @var array 
     */
    private static $singularTypes = ['superadmin' => 'super administrador', 'admin' => 'administrador', 'registered' => 'registrado'];
    private static $pluralTypes = ['superadmin' => 'super administradores', 'admin' => 'administradores', 'registered' => 'registrados'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'tel', 'email', 'type', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /* Querys */

    public static function allPaginate($number_pages = 10)
    {
        return self::with('type')->orderBy('updated_at')->paginate($number_pages);
    }
    
    /* Mutators */
	public function setPasswordAttribute($value)
    {
        if( !empty($value) )
        {
            $this->attributes['password'] = Hash::make(trim($value));
        }
    }

    public function scopeRegistereds($query)
    {
        return $query->where('type', '=', 'registered');
    }

    public function isAdmin()
    {
        return $this->isType('admin');
    }

    public function isRegistered()
    {
        return $this->isType('registered');
    }

    public function isType($type)
    {
        if($this->type == $type)
        {
            return true;
        }

        return false;
    }

    public function getTypeNameAttribute()
    {
        return self::$singularTypes[$this->type];    
    }

    public function getTypePluralNameAttribute()
    {
        return self::$pluralTypes[$this->type];    
    }

    public function getUpdatedAtHummansAttribute()
    {
        Carbon::setLocale('es');
        return ucfirst($this->updated_at->diffForHumans());
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class);
    }

    public function protocols()
    {
        return $this->belongsToMany(Protocol::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function protocolsCreated()
    {
        return $this->hasMany(Protocol::class);
    }

    public function rolesCreated()
    {
        return $this->hasMany(Role::class);
    }

    public function areasCreated()
    {
        return $this->hasMany(Area::class);
    }

    public function categoriesCreated()
    {
        return $this->hasMany(Category::class);
    }

    public function getExamProtocolPending()
    {
        return $this->protocols->filter(function ($protocol) {
            return $protocol->isExamPending();
        });    
    }

    public function getExamProtocolOk()
    {
        return $this->protocols->filter(function ($protocol) {
            return ! $protocol->isExamPending();
        }); 
    }

    public function getAreaIdListsAttribute()
    {
        return $this->areas->lists('id')->all();
    }

    public function getRoleIdListsAttribute()
    {
        return $this->roles->lists('id')->all();
    }

    public function syncRelations($data)
    {
        if(array_key_exists('areas', $data))
        {
            $this->areas()->sync($data['areas']);
        }

        if(array_key_exists('roles', $data))
        {
            $this->roles()->sync($data['roles']);
        }
    }


}
