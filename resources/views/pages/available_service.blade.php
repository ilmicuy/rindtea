@foreach ($costs as $cost)
    @php
        $serviceName = $cost['service'];
        $serviceCost = $cost['cost'][0]['value'];
    @endphp
    <div class="delivery-option">
        <input class="delivery-package" type="radio" name="delivery_package" id="inlineRadio{{ $loop->index }}"
            value="{{ $serviceName }}" data-cost="{{ $serviceCost }}">
        <li class="list-group-item">
            <strong>{{ $serviceName }}</strong> -
            {{ $cost['description'] }}: Rp {{ number_format($serviceCost) }}<br>
            Estimasi: {{ $cost['cost'][0]['etd'] }}
        </li>
    </div>
@endforeach
<script>
    $(".delivery-package").click(function() {
        var service = $(this).val();
        var cost = parseFloat($(this).data('cost')); // Pastikan cost adalah float


        var originalTotalPrice = parseFloat($(".total-amount .rupiah").attr('data-price')) || 0;
        var currentShippingCost = parseFloat($(".shipping-cost .rupiah").attr('data-price')) || 0;


        var newTotalPrice = originalTotalPrice - currentShippingCost;

        $.ajax({
            type: 'POST',
            url: '/cost',
            data: {
                _token: "{{ csrf_token() }}",
                service: service,
                cost: cost
            },
            cache: false,
            success: function(response) {
                // Update biaya pengiriman
                $(".shipping-cost .rupiah").attr('data-price', response.cost).text(rupiah(response
                    .cost));

                // Hitung harga total baru
                newTotalPrice += response.cost;

                // Update harga total
                $(".total-amount .rupiah").attr('data-price', newTotalPrice).text(rupiah(
                    newTotalPrice));
                $("input[name='total_price']").val(newTotalPrice);

                // Simpan biaya pengiriman saat ini sebagai biaya pengiriman terakhir
                lastDeliveryCost = response.cost;
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>
