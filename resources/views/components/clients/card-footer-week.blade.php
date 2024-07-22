<div class="text-right">
    <span class="data-total"><i class="far fa-clock"></i> <span id="wc_{{ $wc->client()->id }}">{{ $WorkerClient->where('client_id',$wc->client_id)->sum('hours') }}</span></span>
</div>
