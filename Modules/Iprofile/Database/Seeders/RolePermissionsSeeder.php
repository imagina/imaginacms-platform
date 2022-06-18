<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Iprofile\Entities\Department;
use Modules\Iprofile\Entities\Setting;
use Modules\Iprofile\Entities\Role;
use Modules\User\Permissions\PermissionManager;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class RolePermissionsSeeder extends Seeder
{
  private $permissions;
  
  public function __construct(PermissionManager $permissions)
  {
    $this->permissions = $permissions;
  }
  
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    
    $roles = Sentinel::getRoleRepository();
    //Update permissions of role SUPER USER
    $admin = Sentinel::findRoleBySlug('admin');
    
    if (!isset($admin->id)) {
      // Create an Admin group
      $roles->createModel()->create(
        [
          'name' => 'Admin',
          'slug' => 'admin',
          'permissions' => ["core.sidebar.group" => true, "dashboard.index" => true, "dashboard.update" => true, "dashboard.reset" => true, "iblog.categories.manage" => true, "iblog.categories.index" => true, "iblog.categories.create" => true, "iblog.categories.edit" => true, "iblog.categories.destroy" => true, "iblog.posts.manage" => true, "iblog.posts.index" => true, "iblog.posts.create" => true, "iblog.posts.edit" => true, "iblog.posts.destroy" => true, "icommerce.tags.manage" => true, "icommerce.tags.index" => true, "icommerce.tags.create" => true, "icommerce.tags.edit" => true, "icommerce.tags.destroy" => true, "icommerce.categories.manage" => true, "icommerce.categories.index" => true, "icommerce.categories.create" => true, "icommerce.categories.edit" => true, "icommerce.categories.destroy" => true, "icommerce.manufacturers.manage" => true, "icommerce.manufacturers.index" => true, "icommerce.manufacturers.create" => true, "icommerce.manufacturers.edit" => true, "icommerce.manufacturers.destroy" => true, "icommerce.products.manage" => true, "icommerce.products.index" => true, "icommerce.products.create" => true, "icommerce.products.edit" => true, "icommerce.products.destroy" => true, "icommerce.bulkload.manage" => true, "icommerce.bulkload.import" => true, "icommerce.bulkload.export" => true, "icommerce.producttags.manage" => true, "icommerce.producttags.index" => true, "icommerce.producttags.create" => true, "icommerce.producttags.edit" => true, "icommerce.producttags.destroy" => true, "icommerce.productcategories.manage" => true, "icommerce.productcategories.index" => true, "icommerce.productcategories.create" => true, "icommerce.productcategories.edit" => true, "icommerce.productcategories.destroy" => true, "icommerce.options.manage" => true, "icommerce.options.index" => true, "icommerce.options.create" => true, "icommerce.options.edit" => true, "icommerce.options.destroy" => true, "icommerce.coupons.manage" => true, "icommerce.coupons.index" => true, "icommerce.coupons.create" => true, "icommerce.coupons.edit" => true, "icommerce.coupons.destroy" => true, "icommerce.shippingcouriers.manage" => true, "icommerce.shippingcouriers.index" => true, "icommerce.shippingcouriers.create" => true, "icommerce.shippingcouriers.edit" => true, "icommerce.shippingcouriers.destroy" => true, "icommerce.currencies.manage" => true, "icommerce.currencies.index" => true, "icommerce.currencies.create" => true, "icommerce.currencies.edit" => true, "icommerce.currencies.destroy" => true, "icommerce.orders.manage" => true, "icommerce.orders.index" => true, "icommerce.orders.index-all" => true, "icommerce.orders.show" => true, "icommerce.orders.show-others" => true, "icommerce.orders.create" => true, "icommerce.orders.edit" => true, "icommerce.orders.destroy" => true, "icommerce.productdiscounts.manage" => true, "icommerce.productdiscounts.index" => true, "icommerce.productdiscounts.create" => true, "icommerce.productdiscounts.edit" => true, "icommerce.productdiscounts.destroy" => true, "icommerce.optionvalues.manage" => true, "icommerce.optionvalues.index" => true, "icommerce.optionvalues.create" => true, "icommerce.optionvalues.edit" => true, "icommerce.optionvalues.destroy" => true, "icommerce.productoptions.manage" => true, "icommerce.productoptions.index" => true, "icommerce.productoptions.create" => true, "icommerce.productoptions.edit" => true, "icommerce.productoptions.destroy" => true, "icommerce.productoptionvalues.manage" => true, "icommerce.productoptionvalues.index" => true, "icommerce.productoptionvalues.create" => true, "icommerce.productoptionvalues.edit" => true, "icommerce.productoptionvalues.destroy" => true, "icommerce.orderproducts.manage" => true, "icommerce.orderproducts.index" => true, "icommerce.orderproducts.create" => true, "icommerce.orderproducts.edit" => true, "icommerce.orderproducts.destroy" => true, "icommerce.orderoptions.manage" => true, "icommerce.orderoptions.index" => true, "icommerce.orderoptions.create" => true, "icommerce.orderoptions.edit" => true, "icommerce.orderoptions.destroy" => true, "icommerce.orderhistories.manage" => true, "icommerce.orderhistories.index" => true, "icommerce.orderhistories.create" => true, "icommerce.orderhistories.edit" => true, "icommerce.orderhistories.destroy" => true, "icommerce.ordershipments.manage" => true, "icommerce.ordershipments.index" => true, "icommerce.ordershipments.create" => true, "icommerce.ordershipments.edit" => true, "icommerce.ordershipments.destroy" => true, "icommerce.couponcategories.manage" => true, "icommerce.couponcategories.index" => true, "icommerce.couponcategories.create" => true, "icommerce.couponcategories.edit" => true, "icommerce.couponcategories.destroy" => true, "icommerce.couponproducts.manage" => true, "icommerce.couponproducts.index" => true, "icommerce.couponproducts.create" => true, "icommerce.couponproducts.edit" => true, "icommerce.couponproducts.destroy" => true, "icommerce.couponhistories.manage" => true, "icommerce.couponhistories.index" => true, "icommerce.couponhistories.create" => true, "icommerce.couponhistories.edit" => true, "icommerce.couponhistories.destroy" => true, "icommerce.wishlists.manage" => true, "icommerce.wishlists.index" => true, "icommerce.wishlists.create" => true, "icommerce.wishlists.edit" => true, "icommerce.wishlists.destroy" => true, "icommerce.payments.manage" => true, "icommerce.payments.index" => true, "icommerce.payments.create" => true, "icommerce.payments.edit" => true, "icommerce.payments.destroy" => true, "icommerce.shippings.manage" => true, "icommerce.shippings.index" => true, "icommerce.shippings.create" => true, "icommerce.shippings.edit" => true, "icommerce.shippings.destroy" => true, "icommerce.taxrates.manage" => true, "icommerce.taxrates.index" => true, "icommerce.taxrates.create" => true, "icommerce.taxrates.edit" => true, "icommerce.taxrates.destroy" => true, "icommerce.taxclasses.manage" => true, "icommerce.taxclasses.index" => true, "icommerce.taxclasses.create" => true, "icommerce.taxclasses.edit" => true, "icommerce.taxclasses.destroy" => true, "icommerce.taxclassrates.manage" => true, "icommerce.taxclassrates.index" => true, "icommerce.taxclassrates.create" => true, "icommerce.taxclassrates.edit" => true, "icommerce.taxclassrates.destroy" => true, "icommerce.itemtypes.manage" => true, "icommerce.itemtypes.index" => true, "icommerce.itemtypes.create" => true, "icommerce.itemtypes.edit" => true, "icommerce.itemtypes.destroy" => true, "icommerce.relatedproducts.manage" => true, "icommerce.relatedproducts.index" => true, "icommerce.relatedproducts.create" => true, "icommerce.relatedproducts.edit" => true, "icommerce.relatedproducts.destroy" => true, "icommerce.payment-methods.manage" => true, "icommerce.payment-methods.index" => true, "icommerce.payment-methods.create" => true, "icommerce.payment-methods.edit" => true, "icommerce.payment-methods.destroy" => true, "icommerce.cartproductoptions.manage" => true, "icommerce.cartproductoptions.index" => true, "icommerce.cartproductoptions.create" => true, "icommerce.cartproductoptions.edit" => true, "icommerce.cartproductoptions.destroy" => true, "icommerce.shipping-methods.manage" => true, "icommerce.shipping-methods.index" => true, "icommerce.shipping-methods.create" => true, "icommerce.shipping-methods.edit" => true, "icommerce.shipping-methods.destroy" => true, "icommerce.shippingmethodgeozones.manage" => true, "icommerce.shippingmethodgeozones.index" => true, "icommerce.shippingmethodgeozones.create" => true, "icommerce.shippingmethodgeozones.edit" => true, "icommerce.shippingmethodgeozones.destroy" => true, "icommerce.paymentmethodgeozones.manage" => true, "icommerce.paymentmethodgeozones.index" => true, "icommerce.paymentmethodgeozones.create" => true, "icommerce.paymentmethodgeozones.edit" => true, "icommerce.paymentmethodgeozones.destroy" => true, "icommerceagree.icommerceagrees.index" => true, "icommerceagree.icommerceagrees.create" => true, "icommerceagree.icommerceagrees.edit" => true, "icommerceagree.icommerceagrees.destroy" => true, "icommercecheckmo.icommercecheckmos.index" => true, "icommercecheckmo.icommercecheckmos.create" => true, "icommercecheckmo.icommercecheckmos.edit" => true, "icommercecheckmo.icommercecheckmos.destroy" => true, "icommercepayu.icommercepayus.index" => true, "icommercepayu.icommercepayus.create" => true, "icommercepayu.icommercepayus.edit" => true, "icommercepayu.icommercepayus.destroy" => true, "icurrency.currencies.manage" => true, "icurrency.currencies.index" => true, "icurrency.currencies.create" => true, "icurrency.currencies.edit" => true, "icurrency.currencies.destroy" => true, "icustom.articles.index" => true, "icustom.articles.create" => true, "icustom.articles.edit" => true, "icustom.articles.destroy" => true, "iforms.forms.manage" => true, "iforms.forms.index" => true, "iforms.forms.create" => true, "iforms.forms.edit" => true, "iforms.forms.destroy" => true, "iforms.fields.manage" => true, "iforms.fields.index" => true, "iforms.fields.create" => true, "iforms.fields.edit" => true, "iforms.fields.destroy" => true, "iforms.leads.manage" => true, "iforms.leads.index" => true, "iforms.leads.create" => true, "iforms.leads.edit" => true, "iforms.leads.destroy" => true, "ilocations.countries.index" => true, "ilocations.provinces.index" => true, "ilocations.geozones.index" => true, "ilocations.geozones_countries.index" => true, "ilocations.geozonescountries.index" => true, "ilocations.cities.index" => true, "ilocations.polygons.index" => true, "ilocations.neighborhoods.index" => true, "profile.api.login" => true, "profile.user.manage" => true, "profile.user.index" => true, "profile.user.index-by-department" => true, "profile.user.create" => true, "profile.user.edit" => true, "profile.fields.index" => true, "profile.fields.create" => true, "profile.fields.edit" => true, "profile.fields.destroy" => true, "profile.addresses.index" => true, "profile.addresses.create" => true, "profile.addresses.edit" => true, "profile.addresses.destroy" => true, "profile.departments.index" => true, "profile.settings.index" => true, "profile.user-departments.index" => true, "profile.user-departments.create" => true, "profile.user-departments.edit" => true, "profile.user-departments.destroy" => true, "profile.role.index" => true, "isite.settings.manage" => true, "isite.settings.index" => true, "isite.settings.edit" => true, "media.medias.index" => true, "media.medias.manage" => true, "media.medias.index-all" => true, "media.medias.create" => true, "media.medias.edit" => true, "media.medias.show" => true, "media.medias.destroy" => true, "media.folders.index" => true, "media.folders.index-all" => true, "media.folders.create" => true, "media.folders.edit" => true, "media.folders.show" => true, "media.folders.destroy" => true, "media.batchs.move" => true, "menu.menus.manage" => true, "menu.menus.index" => true, "menu.menus.create" => true, "menu.menus.edit" => true, "menu.menus.destroy" => true, "menu.menuitems.manage" => true, "menu.menuitems.index" => true, "menu.menuitems.create" => true, "menu.menuitems.edit" => true, "menu.menuitems.destroy" => true, "notification.notifications.index" => true, "notification.rules.index" => true, "notification.templates.index" => true, "notification.providers.index" => true, "page.pages.index" => true, "page.pages.create" => true, "page.pages.edit" => true, "page.pages.manage" => true, "setting.settings.index" => true, "setting.settings.edit" => true, "slider.sliders.manage" => true, "slider.sliders.index" => true, "slider.sliders.create" => true, "slider.sliders.edit" => true, "slider.sliders.edit-system-name" => true, "slider.sliders.update" => true, "slider.slides.manage" => true, "slider.slides.index" => true, "slider.slides.create" => true, "slider.slides.edit" => true, "slider.slides.destroy" => true, "slider.slides.update" => true, "tag.tags.index" => true, "tag.tags.create" => true, "tag.tags.edit" => true, "tag.tags.destroy" => true, "translation.translations.index" => true, "translation.translations.edit" => true, "translation.translations.import" => true, "translation.translations.export" => true, "user.users.index" => true, "user.users.create" => true, "user.users.edit" => true, "user.users.destroy" => true, "user.roles.index" => true, "user.roles.create" => true, "user.roles.edit" => true, "user.roles.destroy" => true, "account.api-keys.index" => true, "account.api-keys.create" => true, "account.api-keys.destroy" => true, "workshop.sidebar.group" => true, "workshop.modules.index" => true, "workshop.modules.show" => true, "workshop.modules.update" => true, "workshop.modules.disable" => true, "workshop.modules.enable" => true, "workshop.modules.publish" => true, "workshop.themes.index" => true, "workshop.themes.show" => true, "workshop.themes.publish" => true]
        ]
      );
      // Find Admin group entity
      $admin = Sentinel::findRoleBySlug('admin');
    }
    
    // Find all other Roles to assign it
    $allOtherRoles = Role::where("slug", "!=", "super-admin")->get();
    
    // Create default Setting to the admin (assignedRoles,assignedSettings)
    $adminAssignedRoles = Setting::where('related_id', $admin->id)
      ->where('entity_name', 'role')
      ->where('name', 'assignedRoles')
      ->first();
    
    if (!isset($adminAssignedRoles->id)) {
      Setting::create(
        [
          'related_id' => $admin->id,
          'entity_name' => 'role',
          'name' => 'assignedRoles',
          'value' => $allOtherRoles->pluck('id')->toArray()
        ]);
    }
    
    $adminAssignedSettings = Setting::where('related_id', $admin->id)
      ->where('entity_name', 'role')
      ->where('name', 'assignedSettings')
      ->first();
    
    if (!isset($adminAssignedSettings->id)) {
      Setting::create(
        [
          'related_id' => $admin->id,
          'entity_name' => 'role',
          'name' => 'assignedSettings',
          'value' => ["Core", "core::site-name", "core::site-name-mini", "core::site-description", "core::analytics-script", "Iblog", "iblog::posts-per-page", "Icommerce", "icommerce::usersToNotify", "icommerce::form-emails", "Icustom", "icustom::socialBackground", "Iforms", "iforms::from-email", "iforms::form-emails", "Isite", "isite::logo1", "isite::logo2", "isite::logo3", "isite::favicon", "isite::brandAddressBar", "isite::brandPrimary", "isite::brandSecondary", "isite::brandAccent", "isite::brandPositive", "isite::brandNegative", "isite::brandInfo", "isite::brandWarning", "isite::brandDark", "isite::socialNetworks", "isite::whatsapp1", "isite::whatsapp2", "isite::whatsapp3", "isite::activateCaptcha", "isite::reCaptchaV2Secret", "isite::reCaptchaV2Site", "isite::reCaptchaV3Secret", "isite::reCaptchaV3Site", "isite::api-maps", "isite::phones", "isite::addresses", "isite::emails", "isite::customCss", "isite::customJs"]
        ],
      );
    }
    
  }
}
