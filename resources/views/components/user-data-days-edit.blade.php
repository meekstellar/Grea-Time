<table class="table table-sm client-table">
    <tbody>
        @foreach($WorkerClient->where('worker_id',$wc->worker_id) as $wc_clients)
        <tr>
            <td style="width: 10px">{{ $loop->iteration }}.</td>
            <td>{{ $wc_clients->client()->name }}</td>
            <td style="width: 82px; text-align: right;">
                <select class="form-control-off" name="work_hours_of_day" id="work_hours_of_day_{{ $wc_clients->id }}" data-wc_id="{{ $wc_clients->id }}">
                    @for($h=0; $h<=16; $h=$h+0.5)
                    <option value="{{ $h }}"@if($h == $wc_clients->hours){{ 'selected' }}@endif>{{ $h }}</option>
                    @endfor
                </select>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
