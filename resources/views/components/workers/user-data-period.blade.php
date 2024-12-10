<table class="table table-sm client-table">
    <tbody>
        @php
            $processed = [];
        @endphp
        @foreach($WorkerClientHours->where('worker_id',$wc->worker_id) as $wc_clients)
        @if(!in_array($wc_clients->client_id,$processed))
        <tr>
            <td style="width: 10px">{{ $loop->iteration }}.</td>
            <td class="user_active_{{ !empty($wc_clients->check_connect_client_id()) || $wc_clients->client()->position == 'Rest Day' ? 1 : 0 }}">{{ $wc_clients->client()->name }}</td>
            <td style="width: 80px; text-align: right;">{{ $WorkerClientHours->where('worker_id',$wc->worker_id)->where('client_id',$wc_clients->client_id)->sum('hours') }}</td>
        </tr>
        @php
            $processed[] = $wc_clients->client_id;
        @endphp
        @endif
        @endforeach
    </tbody>
  </table>
</table>
