@php
    $all_clients_hours = $WorkerClient->where('client_id',$wc->client_id)->sum('hours')*1000;
    $OPEX = (!empty($wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)) ? $wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)->fee*0.35 : 0);
    $fee = (!empty($wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)) ? $wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)->fee : 0);
    $profit = $fee - $OPEX - $all_clients_hours;
    $marginality = (!empty($wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)) ? round($profit*100/$fee,2) : 0);
@endphp
<table class="table table-sm client-table mb-0">
    <tbody>
        <tr>
            <td colspan="2" style="border-top: 0">ИТОГО Себестоимость</td>
            <td style="border-top: 0; text-align: right;" class="setedCostPrice">{{ $all_clients_hours }}</td>
        </tr>
        <tr>
            <td colspan="2">OPEX (35%)</td>
            <td style="text-align: right;" class="setedOPEX">{{ round($OPEX,0) }}</td>
        </tr>
        <tr>
            <td colspan="2">ГОНОРАР</td>
            <td style="text-align: right;"><a href="#" class="setFee-btn" data-toggle="modal" data-target="#setFee" data-client_id="{{ $wc->client_id }}"><i class="far fa-edit"></i></a> <span class="setedFee">{{ $fee }}</span></td>
        </tr>
        <tr>
            <td colspan="2">ПРИБЫЛЬ</td>
            <td style="text-align: right; font-weight: bold;"><span class="seted_profit">{{ round($profit,0) }}</span></td>
        </tr>
        <tr>
            <td colspan="2">МАРЖИНАЛЬНОСТЬ</td>
            <td style="text-align: right; font-weight: bold;" class="marginality">{{ $marginality }}%</td>
        </tr>
    </tbody>
</table>
