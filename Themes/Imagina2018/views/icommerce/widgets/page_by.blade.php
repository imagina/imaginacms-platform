<div class="filter-order text-right vue-load ml-2">
    <span class="d-inline-block font-weight-light mr-2">Productos por pagina
'  }} 
</span>
    <div class="d-inline-block">
        <select class="form-control rounded-0" v-model.number="paginate" v-on:change="getProducts()">
            <option value='15' selected>15</option>
            <option value='10'>10</option>
            <option value='5'>5</option>
        </select>
    </div>
</div>