@if ($paginator->hasPages())
<div class="datatable-footer"> {{-- Previous Page Link --}}
<div class="dataTables_paginate paging_simple_numbers" id="">
  @if ($paginator->onFirstPage()) 
  	<a class="paginate_button previous disabled" href="javascript:void(0)" data-dt-idx="0" tabindex="0">←</a> 
  @else 
  	<a class="paginate_button previous" href="{{ $paginator->previousPageUrl() }}" data-dt-idx="0" tabindex="0">←</a> 
  @endif
  
  {{-- Pagination Elements --}}
  @foreach ($elements as $element)
  {{-- "Three Dots" Separator --}}
  @if (is_string($element)) <span class="disabled"><span>{{ $element }}</span></span> @endif
  
  {{-- Array Of Links --}}
  @if (is_array($element))
  @foreach ($element as $page => $url)
  <span>
  @if ($page == $paginator->currentPage()) 
  	<a class="paginate_button current"   data-dt-idx="1" tabindex="0">{{ $page }}</a>
  @else 
  	<a class="paginate_button" href="{{ $url }}" data-dt-idx="1" tabindex="0">{{ $page }}</a>
  @endif
  </span>
  @endforeach
  @endif
  @endforeach
  
  {{-- Next Page Link --}}
  @if ($paginator->hasMorePages()) 
  	<a class="paginate_button next" href="{{ $paginator->nextPageUrl() }}" data-dt-idx="2" tabindex="0">→</a> 
  @else 
  	<a class="paginate_button disabled" href="javascript:void();" data-dt-idx="2" tabindex="0">→</a> 
  @endif 
  
  </div>
  </div>
@endif