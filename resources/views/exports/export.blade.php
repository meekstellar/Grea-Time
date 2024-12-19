<table style="font-family: DejaVu Sans;">
    @if(!empty($WorkerClientHours) && count($WorkerClientHours) > 0)

                <thead>
                    <tr>
                        <td style="font-size: 26px; font-weight: bold; font-family: DejaVu Sans;" colspan="2">Отчет</td>
                        <td></td>
                        @if(in_array($selectCountDays, [28,29,30,31]))
                        <td></td>
                        <td></td>
                        @endif
                    </tr>
                    <tr>
                        <td style="font-size: 12px;" colspan="2">{{ $date_or_period[0] }}{{ (!empty($date_or_period[1]) ? ' - '.$date_or_period[1] : '') }}</td>
                        <td></td>
                        @if(in_array($selectCountDays, [28,29,30,31]))
                        <td></td>
                        <td></td>
                        @endif
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if(in_array($selectCountDays, [28,29,30,31]))
                        <td></td>
                        <td></td>
                        @endif
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if(in_array($selectCountDays, [28,29,30,31]))
                        <td></td>
                        <td></td>
                        @endif
                    </tr>
                </thead>
        @foreach($WorkerClientHours->unique('client_id') as $wc)
            @if($wc->client()->active)
                <thead>
                    <tr>
                        <td style="font-size: 18px; font-weight: bold; font-family: DejaVu Sans;" colspan="{{ (in_array($selectCountDays, [28,29,30,31]) ? 5 : 3) }}">{{ $wc->client()->name }}</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $processed = [];
                        $all_clients_hours = 0;
                        $k=1;
                    @endphp
                    @foreach($WorkerClientHours->where('client_id',$wc->client_id) as $wc_workers)
                        @if(!in_array($wc_workers->worker_id,$processed))
                        @php
                            $worker_salary = (!empty($WorkersSalaryArray[$wc_workers->worker_id][\Date::parse($wc_workers->created_at)->format('Y')][\Date::parse($wc_workers->created_at)->format('n')]) ? $WorkersSalaryArray[$wc_workers->worker_id][\Date::parse($wc_workers->created_at)->format('Y')][\Date::parse($wc_workers->created_at)->format('n')] : 0);
                        @endphp
                        <tr>
                            <td>{{ $k }}.</td>
                            <td width="50" style="@if($wc_workers->worker()->active == 0) text-decoration: line-through; @endif font-family: DejaVu Sans;">{{ $wc_workers->worker()->name }} ({{ $wc_workers->worker()->position }})</td>
                            <td style="text-align: right; font-family: DejaVu Sans;">
                                @php
                                    $clients_hours = $wchArray[$wc->client_id][$wc_workers->worker_id];
                                    $pay_per_one_hour = 0;
                                    if(!empty($worker_salary)){
                                        $pay_per_one_hour = $worker_salary/160;
                                    }
                                    $all_clients_hours += $clients_hours*$pay_per_one_hour;
                                @endphp
                                {{ $clients_hours }}&nbsp;ч.
                            </td>
                            @if(in_array($selectCountDays, [28,29,30,31]) && (auth()->user()->access_to_salary || auth()->user()->manager_important))<td style="font-family: DejaVu Sans;">{{ $worker_salary }} ₽ / мес</td>@endif
                            @if(in_array($selectCountDays, [28,29,30,31]) && (auth()->user()->access_to_salary || auth()->user()->manager_important))
                                <td style="width: 80px; text-align: right; white-space: nowrap; font-family: DejaVu Sans;">{{ $clients_hours*$pay_per_one_hour }} {{ $currency }}</td>
                            @endif
                        </tr>
                        @php
                            $processed[] = $wc_workers->worker_id;
                            $k++;
                        @endphp
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    @if(in_array($selectCountDays, [28,29,30,31]))
                    @php
                        $fee =  (!empty($wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)) ? $wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)->fee : 0);
                        $OPEX = $fee*0.35;
                        $profit = $fee - $OPEX - $all_clients_hours;
                        $marginality = (!empty($fee) ? round($profit*100/$fee,2) : 0);
                    @endphp
                                <tr>
                                    <td></td>
                                    <td style="font-family: DejaVu Sans;">ИТОГО Себестоимость</td>
                                    <td width="11" style="text-align: right; font-family: DejaVu Sans;">{{ $all_clients_hours }} {{ $currency }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-family: DejaVu Sans;">OPEX (35%)</td>
                                    <td style="text-align: right; font-family: DejaVu Sans;">{{ round($OPEX,0) }} {{ $currency }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-family: DejaVu Sans;">ГОНОРАР</td>
                                    <td style="text-align: right; font-family: DejaVu Sans;">{{ $fee }} {{ $currency }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-family: DejaVu Sans;">ПРИБЫЛЬ</td>
                                    <td style="text-align: right; font-weight: bold; font-family: DejaVu Sans;">{{ round($profit,0) }} {{ $currency }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-family: DejaVu Sans;">МАРЖИНАЛЬНОСТЬ</td>
                                    <td style="text-align: right; font-weight: bold; font-family: DejaVu Sans;">{{ $marginality }}%</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                    @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: right; font-weight: bold; font-family: DejaVu Sans;">{{ $WorkerClientHours->where('client_id',$wc->client_id)->sum('hours') }}&nbsp;ч.</td>
                    </tr>
                    @endif
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if(in_array($selectCountDays, [28,29,30,31]))
                        <td></td>
                        <td></td>
                        @endif
                    </tr>
                </tfoot>
            @endif
        @endforeach
    @endif
</table>
