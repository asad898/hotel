@extends('layouts.app')
@section('head')
    <title>التعليقات</title>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid justify-content-center">
        <h3 class="justify-content-center row m-0 pb-5">الغرفة {{ $room->number }}</h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-footer mb-5">
                    <form action="{{ route('comment.store') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-success">إرسال</button>
                            </span>
                            <input type="text" name="comment" placeholder="اكتب تعليقك ..." class="form-control">
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                        </div>
                    </form>
                </div>
                @if (count($comments))
                    @foreach ($comments as $comment)
                        <div class="direct-chat-msg @if (auth()->user()->id == $comment->user->id) right @else left @endif col-md-12">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name @if (auth()->user()->id ==
                                $comment->user->id) float-right @else float-left @endif
                                    ">{{ $comment->user->username }}</span>
                                <span class="direct-chat-timestamp @if (auth()->user()->id ==
                                $comment->user->id) float-left @else float-right @endif">{{ $comment->created_at }}</span>
                                <div class="d-flex px-2 @if (auth()->user()->id ==
                                $comment->user->id) float-right @else float-left @endif">
                                    @if (auth()->user()->id == $comment->user_id)
                                        <a href="{{ route('comment.edit', $comment->id) }}"><i
                                                class="fas fa-edit px-2"></i></a>
                                    @endif
                                    @if (auth()->user()->id == $comment->user_id or auth()->user()->mm)
                                        <button type="button" class="btn btn-tool" data-toggle="modal"
                                            data-target="#delete{{ $comment->id }}">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                        @include('comments.delete')
                                    @endif
                                </div>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="{{ asset('img/user.png') }}" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text text-justify">
                                {{ $comment->comment }}
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                    @endforeach
                    <div class="row mt-4 justify-content-center">
                        {{ $comments->links() }}
                    </div>
                @else
                    <p>لا توجد تعليقات حتى الآن</p>
                @endif


                {{-- <div class="direct-chat-msg left mt-5 col-md-12">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">أحمد قاضي</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:05 pm</span>
                        <div class="d-flex px-2">
                            <a href="#"><i class="fas fa-edit px-2"></i></a>
                            <a href="#"><i class="fas fa-trash text-danger"></i></a>
                        </div>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="{{ asset('img/user.png') }}" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text text-justify">
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                    </div>
                    <!-- /.direct-chat-text -->
                </div>

                <div class="direct-chat-msg left mt-5 col-md-12">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">أحمد قاضي</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:05 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="{{ asset('img/user.png') }}" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text text-justify">
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                    </div>
                    <!-- /.direct-chat-text -->
                </div>

                <div class="direct-chat-msg left mt-5 col-md-12">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">أحمد قاضي</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:05 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="{{ asset('img/user.png') }}" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text text-justify">
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                    </div>
                    <!-- /.direct-chat-text -->
                </div>

                <div class="direct-chat-msg left mt-5 col-md-12">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">أحمد قاضي</span>
                        <span class="direct-chat-timestamp float-right">23 Jan 2:05 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="{{ asset('img/user.png') }}" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text text-justify">
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                        خليك مع افضل شركة في مجال الاعمال الدعائية في السودان عشان معانا بتلقى احل التصاميم و بي اجود طباعة
                        و افضل الخامات.
                    </div>
                    <!-- /.direct-chat-text -->
                </div> --}}


            </div>


        </div>
    </div>
@endsection
