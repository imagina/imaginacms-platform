<div v-if="currentStep==1" class="step-currencies">

    <h5 class="card-title font-weight-bold">Seleccione la Moneda</h5>

    <form @submit.prevent="onStep(2)">

        <ul class="list-group text-left list-group-flush w-75 mx-auto">

            <li v-for="(crc,index) in sortedCurrencies" :key="index" class="list-group-item">
                <div class="custom-control custom-radio">
                    <input name="radioCurrencies" type="radio" class="custom-control-input" :value="crc" :id="'in-'+index" v-model="selectedCurrency" required>
                    <label class="custom-control-label"  :for="'in-'+index">
                        @{{crc.currency.name}} (@{{crc.currency.symbol}}) - Monto: @{{crc.amount}}
                    </label>
                </div>
            </li>   

        </ul>

        {{--
        <select class="custom-select" v-model="selectedCurrency" required>
            <option v-for="(crc,index) in data.currencies" :key="index" :value="crc">
                @{{crc.currency.name}} - Monto: @{{crc.amount}}
            </option>
        </select>
        --}}

        <button type="submit" class="btn btn-primary mt-3">Aceptar</button>

    </form>
    
</div>