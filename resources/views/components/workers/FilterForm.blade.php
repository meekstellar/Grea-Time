<form class="card card-primary card-outline sticky-top" action="{{ route('workers') }}" id="FilterForm" method="GET">
    <div class="card-header">
      <h5 class="card-title"><i class="fa fa-filter" aria-hidden="true"></i> Фильтр</h5>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label><i class="far fa-calendar-alt"></i> Дата или период:</label>
                    <div class="input-group" style="align-items: flex-start;">
                        <button type="button" class="btn btn-default float-right" id="daterange-btn">
                            <i class="far fa-calendar-alt"></i> <span>{{ Date::parse($date_or_period[0])->format('j F Y') }}@if(!empty($date_or_period[1])) — {{ Date::parse($date_or_period[1])->format('j F Y') }}@endif</span>
                            <i class="fas fa-caret-down"></i>
                        </button>
                        <div id="reportrange">
                            <input type="hidden" name="date_or_period" value="{{ $date_or_period[0] }}@if(!empty($date_or_period[1]))--{{ $date_or_period[1] }}@endif" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label><i class="fas fa-user-tie" aria-hidden="true"></i> Сотрудники:</label>
                    <select name="w[]" class="select2" multiple="multiple" data-placeholder="Отображать всех сотрудников" style="width: 100%;">
                        @if(!empty($users['workers']))
                            @foreach($users['workers'] as $worker)
                                <option value="{{ $worker->id }}" @if(!empty(request()->w) && in_array($worker->id,request()->w)){{ 'selected' }}@endif>{{ $worker->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-sm btn-primary">Применить</button>
        </div>
    </div>
</form>
