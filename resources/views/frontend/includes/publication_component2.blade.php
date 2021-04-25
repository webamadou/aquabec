<div class="mozaique-item visible col-sm-6 col-md-4" data-region="{{@$item->region->slug}}" data-city="{{@$item->city->slug}}" data-category="{{@$item->category->slug}}" data-organisation="{{@$item->organisation->slug}}" data-price="{{@$item->price}}">
    <div class="card shadow-sm p-0">
        @if(class_basename(@$item) === 'Event')
            <a id="item_img" href="{{route('page_evenement',@$item->slug)}}">
                <img src="{{ route('show_image',@$item->images) }}" alt="{{@$item->title}}" class="img-fluid">
            </a>
        @else
            <a id="item_img" href="{{route('page_annonce',@$item->slug)}}">
                <img src="{{ route('show_image',@$item->images) }}" alt="{{@$item->title}}" class="img-fluid">
            </a>
        @endif
    <div class="card-body p-0">
        <p class="card-text" id="item_title">
            @if(class_basename(@$item) === 'Event')
                <a href="{{route('page_evenement',@$item->slug)}}">{{@$item->title}}</a>
            @else
                <a href="{{route('page_annonce',@$item->slug)}}">{{@$item->title}}</a>
            @endif
        </p>
        <div class="d-block" style="background: #dcdcdc; padding: 0;">
            @if(class_basename(@$item) === 'Event')
                <div type="button" class="px-1" id="item_price">{{date('d/m/Y', strtotime(@$item->event_dates[0]->event_date) )}}</div>
                <div type="button" class="px-1" id="item_category">Category : {{@$item->category->name}}</div>
            @else
                <div type="button" class="px-1" id="item_price">{{@$item->getPrice()}}</div>
                <div type="button" class="px-1" id="item_category">Category : {{@$item->category->name}}</div>
            @endif
                <div type="button" class="px-1" id="item_author">Par : {{@$item->owned->username}}</div>
        </div>
    </div>
    </div>
</div>