<table class="table table-sm client-table">
    <tbody>
        @foreach($WorkerClient->where('worker_id',$wc->worker_id) as $wc_clients)
        <tr>
            <td style="width: 10px">{{ $loop->iteration }}.</td>
            <td>{{ $wc_clients->client()->name }}</td>
            <td style="width: 80px; text-align: right;">{{ $wc_clients->hours }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
</table>
