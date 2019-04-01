@extends( 'layouts_front.master' )
@section( 'content' )
<div id="content-area">
  <section class="inner-banner-row" style="background-image:url({{env('APP_URl')}}/images/sign-up.jpg);">
    <div class="container-fluid">
      <div class="inner-banner-caption">
        <h1>Contact Us</h1>
        <p>Fill in your Name, Contact number, Email ID, and Subject of your concern with a small description in the form below. We shall get back to you promptly with the necessary information.</p>
      </div>
    </div>
  </section>
  <div class="container-fluid contact-form">
    <div class="login-area">
      <div class="row">
        <div class="col-lg-12">
          <form action="" class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for=""> Name</label>
                <input type="text" class="form-control" placeholder="Name">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Mobile Number</label>
                <input type="text" class="form-control" placeholder="Mobile Number">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Email Id*</label>
                <input type="email" class="form-control" placeholder="Email Address">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Subject</label>
                <input type="text" class="form-control" placeholder="Company Name">
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label for="">Message</label>
                <textarea type="text" class="form-control" placeholder="Leave Your Message"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"></div>
              <div class="btn-group-md text-center">
                <input type="button" class="btn btn-primary  " value="Submit">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
        $(document).ready(function() {
            $('.selecttwo').select2();
           
            
            
        });
        jQuery(function($) {
          $('.select2-multiple').select2MultiCheckboxes({
            templateSelection: function(selected, total) {
              return "Selected " + selected.length ;
            }
          })
          
        });
    </script> 
@stop