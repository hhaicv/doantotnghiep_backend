@extends('admin.layouts.mater')
@section('title')
    Chi tiết Tin tức
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết Tin tức </h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gx-lg-5">
                <div class="col-xl-4 col-md-8 mx-auto">
                    <div class="product-img-slider sticky-side-div">
                        <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ Storage::url($data->thumbnail_image) }}" alt=""
                                        class="img-fluid d-block" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-8">
                    <div class="mt-xl-0 mt-5">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h4>{{ $data->title }}</h4>
                                <div class="hstack gap-3 flex-wrap">
                                    @foreach ($data->newCategories as $category)
                                        <div class="text-muted"><span
                                                class="text-body fw-medium">{{ $category->name }}</span>
                                        </div>
                                        <div class="vr"></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div>
                                    <a href="{{ route('admin.information.edit', $data->id) }}" class="btn btn-light"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i
                                            class="ri-pencil-fill align-bottom"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                            <div class="text-muted">( {{ $data->views_count }} lượt xem )</div>
                        </div>
                        <div class="mt-4 text-muted">
                            <h5 class="fs-14">Tóm tắt :</h5>
                            <?php echo $data->summary  ?>

                        </div>
                        <div class="mt-4 text-muted">
                            <h5 class="fs-14">Nội dung :</h5>
                            <?php echo $data->content  ?>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
