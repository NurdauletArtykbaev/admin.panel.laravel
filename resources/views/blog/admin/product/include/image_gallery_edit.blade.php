<div class="box box-primary box-solid file-upload">
    <div class="box-header">
        <h3 class="box-title">Картинки галереи</h3>
    </div>
    <div class="box-body" id="galleryjs">
        <div id="multi" class="btn btn-success" data-url="{{url('/admin/products/gallery')}}" data-name="multi">
            Загрузить
        </div>
        <div class="multi">
            @if(!empty($images))
                <p><small>Для удаления нажмите на картинку.</small></p>
                @foreach($images as $image)
                    <img src="{{asset("/uploads/gallery/$image")}}"
                         style="max-height: 150px; cursor: pointer;" alt="" data-id="{{ $product->id }}"
                         data-src="{{ $image }}" class="del-items">
                @endforeach
            @endif
                <p>
                     <small>Рекомендуемые размеры: 700ш.x1000в.</small>
                </p>
        </div>
    </div>

    {{-- my.css .overlay{}--}}
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>
