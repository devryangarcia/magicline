@extends('admin-dash-layout')
@section('title')
Trash Reports
@endsection
@section('page-active')
Trash Reports
@endsection
@section('main-content')
<div class="row">
    <div class="col-md-3">
        <?php
            $reportedbugs = DB::select('select * from bug_reports where archived is null');
            $trashes = DB::select('select * from bug_reports where archived = 1');
        ?>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Folders</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item active">
              <a href="{{route('reportedbugs')}}" class="nav-link">
                <i class="fas fa-inbox"></i> Inbox
                <span class="badge bg-primary float-right">{{count($reportedbugs)}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('trashreports')}}" class="nav-link">
                <i class="far fa-trash-alt"></i> Trash
                <span class="badge bg-danger float-right">{{count($trashes)}}</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Trash</h3>

          @if(Session::get('success'))
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-check"></i> {{ Session::get('success') }}
          </div>
          @endif
          @if(Session::get('fail'))
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fas fa-ban"></i>  {{ Session::get('fail') }}
              </div>
          @endif
          <div class="card-tools">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control" placeholder="Search Mail">
              <div class="input-group-append">
                <div class="btn btn-primary">
                  <i class="fas fa-search"></i>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <form action="{{route('reportdelete')}}" method="post" id="reportform">
          @csrf
        <div class="card-body p-0">
          <div class="mailbox-controls">
            <!-- Check all button -->
            <div class="btn-group">
              <div class="btn btn-default btn-sm">
                <input type="checkbox" id="select-all">
              </div>
            </div>
            </button>
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal2">
                <i class="far fa-trash-alt"></i>
              </button>
            </div>
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal1">
                Restore
              </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-m" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="myModalLabel"><i class="fas fa-exclamation-triangle"></i> Warning!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h5> Are you sure to delete this permanently?</h5>
                    <button type="submit" class="btn btn-outline-dark"><i class="fas fa-trash"></i> Permanently Delete</button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.btn-group -->
            <a href="{{route('trashreports')}}" class="btn btn-default btn-sm">
              <i class="fas fa-sync-alt"></i>
            </a>
            <div class="float-right">
              
              <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm">
                  <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm">
                  <i class="fas fa-chevron-right"></i>
                </button>
              </div>
              <!-- /.btn-group -->
            </div>
            <!-- /.float-right -->
          </div>
          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
              <tbody>
              @foreach ($trashes as $report)
              <?php
              $users = DB::select('select * from users where id = ?',[$report->user_id]);
              ?>
              @foreach ($users as $user)
              <tr>
                <td>
                  <div class="icheck-primary">
                    <input type="checkbox" value="{{$report->id}}" name="checkbox[]">
                    <label for="check1"></label>
                  </div>
                </td>
                <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                <td class="mailbox-name col-md-2"><a href="{{route('readbugreport',['id'=>$report->id])}}"><?php echo $user->fname.' '.$user->lname; ?></a></td>
                <td class="mailbox-subject col-md-5 overflow-hidden"><a href="{{route('readbugreport',['id'=>$report->id])}}" class="text-dark"><strong>{{$report->title}}</strong></a></td>
                @if($report->attachment)
                <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                @else
                <td class="mailbox-attachment"></td>
                @endif
                <td class="mailbox-date">{{$report->status}}</td>
                <td class="mailbox-date">Created at: {{$report->created_at}}</td>
                <td class="mailbox-date">Updated at: {{$report->created_at}}</td>
              </tr>  
              @endforeach  
              @endforeach
              
              </tbody>
            </table>
            <!-- /.table -->
          </div>
          <!-- /.mail-box-messages -->
        </div>
      </form>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
@section('scripts')
<script type="text/javascript">  
  // Add this code in a script tag or external JavaScript file

  // Get the "Select All" checkbox element
  const selectAllCheckbox = document.getElementById('select-all');

  // Get all the checkboxes within the form
  const checkboxes = document.querySelectorAll('#reportform input[type="checkbox"]');

  // Add event listener to the "Select All" checkbox
  selectAllCheckbox.addEventListener('change', function () {
      // Loop through all the checkboxes
      checkboxes.forEach(function (checkbox) {
          // Check/uncheck each checkbox based on the state of the "Select All" checkbox
          checkbox.checked = selectAllCheckbox.checked;
      });
  });           
</script>  
@endsection