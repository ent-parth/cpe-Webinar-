@extends( 'layouts_front.master' )
@section( 'content' )
<div id="content-area">
            <section class="inner-banner-row" style="background-image:url(images/banner-bg.png);">
                <div class="container-fluid">
                    <div class="inner-banner-caption">
                        <h1>Join For Free</h1>
                        <p>Please enter your information to create a free account. With your account you will be able to register for our live webinars, </p>
                    </div>
                </div>    
            </section>
             
            <div class="container-fluid">
                <div class="login-area">
                    <div class="row">
                        <div class="col-lg-6">
                            <form action="" class="row">
                                <div class="col-md-12 text-center">
                                    <h4>Create an account</h4><div class="form-group"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control" placeholder="First Name"> </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name"> </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Email Id*</label>
                                        <input type="email" class="form-control" placeholder="Email Address"> </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Mobile Number</label>
                                        <input type="text" class="form-control" placeholder="Mobile Number"> </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Create PassWord*</label>
                                        <input type="password" class="form-control" placeholder="Create PassWord"> </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Confirm Password*</label>
                                        <input type="password" class="form-control" placeholder="Confirm PassWord"> </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Firm Name</label>
                                        <input type="text" class="form-control" placeholder="Company Name"> </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Topic of interest*</label>
                                        <select name="" class="selecttwo form-control">
                                             <option value="" selected>Who are you </option>
                                            <option value="">Student</option>
                                            <option value="">business man</option>
                                            <option value="">school teacher</option>
                                        </select>
                                         </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Who are you*</label>
                                        <select name="" id="" class="form-control" >
                                            <option value="" selected>Who are you </option>
                                            <option value="">Student</option>
                                            <option value="">business man</option>
                                            <option value="">school teacher</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group"></div>
                                    <div class="btn-group-md text-center">
                                        <input type="button" class="btn btn-primary  " value="Create Account">
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="col-lg-4 offset-lg-1 login-form">
                            <form action="">
                                <div class="col-md-12 text-center"><h4>Create an account</h4><div class="form-group"></div></div>
                               <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Email Id*</label>
                                        <input type="email" class="form-control" placeholder="Email Address"> </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""> PassWord*</label>
                                        <input type="password" class="form-control" placeholder="PassWord"> </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="form-group"> </div>
                                    <div class="btn-group-md text-center">
                                        <input type="button" class="btn btn-primary" value="Login">
                                    </div>
                                </div>
                               
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
                    
            
        </div>
@stop