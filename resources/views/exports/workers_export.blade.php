<table>
    @foreach($workers as $i => $worker)
        @php
            $clientHours = $worker->clientHours->sum('hours');
            $processed = [];
        @endphp
        <thead>
            @if($i > 0)
                <tr>
                    <td height="30" colspan="9"></td>
                </tr>
            @else
                <tr>
                    <td height="30" style="font-size: 24px;">Период: {{ implode('-', $dateOrPeriod) }}</td>
                </tr>
                <tr>
                    <td height="30"></td>
                </tr>
            @endif
            <tr>
                <td height="25" style="font-size: 18px; font-weight: bold;" colspan="9">{{ $worker->name }} ({{ $worker->position }})</td>
            </tr>
            <tr>
                <td style="font-size: 14px;" colspan="9">{{ $worker->email }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach($worker->clientHours as $client)
                @if($selectCountDays === 1)
                    <tr>
                        <td style="font-size: 14px">{{ $loop->iteration }}</td>
                        <td colspan="3" style="font-size: 14px;">{{ $client->clientRelation->name }}</td>
                        <td colspan="2" style="font-size: 14px; text-align: right;">{{ $client->hours }}ч.</td>
                    </tr>
                @elseif(!in_array($client->clientRelation->id,$processed))
                    <tr>
                        <td style="font-size: 14px">{{ $loop->iteration }}</td>
                        <td colspan="3" style="font-size: 14px;">{{ $client->clientRelation->name }}</td>
                        <td colspan="2" style="font-size: 14px; text-align: right;">{{ $worker->clientHoursByClient->where('client_id', $client->client_id)->first()?->hours_sum_by_client }}ч.</td>
                    </tr>
                    @php
                        $processed[] = $client->clientRelation->id;
                    @endphp
                @endif
            @endforeach
            <tr>
                <td colspan="6" style="font-size: 14px; text-align: right">
                    Всего {{ $clientHours }}ч.
                </td>
            </tr>
        </tbody>
    @endforeach
</table>
