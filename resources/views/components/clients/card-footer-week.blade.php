<div class="text-right">
    <span class="data-total"><i class="far fa-clock"></i> <span id="wc_{{ $wc->client()->id }}">{{ $WorkerClientHours->where('client_id',$wc->client_id)->sum('hours') }}</span>&nbsp;ч.</span>
</div>
