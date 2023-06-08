<div class="bkng-tb-cntnt">
    <div class="pymnts">
        <form action="#" method="POST" id="payment-form">
            <input type="hidden" name="token_id" id="token_id">
            <div class="pymnt-itm card active">
                
                <h2>Tarjeta de crédito o débito</h2>
                <div class="pymnt-cntnt p-3">
                    
                    <div class="row">
                        <div class="col-xs-12 col-md-6 credit">
                            <h6>Tarjetas de crédito</h6>
                        </div>
                        <div class="col-xs-12 col-md-6 debit">
                            <h6>Tarjetas de débito</h6>
                        </div>
                    </div>

                    <div class="row sctn-row">

                        <div class="col-xs-12 col-md-6 sctn-col l">
                                <label>Nombre del titular</label>
                                <input type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                        </div>

                        <div class=" col-xs-12 col-md-6 sctn-col">
                                <label>Número de tarjeta</label>
                                <input type="text" autocomplete="off" data-openpay-card="card_number">
                        </div>

                    </div>

                      
                    <div class="row sctn-row">

                            <div class="col-xs-12 col-md-6 sctn-col l">
                                <label>Fecha de expiración</label>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6 sctn-col half l"><input type="text" placeholder="Mes" data-openpay-card="expiration_month"></div>
                                    <div class="col-xs-12 col-md-6 sctn-col half l"><input type="text" placeholder="Año" data-openpay-card="expiration_year"></div>
                                </div>
                                    
                            </div>

                            <div class="col-xs-12 col-md-6 sctn-col cvv">
                                <label>Código de seguridad</label>
                                <div class="sctn-col half l"><input type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2"></div>
                            </div>

                    </div>
                        
                    <div class="row openpay">
                            <div class="logo">Transacciones realizadas vía:</div>
                        
                            <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
                    </div>

                    <div class="row sctn-row justify-content-end">
                            <a class="button cursor-pointer rght" id="pay-button">Pagar: {{formatMoney($config->order->total)}}</a>
                    </div>
                        

                </div>

            </div>
        </form>
    </div>
</div>