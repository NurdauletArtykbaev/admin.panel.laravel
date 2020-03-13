@foreach($categories as $categories_list)

    <option value="{{ $categories_list->id ?? "" }}"
        @isset($item->id)
            @if($categories_list->id == $item->parent_id) selected @endif
            @if($item->id == $categories_list->id) disabled @endif
        @endisset
        >
        {!! $delimiter ?? "" !!} {{$categories_list->title ?? ""}}
    </option>

    @if(count($categories_list->children)  > 0)
        @include('blog.admin.product.include.edit_categories_all_list',
[
    'categories'=> $categories_list->children,
    'delimiter' => ' - ' . $delimiter,
    ])
    @endif

@endforeach
