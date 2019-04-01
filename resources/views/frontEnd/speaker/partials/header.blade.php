<!-- BEGIN HEADER -->
<div class="d-flex justify-content-between align-items-center">
    <a href="index.html" class="logo"><img src="{{config('constants.FRONT_END_SPEAKER.IMAGE_PATH')}}logo.png" alt=""></a>
    <div class="right-nav-area">
        <ul class="user-cred-area">
            <!-- <li><a href="javascrpt:void(0);">SIGN IN</a></li> -->
            <li><a href="{!! route('frontend.company.signup') !!}">COMPANY SIGN UP</a></li>
            <li><a href="{!! route('frontend.speaker.signup') !!}">SPEAKER SIGN UP</a></li>
            <!-- <li class="search-btn">
                <a href="javascrpt:void(0);"><img src="{{config('constants.FRONT_END_SPEAKER.IMAGE_PATH')}}icon-search.png" alt=""></a>
            </li> -->
        </ul>
    </div>
</div>
<!-- END HEADER -->