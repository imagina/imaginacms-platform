
<div class="filter-categories mb-4">
   
   <div class="title">
      <a data-toggle="collapse" href="#collapseCategories" role="button" aria-expanded="true" aria-controls="collapseManufacturers" class="collapse">
         
         <h5 class="p-3 border-top border-bottom">
         Test
            <i class="fa fa angle float-right" aria-hidden="true"></i>
         </h5>
      
      </a>
   </div>
   
   <div class="collapse " id="collapseCategories">
      <div class="row">
         <div class="col-12">
            <div class="list-categories">
               <ul class="list-group list-group-flush">
               
               
               
               
               </ul>
            </div>
         </div>
      </div>
   </div>

</div>

<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

   <a class="nav-link @if(isset($user->id) && $user->roles->first()->slug!='client') active @endif"
      href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.iprofile.account.index')}}"
      
      aria-selected="true">
      <i class="fa fa-edit mr-2" onclick="$('#img-profile').show();$('#img-profile-store').hide();"></i>
      {{trans('iprofile::frontend.title.profile')}}
   </a>


   <a class="nav-link" href="{{url('/account/logout')}}"><i class="fa fa-sign-out mr-2"></i>
      {{trans('iprofile::frontend.button.sign_out')}}
   </a>

</div>


