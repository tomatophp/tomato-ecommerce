@if($page->sections->count())
    @foreach($page->sections()->orderBy('order')->withPivot('id')->get() as $section)
        @include($section->view, ['page' => $page, 'section' => $section, 'sectionID' => $section->pivot->id])
    @endforeach
@else
    <div>
        {!! $page->body !!}
    </div>
@endif
