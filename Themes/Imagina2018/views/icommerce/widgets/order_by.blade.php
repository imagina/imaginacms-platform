<div class="filter-order row border-left border-right">
   		
		
        <select id="Ordenar" class="form-control rounded-0" v-model="order_check" v-on:change="order_by()">
          <option value="all"  selected="" disabled>Organizar por  </option>
        	<option value="nameaz">{{ trans('icommerce::common.sort.name_a_z') }}</option>
            <option value="nameza">{{ trans('icommerce::common.sort.name_z_a') }}</option>
            <option value="all" >{{ trans('icommerce::common.sort.all') }}</option>
        </select>

</div>
