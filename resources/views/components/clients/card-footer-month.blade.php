@php
    $all_clients_hours = $WorkerClient->where('client_id',$wc->client_id)->sum('hours')*1000;
    $OPEX = $wc->client()->fee(2024,7)->fee*0.35;
    $fee = $wc->client()->fee(2024,7)->fee;
    $profit = $fee - $OPEX - $all_clients_hours;
@endphp
<table class="table table-sm client-table mb-0">
    <tbody>
        <tr>
            <td colspan="2" style="border-top: 0">ИТОГО Себестоимость</td>
            <td style="border-top: 0; text-align: right;">{{ $all_clients_hours }}</td>
        </tr>
        <tr>
            <td colspan="2">OPEX (35%)</td>
            <td style="text-align: right;">{{ $OPEX }}</td>
        </tr>
        <tr>
            <td colspan="2">ГОНОРАР</td>
            <td style="text-align: right;">{{ $fee }}</td>
        </tr>
        <tr>
            <td colspan="2">ПРИБЫЛЬ</td>
            <td style="text-align: right; font-weight: bold;">{{ $profit }}</td>
        </tr>
        <tr>
            <td colspan="2">МАРЖИНАЛЬНОСТЬ</td>
            <td style="text-align: right; font-weight: bold;">{{ round($profit*100/$fee,2) }}%</td>
        </tr>
    </tbody>
</table>
