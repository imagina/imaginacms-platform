<div v-if="currentStep==2" class="step-payment">

    <h5 class="card-title font-weight-bold">Proceso de Pago</h5>

    <div v-if="dataPayment && dataPayment.status=='sending' " class="infor">

        <div class="qr">
            <img :src="dataPayment.qrImg" alt="QR code">
        </div>
    
        <div class="infor row justify-content-center ">
            <div class="col-sm-8">
            <ul class="list-group list-group-flush text-left">
                <li class="list-group-item">
                    <label><strong>Monto a pagar (@{{dataPayment.currency_to_paid}}):</strong></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control"  :value="dataPayment.amount_to_paid" id="walletAmount" readonly aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" @click="copyText('walletAmount')" type="button">Copiar</button>
                        </div>
                    </div>
                </li>   
                {{--
                <li class="list-group-item">
                    <strong>Monto a pagar:</strong> 
                        @{{dataPayment.amount_to_paid}} @{{dataPayment.currency_to_paid}}
                </li>
                --}}
                <li class="list-group-item">
                    <label><strong>Wallet:</strong> </label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control"  :value="dataPayment.wallet" id="walletCode" readonly aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" @click="copyText('walletCode')" type="button">Copiar</button>
                        </div>
                    </div>
                </li>
                {{--
                <li class="list-group-item">
                    <strong>Wallet:</strong>
                    @{{dataPayment.wallet}}
                </li>
                --}}
                <li class="list-group-item d-flex align-items-start">
                    <strong>Tiempo:</strong>
                    <div class="timer ml-2 badge badge-secondary p-2 text-wrap" style="font-size:1rem">
                        <b id="xpay-timer"></b>
                    </div>
                </li>
            </ul>
            </div>
        </div>
    
        <button class="btn btn-primary mt-4" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Esperando confirmación de Pago
         </button>

    </div>
   
</div>