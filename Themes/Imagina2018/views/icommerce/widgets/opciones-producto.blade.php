

<div v-if="product.productOptions.length>0 && product.optionValues.length>0" class="mb-3 d-flex" v-for="(option,index) in product.productOptions">


  <div v-if="option.type=='select'">
    <div >
      <h3 class=" mr-3 text-capitalize">@{{option.description}}:</h3>
      <select class="form-control" v-model="index_product_option_value_selected" @change="update_product(index, index_product_option_value_selected)">
        <option :value="indexOptValue"v-for="(value,indexOptValue) in product.optionValues" v-if="value.optionId==option.optionId">@{{value.optionValue}}</option>
      </select>
    </div>
  </div>


  <div v-for="(value,indexOptValue) in product.optionValues" v-if=" option.type=='color'">
           <!-- If Description is Color-->
          <div v-if="option.description=='Color' || option.optionId==2 ">
            <div class="cc-selector" :id="option.description">
              <input 
              :title="value.optionValue" :id="value.optionValueId"
               type="radio" :name="option.description" :value="indexOptValue"
                v-model="index_product_option_value_selected"
                @change="update_product(index, indexOptValue)"/>

               <label :title="value.optionValue" class="drinkcard-cc" :for="value.optionValueId">

                <span v-if="value.mainImage.path== url+'/modules/iblog/img/post/default.jpg'">
                    @{{value.optionValue}}
                  </span>

                <span  v-else :style="'background-image: url('+value.mainImage.path+'); width:25px;height:25px;'"> 
                </span>

              </label>
            </div>
          </div>
          <!--End Description Color-->
           <div v-else>
             <div class="custom-control custom-radio mb-2 ml-4">

                <input type="radio" :name="option.description" :value="indexOptValue" v-model="index_product_option_value_selected" @change="update_product(index, indexOptValue)" :id="value.id" class="custom-control-input">

                <label class="custom-control-label" :for="value.id">

                  <span v-if="value.mainImage.path== url+'/modules/iblog/img/post/default.jpg'">
                    @{{value.description}}
                  </span>
                  <span v-else :style="'{ backgroundColor:'+ value.option.background +'; backgroundImage: url(' + value.mainImage.path + ') }'">
                    &nbsp;
                  </span>
                </label>
              </div>
           </div>

  </div>



  <!-- If option type-->
  <!-- <div v-for="(option,index) in product.productOptions" v-if=" option.type=='select'" class="option">
    <a class="d-flex justify-content-between align-items-center link-fa"  data-toggle="collapse" :href="'#collapse-'+option.id" role="button" aria-expanded="false"  :aria-controls="'collapse-'+option.id">
      <span>Seleccionar @{{option.description}}</span> <i class="fa fa-angle-down"></i>
    </a>

    <div :id="'collapse-'+option.id" class="sub-option collapse">
      <div class="coll">
        <a v-for="(value,indexOptValue) in product.optionValues"  @click="update_product(index, indexOptValue)" class="d-flex justify-content-between align-items-center"  :id="value.id" :value="indexOptValue" ><span>@{{value.optionValue}}</span>
        </a>
      </div>
    </div>
  </div> -->



  <!-- end option type-->
</div>
