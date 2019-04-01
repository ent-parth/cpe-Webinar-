<div class="col-xs-12">
  <div class="box">
    <div class="box-body">
      <table class="table table-hover table-striped table-bordered">
        <tbody>
          <tr>
            <td>Title</td>
            <td>{{ $SelfStudyWebinarsView->title }}</td>
          </tr>
        </tbody>
      </table>
      @if($SelfStudyWebinarsView->status !=1)
      <form id="self_study_status" name="self_study_status" data-parsley-validate class="form-horizontal form-label-left" action="{{route('selfstudy-webinar.updateStatus')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="">
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label" for="form_control_1"> Self Study Status<span class="required">*</span></label>
              <select name="status" id="status" class="form-control" required>
                <option  value="" >Select Status</option>
                <option  value="active"  @if($SelfStudyWebinarsView->status == "active") selected= selected @endif>Active</option>
                <option  value="inactive"  @if($SelfStudyWebinarsView->status == "inactive") selected= selected @endif>Inactive</option>
                <option  value="delete"  @if($SelfStudyWebinarsView->status == "delete") selected= selected @endif>Delete</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-sm-12">
          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <input type="hidden" name="id" id="id" value="{{$SelfStudyWebinarsView->id}}">
                <button type="submit" class="btn green SubmitSupportForm">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      @endif </div>
  </div>
</div>
</div>
