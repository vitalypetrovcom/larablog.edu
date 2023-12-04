@include('categories.category_sub_form')

<div class="sidebar">
        <div class="widget">
            <h2 class="widget-title">Popular Posts</h2>
            <div class="blog-list-widget">
                @foreach($popular_posts as $post)

                <div class="list-group">
                    <a href="{{ route('posts.single', ['slug' => $post->slug]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="w-100 justify-content-between">
                            <img src="{{ $post->getImage () }}" alt="" class="img-fluid float-left">
                            <h5 class="mb-1">{{ $post->title }}</h5>
                            <small>{{ $post->getPostDate () }}</small>
                            <small>| <i class="fa fa-eye"></i> {{ $post->views }}</small>
                        </div>
                        </a>
                </div>

                @endforeach

            </div><!-- end blog-list -->
        </div><!-- end widget -->

        {{--<div id="" class="widget">
            <h2 class="widget-title">Advertising</h2>
            <div class="banner-spot clearfix">
                <div class="banner-img">
                    <img src="/assets/front/upload/banner_03.jpg" alt="" class="img-fluid">
                </div><!-- end banner-img -->
            </div><!-- end banner -->
        </div><!-- end widget -->--}}

        {{--<div class="widget">
            <h2 class="widget-title">Instagram Feed</h2>
            <div class="instagram-wrapper clearfix">
                <a class="" href="#"><img src="/assets/front/upload/small_09.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_01.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_02.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_03.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_04.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_05.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_06.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_07.jpg" alt="" class="img-fluid"></a>
                <a href="#"><img src="/assets/front/upload/small_08.jpg" alt="" class="img-fluid"></a>
            </div><!-- end Instagram wrapper -->
        </div><!-- end widget -->--}}

        <div class="widget">
            <h2 class="widget-title">Categories</h2>
            <div class="link-widget">
                <ul>
                @foreach($cats as $cat)
                    <li><a href="{{ route ('categories.single', ['slug' => $cat->slug]) }}">{{ $cat->title }}<span>({{ $cat->posts_count }})</span></a></li>
                @endforeach
                </ul>
            </div><!-- end link-widget -->
        </div><!-- end widget -->
    </div><!-- end sidebar -->

