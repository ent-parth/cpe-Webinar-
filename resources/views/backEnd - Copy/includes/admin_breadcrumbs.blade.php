<!-- BEGIN PAGE BAR -->
<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
    <div class="d-flex">
        <div class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)            
            @if ($breadcrumb->first)
            <a href="{{ $breadcrumb->url }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> {{ __($breadcrumb->title) }}</a>
            @elseif(!$breadcrumb->first && !$breadcrumb->last)
            <a href="{{ $breadcrumb->url }}" class="breadcrumb-item"> {{ __($breadcrumb->title) }}</a>
            @else
            <a href="javascript:void(0)" class="breadcrumb-item active">{{ __($breadcrumb->title) }}</a>
            @endif
            @endforeach
        </div>
    </div>                   
</div>
<!-- END PAGE BAR -->
