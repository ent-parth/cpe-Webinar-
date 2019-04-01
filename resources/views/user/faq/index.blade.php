@extends( 'layouts_front.master' )
@section( 'content' )
<div id="content-area">
  <section class="inner-banner-row" style="background-image:url({{env('APP_URL')}}/images/sign-up.jpg);">
    <div class="container-fluid">
      <div class="inner-banner-caption">
        <h1>FAQ's</h1>
      </div>
    </div>
  </section>
  <div class="block-row faq-block">
    <div class="container-fluid">
      <div class="faq-row">
        <h2>LOREM IPSUM TITLE HERE</h2>
        <div class="accordion-block">
          <div class="title cf"> <span>How <strong>CPE</strong> are credited to Your Account?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>Depending on the type of webinar you selected, and the valid answers to the questionnaire solved after attending / viewing the webinar, You will be eligible for CPE credits (, which will be automatically credited to your account.)</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>What If I missed a Live Webinar after registration?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>If you are having a paid account, the amount for the webinar you missed, will be credited to your account soon after. This can be utilized for attending another webinar on a later date.</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>Will I get a certificate after completion of a webinar?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>Yes. A digital copy of the certificate will be automatically emailed to you.</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>Can I use mobile app for free?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>Yes! Definitely! We urge you to download & install it, facilitating you with Education On-The-Go!</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>Can I retake examination multiple times?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>Yes. Until you clear the test linked with a particular webinar, you can take multiple attempts to clear it.</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>Can I change my topic of interest?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>Yes, you can change your topic of interest from Options under the My Profile section</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>Do You provide contact details of the speaker?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>Yes, we provide the Email ID, Mobile number, and Social Media profile links of each speaker on My-CPE.com</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>How is refund processed?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>The eligible amount will be credited to your account directly.</p>
          </div>
        </div>
        <div class="accordion-block">
          <div class="title cf"> <span>Is My-CPE.com approved by Government?</span> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
          <div class="content-block cf" style="display: none;">
            <p>Yes. My-CPE.com is approved by the National Association of State Boards of Accountancy (NASBA), a forum for accounting regulators and practitioners.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
        $(document).ready(function() {
           $(".accordion-block .title").click(function(){
             if($(this).hasClass("active")){
                  $(this).removeClass("active");
                  $(this).next(".content-block").slideUp();
                }else{
                  $('.title').removeClass("active");
                  $(this).addClass("active"); 
                  $('.accordion-block .content-block').slideUp();
                  $(this).next(".content-block").slideDown(); 
             }	
          });
        });
    </script> 
@stop