<table class="table table-sm client-table">
    <tbody>
    @php
        $processed = [];
    @endphp
    @foreach($worker->clientHours as $client)
        @if(!in_array($client->clientRelation->id,$processed))
            <tr>
                <td style="width: 10px">{{ $loop->iteration }}.</td>
                <td class="user_active_{{ $client->clientRelation->active }}">{{ $client->clientRelation->name }}</td>
                <td style="width: 80px; text-align: right;">
                    {{ $worker->clientHoursByClient->where('client_id', $client->client_id)->first()?->hours_sum_by_client }}
                </td>
            </tr>
            @php
                $processed[] = $client->clientRelation->id;
            @endphp
        @endif
    @endforeach
    </tbody>
</table>
</table>
