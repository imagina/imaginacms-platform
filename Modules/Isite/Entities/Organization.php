<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Modules\Core\Support\Traits\AuditTrait;
use Illuminate\Support\Str;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Ischedulable\Support\Traits\Schedulable;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Modules\Ifillable\Traits\isFillable;
use Modules\Setting\Entities\Setting;
use Stancl\Tenancy\Database\Concerns\MaintenanceMode;

class Organization extends BaseTenant implements TenantWithDatabase
{
  use AuditTrait, Translatable, HasDatabase, HasDomains, MediaRelation, Schedulable, hasEventsWithBindings, isFillable, MaintenanceMode;
  
  public $transformer = 'Modules\Isite\Transformers\OrganizationTransformer';
  public $requestValidation = [
    'create' => 'Modules\Isite\Http\Requests\CreateOrganizationRequest',
    'update' => 'Modules\Isite\Http\Requests\UpdateOrganizationRequest',
  ];
  public $dispatchesEventsWithBindings = [
    'updated' => [
      [
        'path' => 'Modules\Isite\Events\OrganizationWasUpdated'
      ]
    ]
  ];
  protected $table = 'isite__organizations';
  public $translatedAttributes = [
    'title',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'translatable_options'
  ];
  protected $fillable = [
    'options',
    'user_id',
    'featured',
    'permissions',
    'category_id',
    'status',
    'enable',
    'sort_order',
    'layout_id',
    'maintenance_mode'
  ];
  protected $casts = [
    'options' => 'array',
    'maintenance_mode' => 'array'
  ];
  
  public static function getCustomColumns(): array
  {
    return [
      'id',
      'options',
      'user_id',
      'featured',
      'permissions',
      'layout_id',
      'status',
      'enable',
      'sort_order',
      'category_id',
      'created_at',
      'updated_at',
      'deleted_at',
      'created_by',
      'updated_by',
      'deleted_by',
      'maintenance_mode'
    ];
  }
  
  public function getIncrementing()
  {
    return true;
  }
  
  public function category()
  {
    return $this->belongsTo(Category::class);
  }
  
  public function domains()
  {
    return $this->hasMany(Domain::class);
  }
  
  
  public function settings()
  {
    return $this->hasMany(Setting::class);
  }
  
  public function getUrlAttribute()
  {
    $currentLocale = locale();
    
    $domains = $this->domains;

    //in some cases, when the tenant is initialized, the table settings hasn't been created, in that case this line break the code with 500
    try {
      $tenantRouteAlias = setting("isite::tenantRouteAlias", null, "homepage", true);
    } catch (\Exception $e) {
      $tenantRouteAlias = "homepage";
    }
    
    $customDomain = $domains->where("type", "custom")->first()->domain ?? null;
    $defaultDomain = $domains->where("type", "default")->first()->domain ?? $this->slug ?? null;
    
    if (!empty($customDomain)) {
      return $customDomain;
    } elseif (!empty($defaultDomain)) {

      return tenant_route($defaultDomain, $currentLocale . ".$tenantRouteAlias");
    } else {
      return "";
    }
    
  }
  
  public function getDomainAttribute()
  {
    return parse_url($this->url, PHP_URL_HOST);
  }
  
  public function users()
  {
    
    $driver = config('asgard.user.config.driver');
    return $this->belongsToMany("Modules\\User\\Entities\\{$driver}\\User", 'isite__user_organization')
      ->withPivot('id', 'permissions', 'role_id')
      ->withTimestamps();
  }
  
  public function layout()
  {
    return $this->belongsTo(Layout::class);
  }
  
}
