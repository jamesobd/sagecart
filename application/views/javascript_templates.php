<script id="product-listitem" type="text/template">
    <div class="item row">
        {{#if ImageFile }}
        <div class="image col-md-2">
            <img src="http://images.gulfpackaging.com/img/TST/{{ImageFile}}" class="img-responsive img-thumbnail"/>
        </div>
        <div class="details col-md-7">
            <h4>{{#if ItemName}}{{ItemName}}{{else}}{{ItemCodeDesc}}{{/if}}</h4>

            <p>{{ItemLongDesc}}</p>
            {{#if OrderIncrement}}
            <p>Item must be ordered in multiples of {{OrderIncrement}}</p>
            {{/if}}
            <p>Item #: {{ItemCode}}</p>
        </div>
        {{else}}
        <div class="details col-md-7">
            <h4>{{#if ItemName}}{{ItemName}}{{else}}{{ItemCodeDesc}}{{/if}}</h4>

            <p>{{ItemLongDesc}}</p>
            {{#if OrderIncrement}}
            <p>Item must be ordered in multiples of {{OrderIncrement}}</p>
            {{/if}}
            <p>Item #: {{ItemCode}}</p>
        </div>
        {{/if}}
        <div class="item-price col-md-5">
            <div class="item-msrp row">
                ${{formatDecimalLengthTwo CustomerPrice}} / {{SalesUnitOfMeasure}}
            </div>
            <div class="item-qty row">
                <strong>Qty</strong>:
                <input type="text" name="quantity" value="" class="quantity input-sm">
            </div>
            {{#compare UDF_IT_PER_PALLET "!=" 0}}
            <div class="row">
                <strong>Pallets</strong>: <span class="pallet-quantity">0.00</span>
            </div>
            {{/compare}}
        </div>
    </div>
</script>

<script id="product-cartlistitem" type="text/template">
    <div class="item row">
        {{#if ImageFile }}
        <div class="image col-md-3">
            <img src="http://images.gulfpackaging.com/img/TST/{{ImageFile}}" class="img-responsive img-thumbnail"/>
        </div>
        <div class="details col-md-6 dl-horizontal">
            <h4 class="product-title">{{#if ItemName}}{{ItemName}}{{else}}{{ItemCodeDesc}}{{/if}}</h4> <a href="" class="remove-from-cart">Remove</a>
            {{#if OrderIncrement}}
            <p>Item must be ordered in multiples of {{OrderIncrement}}</p>
            {{/if}}
            <p>Item #: {{ItemCode}}</p>
        </div>
        {{else}}
        <div class="details col-md-9 dl-horizontal">
            <h4 class="product-title">{{#if ItemName}}{{ItemName}}{{else}}{{ItemCodeDesc}}{{/if}}</h4> <a href="" class="remove-from-cart">Remove</a>
            {{#if OrderIncrement}}
            <p>Item must be ordered in multiples of {{OrderIncrement}}</p>
            {{/if}}
            <p>Item #: {{ItemCode}}</p>
        </div>
        {{/if}}
        <div class="item-action col-md-3">
            <div class="row">
                <div class="item-desc-label col-md-6">
                    <strong>Price</strong>:
                </div>
                <div class="quantity-css col-md-6">
                    ${{formatDecimalLengthCustomerPrice}} / {{SalesUnitOfMeasure}}
                </div>
            </div>
            <div class="row">
                <div class="item-desc-label col-md-6">
                    <div class="quantity-label">
                        <strong>Qty</strong>:
                    </div>
                </div>
                <div class="quantity-css col-md-2">
                    <input type="text" name="quantity" value="{{_Quantity}}" class="quantity quantity-input input-sm" />
                </div>
                <div class="quantity-label quantity-css col-md-4">
                    <a href="" class="update-cart" style="visibility: hidden">Update</a>
                    {{#if _Remove}}
                    <a href="" class="remove-from-cart">Remove</a>
                    {{/if}}
                </div>
            </div>
            {{#compare UDF_IT_PER_PALLET "!=" 0}}
            <div class="row">
                <div class="item-desc-label col-md-6">
                    <strong>Pallets</strong>:
                </div>
                <div class="pallet-quantity quantity-css col-md-6">
                    {{#if _PalletQuantity}}{{_PalletQuantity}}{{else}}0.00{{/if}}
                </div>
            </div>
            {{/compare}}
            <div class="row">
                <div class="item-desc-label col-md-6">
                    <strong>Item Total</strong>:
                </div>
                <div class="quantity-css col-md-6">
                    ${{formatDecimalLength ItemTotalPrice}}
                </div>
            </div>
        </div>
    </div>
</script>

<script id="header-cart-template" type="text/template">
    <span id="cart-logo" class="glyphicon glyphicon-shopping-cart"></span>
    <span id="cart-amount">${{formatDecimalLength _CartAmount}}</span>
    <span id="cart-items">({{_CartItems}})</span>
</script>

<script id="product-body-header" type="text/template">
    <div id="items-per-page">
        {{#if _Pagination}}
        <span id="show-page" class="rightAlign">
            <label for="show-page-option">Show:</label>
            <select id="show-page-option" class="form-control">showPageOption
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </span>
        {{/if}}
    </div>
</script>

<script id="pagination-header" type="text/template">
    <div id="pagination-top" class="top-buttons row">
        <div class="pagination-numbers col-md-6 col-md-offset-3">
            {{#if _Previous}}<span class="pagination-previous"><< Prev</span>{{/if}}
            {{#if _PreviousEllipses}}<span class="pagination-previous-ellipses">...</span>{{/if}}
            {{#compare _NumberOfPages ">" 1}}
            {{#each _Pages}}
            <span class="pagination-page{{#if _Current}} bold{{/if}}">{{_Number}}</span>
            {{/each}}
            {{/compare}}
            {{#if _NextEllipses}}<span class="pagination-next-ellipses">...</span>{{/if}}
            {{#if _Next}}<span class="pagination-next">Next >></span>{{/if}}
        </div>
    </div>
</script>

<script id="pagination-footer" type="text/template">
    <div id="pagination" class="row">
        <div class="pagination-numbers col-md-6 col-md-offset-3">
            {{#if _Previous}}<span class="pagination-previous"><< Prev</span>{{/if}}
            {{#if _PreviousEllipses}}<span class="pagination-previous-ellipses">...</span>{{/if}}
            {{#compare _NumberOfPages ">" 1}}
            {{#each _Pages}}
            <span class="pagination-page{{#if _Current}} bold{{/if}}">{{_Number}}</span>
            {{/each}}
            {{/compare}}
            {{#if _NextEllipses}}<span class="pagination-next-ellipses">...</span>{{/if}}
            {{#if _Next}}<span class="pagination-next">Next >></span>{{/if}}
        </div>
    </div>
</script>

<script id="product-list-pallets" type="text/template">
    <div {{_className}}>
        <div class="pallet-totals rightAlign">
            <strong>Pallets In Cart</strong>: <span class="pallets-in-cart">{{formatDecimalLength _palletsInCart}}</span>
        </div>
        <div class="pallet-totals rightAlign">
            <strong>Pallets To Be Added</strong>: <span class="pallets-to-add">0.00</span>
        </div>
        <div class="pallet-totals rightAlign new-total-pallets-div">
            <strong>New Total Pallets</strong>: <span class="new-total-pallets">{{formatDecimalLength _palletsInCart}}</span>
        </div>
        <div class="item-btn rightAlign">
            <button class="btn  btn-default add-to-cart"><i class="icon-shopping-cart"></i> Add All Items to Cart</button>
        </div>
    </div>
</script>

<script id="cart-body-info" type="text/template">
    <div class="cart-bottom row">
        <div id="freight-info-desc" class="col-md-9 leftAlign">
            <strong>
                {{_UDF_FREIGHT_INFO}}
            </strong>
        </div>
        <div class="col-md-3">
            <div id="cart-total" class="row">
                <strong>
                    <div class="item-desc-label col-md-6">Total Pallets:</div>
                    {{formatDecimalLength _TotalPallets}}
                </strong>
            </div>
            <div id="cart-total" class="row">
                <strong>
                    <div class="item-desc-label col-md-6">Subtotal:</div>
                    ${{formatDecimalLengthTwo SubTotal}}
                </strong>
            </div>
            <div id="cart-total" class="row">
                <strong>
                    <div class="item-desc-label col-md-6">Freight:</div>
                    {{#if ShipToAddress}}
                        $0.00
                    {{else}}
                        <span>See freight info</span>
                    {{/if}}
                </strong>
            </div>
            <div id="cart-total" class="row">
                <strong>
                    <div class="item-desc-label col-md-6">Tax:</div>
                    ${{formatDecimalLengthTwo SalesTaxAmt}}
                </strong>
            </div>
            <div id="cart-total" class="row">
                <strong>
                    <div class="item-desc-label col-md-6">Total:</div>
                    ${{formatDecimalLengthTwo _CartTotal}}
                </strong>
            </div>
        </div>
    </div>
    <div id="comments-div" class="cart-bottom">
        <div class="col-md-7"></div>
        <div class="col-md-5">
            <div>Order Comments</div>
        </div>
        <textarea name="ShippingComments" id="shipping-comments" class="form-control">{{Comment}}</textarea>
        <div id="comments-chars">0 of 2048</div>
    </div>
    <div id="contact-number">
        <span><b>For questions or contact inquiries</b></span>
        <span>call 1-877-505-8909</span>
        <span>or send us <a href="/contactus">an email.</a></span>
    </div>
    <div id="submit-area">
        <div id="submit-alert" class="alert alert-info">
            <p><strong>Please confirm you are ready to submit your order.</strong></p>

            <p><strong>Pressing the button to continue.</strong></p>
            <input id="submit-button-confirm" type="button" value="Submit Order" class="btn btn-primary btn-lg"/>
            <input id="submit-button-cancel" type="button" value="Cancel" class="btn btn-info btn-lg"/>
        </div>
        <div id="submit-init">
            <input id="submit-button-init" type="button" value="Submit Order" class="btn btn-primary btn-lg"/>
        </div>
    </div>
</script>