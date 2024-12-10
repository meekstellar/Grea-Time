<table class="table table-sm client-table">
    <tbody>
        @foreach($WorkerClientHours->where('worker_id',$wc->worker_id) as $wc_clients)
        <tr>
            <td style="width: 10px">{{ $loop->iteration }}.</td>
            <td>
                @if(!empty($wc_clients->client()->image) && File::exists('storage/'.$wc_clients->client()->image))
                    <img alt="{{ $wc_clients->client()->name }}" class="client-pre-avatar img-circle img-fluid" src="{{ asset('storage/'.$wc_clients->client()->image) }}"></td>
                @endif
            <td style="width: 100%;" class="user_active_{{ !empty($wc_clients->check_connect_client_id()) || $wc_clients->client()->position == 'Rest Day' ? 1 : 0 }}">{{ $wc_clients->client()->name }}</td>
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
