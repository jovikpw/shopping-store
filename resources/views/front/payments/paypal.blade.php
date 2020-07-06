<tr>
    <td>
        @if(isset($payment['name']))
            {{ ucwords($payment['name']) }}
        @else
            <p class="alert alert-danger">У вас должно быть <strong>имя</strong> ключа в настройках</p>
        @endif
    </td>
    <td>
        @if(isset($payment['description']))
            {{ $payment['description'] }}
        @endif
    </td>
    <td>
        <form action="{{ route('checkout.store') }}" method="post" class="pull-right" id="payPalForm">
            {{ csrf_field() }}
            <input type="hidden" name="payment" value="{{ config('paypal.name') }}">
            <input type="hidden" class="billing_address" name="billing_address" value="">
            <input type="hidden" class="delivery_address_id" name="delivery_address" value="">
            <input type="hidden" class="courier" name="courier" value="">
            <button onclick="return confirm('Вы уверены?')" type="submit" class="btn btn-success pull-right">Оплатить через {{ ucwords($payment['name']) }} <i class="fa fa-paypal"></i></button>
        </form>
    </td>
</tr>
<script type="text/javascript">
    $(document).ready(function () {
        let billingAddressId = $('input[name="billing_address"]:checked').val();
        $('.billing_address').val(billingAddressId);

        $('input[name="billing_address"]').on('change', function () {
          billingAddressId = $('input[name="billing_address"]:checked').val();
          $('.billing_address').val(billingAddressId);
        });

        let courierRadioBtn = $('input[name="rate"]');
        courierRadioBtn.click(function () {
            $('.rate').val($(this).val())
        });
    });
</script>