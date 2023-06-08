<div v-if="currentStep==3" class="step-finished">
    
    <div v-if="dataEvent" class="infor-transaction-xpay">
        <div v-if="dataEvent.xpayTranStatus=='approved'" class="alert alert-success" style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;" role="alert">
            <h4 class="alert-heading">TRANSACCION APROBADA</h4>
            <hr>
            <small>status xpay: @{{dataEvent.xpayTranStatus}}</small>
        </div>
        <div v-else-if="dataEvent.xpayTranStatus=='sending'" class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Esperando por el pago</h4>
            <hr>
            <small>status xpay: @{{dataEvent.xpayTranStatus}}</small>
        </div>
        <div v-else class="alert alert-danger" role="alert">
            <h4 class="alert-heading">TRANSACCION RECHAZADA</h4>
            <hr>
            <small>status xpay: @{{dataEvent.xpayTranStatus}}</small>
        </div>

        <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Reedireccionando
        </button>
    </div>
    
</div>