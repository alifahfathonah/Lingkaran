@extends('guest.layouts.app')

@section('title')
Lingkaran - {{ $post->title }}
@endsection

@section('content')
<!-- Breadcrum -->
<nav aria-label="breadcrumb">
    <div class="container p-0 mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('guest.home') }}"><i class="fa fa-home"></i>
                    Home</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('guest.category.show', $post->category->slug) }}">{{ $post->category->title }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
        </ol>
    </div>
</nav>

<section class="post-detail mt-3">
    <div class="container">
        <div class="row">
            <!-- Post Detail -->
            <div class="col-md-8">
                <div class="detail-category">
                    <a href="{{ route('guest.category.show', $post->category->slug) }}"
                        style="background-color: {{ $post->category->color }};">{{ $post->category->title }}</a>
                </div>
                <div class="detail-title mt-3">
                    <h3>{{ $post->title }}</h3>
                </div>
                <div class="detail-info">
                    <span><i class="fas fa-user"></i> {{ $post->user_author->firstname }}</span>
                    <span><i class="far fa-clock"></i> {{ $post->created_at->format('d M Y') }}</span>
                    <span><i class="far fa-eye"></i>
                        {{ ($post->view>= 1000) ? floor($post->view / 1000) . 'k' : $post->view }} views</span>
                </div>
                <figure class="figure mt-3">
                    <img src="{{ asset('images/post/'.$post->image) }}" class="figure-img" alt="{{ $post->title }}">
                    <figcaption class="figure-caption">Source: Lingkaran.com</figcaption>
                </figure>
                <div class="detail-content">
                    <span class="first-content-text">Lingkaran.com - </span>
                    {!! $post->content !!}
                    @if($post->editor != 0)
                    <div class="mt-3">
                        <span class="text-muted small">Editor: {{ $post->user_editor->firstname }}</span>
                    </div>
                    @endif
                </div>
                <div class="detail-tag mt-3">
                    <span class="tag-header">Tags</span>
                    @foreach($post->tags as $tag)
                    <a href="{{ route('guest.tag.show', $tag->slug) }}">{{ $tag->title }}</a>
                    @endforeach
                </div>

                <div class="sebaran-berita mt-3">
                    <div class="sebaran-berita-header">Sebaran Berita</div>
                    <div class="mt-3 h-4" id="network-graph"></div>
                </div>

                <div class="berita-lain mt-3">
                    <div class="berita-lain-header">Berita Lainnya</div>
                    <div class="row">
                        @foreach($relatedPosts as $related)
                        <div class="col-md-3">
                            <div class="berita-lain-content mt-3">
                                <a href="{{ route('guest.post.show', [$related->category->slug, $related]) }}"><img
                                        src="{{ asset('images/post/'.$related->image) }}" alt="{{ $related->title }}"
                                        class="berita-lain-img"></a>
                                <a href="{{ route('guest.post.show', [$related->category->slug, $related]) }}"
                                    class="berita-lain-title">{{ $related->title }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            @include('guest.layouts.partials.sidebar')
        </div>
    </div>
</section>

<!-- Admin Button -->
@if(auth()->user())
<div class="admin-btn action shadow-lg p-2">
    <h6 class="text-center border-bottom pb-1">Action</h6>
    <button onclick="location.href='{{ url()->previous() }}'" class="btn btn-sm btn-block btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </button>
    <button onclick="location.href='{{ route('post.edit', $post) }}'" class="btn btn-sm btn-block btn-info">
        <i class="fas fa-edit"></i> Edit
    </button>

    @if($post->status != 1)
    @can('publish post')
    <button class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#modal-confirm"
        data-key="publish">
        <i class="fa fa-bullhorn"></i> Publish
    </button>
    @endcan
    @else
    @can('revoke post')
    <button class="btn btn-sm btn-block btn-warning" data-toggle="modal" data-target="#modal-confirm" data-key="revoke">
        <i class="fa fa-undo"></i> Revoke
    </button>
    @endcan
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <form id="url" action="#" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p class="text-center" id="title">title</p>
                    <input type="hidden" id="form-confirm" name="id">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="action">action</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /modals -->
@endif
@endsection

@section('b-script')
<script>
    $('#modal-confirm').on('show.bs.modal', function (e) {
        const key = $(e.relatedTarget).data('key');
        if (key !== 'revoke') {
            $('.modal-body #title').text('Apakah anda ingin publish post ini?');
            $('.modal-body #form-confirm').val('{{encrypt($post->id)}}');
            $('.modal-footer #action').text('Publish');
            $('.modal-footer #action').attr('class', 'btn btn-success btn-sm');
            $('#url').attr('action', '{{ route("post.publish", "id") }}');
        } else {
            $('.modal-body #title').text('Apakah anda ingin tarik kembali post ini?');
            $('.modal-body #form-confirm').val('{{encrypt($post->id)}}');
            $('.modal-footer #action').text('Revoke');
            $('.modal-footer #action').attr('class', 'btn btn-warning btn-sm');
            $('#url').attr('action', '{{ route("post.revoke", "id") }}');
        }
    });

    const waktu = setTimeout(function(){
        const id = '{{ encrypt($post->id) }}';
        const url = "{{ route('guest.add.visitor') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                id:id,
            }
            ,success:function(data){
                console.log(data);
            }
        });
    }, 10000);
</script>

<script>
    anychart.onDocumentReady(function () {
            anychart.data.loadJsonFile(
                // The data used in this sample can be obtained from the CDN
                'https://cdn.anychart.com/samples-data/graph/knowledge_graph/data.json',
                function (data) {
                    // create graph chart
                    var chart = anychart.graph(data);

                    // set settings for each group
                    for (var i = 0; i < 8; i++) {
                        // get group
                        var group = chart.group(i);

                        // set group labels settings
                        group
                            .labels()
                            .enabled(true)
                            .anchor('left-center')
                            .position('right-center')
                            .padding(0, -5)
                            .fontColor(anychart.palettes.defaultPalette[i]);

                        // set group nodes stroke and fill
                        group.stroke(anychart.palettes.defaultPalette[i]);
                        group.fill(anychart.palettes.defaultPalette[i]);
                    }

                    // set container id for the chart
                    chart.container('network-graph');
                    // initiate chart drawing
                    chart.draw();
                }
            );
        });
</script>
@endsection