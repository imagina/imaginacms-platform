

<template>
  <ul v-if="categories.length>0 ">
    <li
      v-for="(item,index) in categories"
      :key='index'
    >
      <a
        class="dropdown-item"
        v-if="item.childrens.length==0 &&item.id!=13 && item.id!=14"
        :href="url+'/'+item.slug"
      >
        {{item.title}}
      </a>
      <a
        href="#"
        class="dropdown-item dropdown-toggle"
        v-if="item.childrens.length>0 &&item.id!=13 && item.id!=14"
      > {{item.title}}
      </a>
      <category-dropdown
        :parent="item.id"
        v-if="item.childrens.length>0 &&item.id!=13 && item.id!=14"
        class="submenu dropdown-menu"
      ></category-dropdown>

    </li>
  </ul>

</template>
<script>
export default {
  props: [
    'parent',
    'path',
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
