@php
		// $currencies and $currencyRates
@endphp
<form action="{{ route('currency.update') }}" method="post">
       @csrf
       <table {{$attributes->merge(['class' => 'table table-striped table-sm table-bordered table-hover'])}}>
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
													 $value = $currencyRow->id == $currencyCol->id ? 1 : $currencyRates->where('from_currency_id', $currencyRow->id)->where('to_currency_id', $currencyCol->id)->first()->rate ?? '';
											 @endphp
													 <td>
															 <input step="0.001" type="number" name="currency[{{ $currencyRow->id }}][{{ $currencyCol->id }}]" @if ($currencyRow->id == $currencyCol->id) disabled @endif
																	 class="form-control" value="{{ $value }}">
													 </td>
													 @endforeach
                   </tr>
               @endforeach
           </tbody>
       </table>
       <button class="btn btn-primary ml-auto d-block ms-auto">{{ __('Save') }}</button>
   </form>
