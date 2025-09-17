<table class="table table-sm client-table">
    <tbody>
    @foreach($worker->clientHours as $client)
        <tr>
            <td style="width: 10px">{{ $loop->iteration }}.</td>
            <td>
                @if(!empty($client->clientRelation->image) && File::exists('storage/'.$client->clientRelation->image))
                    <img alt="{{ $client->clientRelation->name }}" class="client-pre-avatar img-circle img-fluid"
                         src="{{ asset('storage/'.$client->clientRelation->image) }}"></td>
            @endif
            <td style="width: 100%;"
                class="user_active_1">{{ $client->clientRelation->name }}</td>
            <td style="width: 82px; text-align: right;">
                <select class="form-control-off" name="work_hours_of_day" id="work_hours_of_day_{{ $client->id }}"
                        data-wc_id="{{ $client->id }}">
                    @for($h=0; $h<=16; $h=$h+0.5)
                        <option value="{{ $h }}"@if($h == $client->hours)
                            {{ 'selected' }}
                            @endif>{{ $h }}</option>
                    @endfor
                </select>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
