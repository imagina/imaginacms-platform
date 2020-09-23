

<template>
  <div>
    <div v-if="categories.length>0 ">
      <div
        v-for="(item,index) in categories"
        :key='index'
      >
        <div
          v-if="item.childrens.length>0 &&item.id!=13 && item.id!=14 && item.id!=16"
          class="categoria"
          v-bind:class="{'border-bottom pb-2': isparent}"
        >
          <ul
            class="buttons"
            v-bind:class="{'category-title': isparent}"
          >
            <li>
              <input
                name="cat"
                :id="index+'-'+item.id"
                class="radiobtn"
                type="radio"
                data-toggle="collapse"
                :href="'#collapse-'+item.id"
                role="button"
                aria-expanded="true"
                :aria-controls="'collapse-'+item.id"
              >
              <span></span>
              <label :for="index+'-'+item.id">{{item.title}}
              </label>
            </li>
          </ul>

          <category
            :parent="item.id"
            :id="'collapse-'+item.id"
            class="sub-categoria collapse show ml-2"
            :aria-labelledby="'collapse-'+item.id"
          ></category>

        </div>
        <div
          v-if="item.childrens.length==0 &&item.id!=13 && item.id!=14 && item.id!=16"
          class="categoria"
          v-bind:class="{'border-bottom': isparent}"
        >

          <ul
            class="buttons"
            v-bind:class="{'category-title': isparent}"
          >
            <li>
              <input
                name="cat"
                :id="index+'-'+item.id"
                class="radiobtn"
                type="radio"
                v-on:click=" filterCategory(item)"
              >
              <span></span>
              <label :for="index+'-'+item.id">{{item.title}}
              </label>
            </li>
          </ul>

        </div>
      </div>
    </div>
    <div
      v-else
      class="categoria"
    >
      No hay categorias disponibles
    </div>
  </div>
</template>
<script>
export default {
  props: [
    'parent',
    'path',
    'isparent'
  ],
  data() {
    return {
      url: icommerce.url,
      categories: [],
    }
  },
  created() {
    this.getCategory();
  },
  methods: {
    getCategory: function (cat) {
      axios.get(this.url + '/api/icommerce/v3/categories?filter={"parentId":' + this.parent + '}&include=children', {
      }).then(response => {
        this.categories = response.data.data
      }).catch(e => {
        console.log(e)
      })
    },
    filterCategory: function (i) {
      bus.$emit('category-e', i);
    },
  },
}
</script>
