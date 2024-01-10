@php
    // $currencies and $currencyRates
@endphp
<form action="{{ route('currency.update') }}" method="post">
    @csrf

    @isset($selectActive)
        <select id="curreny_package_select2" class="form-control mb-3 w-auto" name="active_currency_ids[]"
            style="min-width: 300px">
        </select>
    @endisset

    <table {{ $attributes->merge(['class' => 'table table-striped table-sm table-bordered table-hover']) }}>
        <thead>
            <th></th>
            @foreach ($currencies as $currency)
                <th>
                    {{ $currency->name }} ({{ $currency->symbol }})
                </th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($currencies as $currencyRow)
                <tr>
                    <td style="vertical-align: middle">
                        {{ $currencyRow->name }} ({{ $currencyRow->symbol }})
                    </td>
                    @foreach ($currencies as $currencyCol)
                        @php
                            $value =
                                $currencyRow->id == $currencyCol->id
                                    ? 1
                                    : $currencyRates
                                            ->where('from_currency_id', $currencyRow->id)
                                            ->where('to_currency_id', $currencyCol->id)
                                            ->first()->rate ?? '';
                        @endphp
                        <td>
                            <input step="0.001" type="number"
                                name="currency[{{ $currencyRow->id }}][{{ $currencyCol->id }}]"
                                @if ($currencyRow->id == $currencyCol->id) disabled @endif class="form-control"
                                value="{{ $value }}">
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn btn-primary ml-auto d-block ms-auto">{{ __('Save') }}</button>
</form>
@isset($selectActive)
    <script>
        $("#curreny_package_select2").select2({
            ajax: {
                url: "{{ route('currency.select2') }}",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true,
            },
            multiple: true,
            placeholder: "{{ __('Select currency') }}",
            allowClear: true,
            minimumInputLength: 1,
        });

        @foreach ($currencies as $currency)
            $("#curreny_package_select2").append(
                new Option("{{ $currency->name }} ({{ $currency->symbol }})", "{{ $currency->id }}", true, true)
            ).trigger("change");
        @endforeach
    </script>
@endisset
