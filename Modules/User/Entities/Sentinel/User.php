<?php

namespace Modules\User\Entities\Sentinel;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Passport\HasApiTokens;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\User\Entities\UserInterface;
use Modules\User\Entities\UserToken;
use Modules\User\Presenters\UserPresenter;

class User extends EloquentUser implements UserInterface, AuthenticatableContract
{
    use PresentableTrait, Authenticatable, HasApiTokens, AuditTrait, RevisionableTrait;

    public $repository = 'Modules\User\Repositories\UserRepository';

    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'timezone',
        'language',
        'is_guest',
        'user_name',
    ];

    /**
     * {@inheritDoc}
     */
    protected $loginNames = ['email'];

    protected $presenter = UserPresenter::class;

    public function __construct(array $attributes = [])
    {
        $this->loginNames = setting('iprofile::customLogin', null, config('asgard.user.config.login-columns'));

        if (! is_array($this->loginNames)) {
            $this->loginNames = json_decode($this->loginNames);
        }
        if (config()->has('asgard.user.config.presenter')) {
            $this->presenter = config('asgard.user.config.presenter', UserPresenter::class);
        }
//        if (config()->has('asgard.user.config.dates')) {
//            $this->dates = config('asgard.user.config.dates', []);
//        }
        if (config()->has('asgard.user.config.casts')) {
            $this->casts = config('asgard.user.config.casts', []);
        }

        parent::__construct($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRoleId($roleId)
    {
        return $this->roles()->whereId($roleId)->count() >= 1;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRoleSlug($slug)
    {
        return $this->roles()->whereSlug($slug)->count() >= 1;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRoleName($name)
    {
        return $this->roles()->whereName($name)->count() >= 1;
    }

    /**
     * {@inheritdoc}
     */
    public function isActivated()
    {
        if (is_int($this->getKey()) && Activation::completed($this)) {
            return true;
        }

        return false;
    }

    public function api_keys()
    {
        return $this->hasMany(UserToken::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstApiKey()
    {
        $userToken = $this->api_keys->first();

        if ($userToken === null) {
            return '';
        }

        return $userToken->access_token;
    }

    public function organizations()
    {
        return $this->belongsToMany(
            \Modules\Isite\Entities\Organization::class,
            'isite__user_organization');
    }

    public function addresses()
    {
        return $this->hasMany(
            \Modules\Iprofile\Entities\Address::class);
    }

    public function fields()
    {
        return $this->hasMany(
            \Modules\Iprofile\Entities\Field::class);
    }

    public function settings()
    {
        return $this->hasMany(
            \Modules\Iprofile\Entities\Setting::class, 'related_id')->where('entity_name', 'user');
    }

    public function departments()
    {
        return $this->belongsToMany(
            \Modules\Iprofile\Entities\Department::class,
            'iprofile__user_department');
    }

    public function __call($method, $parameters)
    {
        //i: Convert array to dot notation
        $config = implode('.', ['asgard.user.config.relations', $method]);

        //i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            $bound = $function->bindTo($this);

            return $bound();
        }

        //i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAccess($permission)
    {
        $permissions = $this->getPermissionsInstance();

        return $permissions->hasAccess($permission);
    }
}
