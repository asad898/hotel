<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="application/javascript"></script>

<div class="mx-3 unprint">
    @if(count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert text-light" style="background-color: #EC6258" role="alert">
                <strong>{{ __('حدث خطاء') }} &nbsp;</strong> {{$error}}
                <button style="margin-left: 20px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    @endif
    
    @if (session('success'))
        <div class="alert" style="background-color: #54B886" role="alert">&nbsp;&nbsp;&nbsp;
            <strong>{{ __('تم بنجاح') }} &nbsp;</strong> {{session('success')}}
            <button style="margin-left: 20px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if (session('danger'))
        <div class="alert" style="background-color: #EC6258" role="alert">
            <strong>{{ __('تم الحذف بنجاح') }} &nbsp;</strong> {{session('danger')}}
            <button style="margin-left: 20px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if (session('warning'))
        <div class="alert" style="background-color: #dfdf66" role="alert">
            <strong>{{ __('انتبه') }} &nbsp;</strong> {{session('warning')}}
            <button style="margin-left: 20px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert" style="background-color: #EC6258" role="alert">
            <strong>{{ __('هناك شئ خاطئ') }} &nbsp;</strong> {{session('error')}}
            <button style="margin-left: 20px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error1'))
        <div class="alert" style="background-color: #EC6258" role="alert">
            <strong>{{ __('هناك خطاء') }}&nbsp;</strong> {{session('error1')}}
            <button style="margin-left: 20px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
