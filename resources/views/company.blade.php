@extends('dash-layout')
@section('title')
  <?php echo strtoupper($company) ?> PRODUCTS
@endsection
@section('page-active')
<?php echo strtoupper($company) ?> Products
@endsection
@section('links')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('main-content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        @if(Session::get('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fas fa-check"></i> {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::get('deleted'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fas fa-ban"></i>  {{ Session::get('deleted') }}
        </div>
        @endif
        <h3 class="card-title">{{strtoupper($company)}} PRODUCTS</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-sm-3">
            <form method="get" class="form-group" action="{{url('company/'.$company)}}">
              <div class="input-group">
                <select class="form-control" name="categ_filter">
                  <option value="" disabled selected hidden>Category</option>
                  <option value="Bust & Torso" <?php if($selected=="Bust & Torso"){echo 'selected';} ?> >Bust & Torso</option>
                  <option value="Mannequin" <?php if($selected=="Mannequin"){echo 'selected';} ?> >Mannequin</option>
                  <option value="Props" <?php if($selected=="Props"){echo 'selected';} ?> >Props</option>
                  <option value="Accessories" <?php if($selected=="Accessories"){echo 'selected';} ?> >Accessories</option>
                      
                </select>
                <button type="submit" class="btn btn-outline-dark ml-1">Filter</button>
                <a href="{{url('company/'.$company)}}" class="btn btn-outline-dark ml-2">Show All</a>
              </div>
            </form>
            
          </div>
        </div>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Image</th>
            <th>Purchase Order</th>
            <th>Reference Name</th>
            <th>Category</th>
            <th>Type</th>
            <th>Added By</th>
            <th>Updated By</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
      <?php 
        $currentuser = session()->get('LoggedUser');
        $checkrole = DB::table('users')->where('id','=',$currentuser)->get();
        foreach ($checkrole as $check) {
          $userrole = $check->role;
        }
        foreach ($products as $product) { 
          $priceaccesslists = DB::table('prices')->where('itemref','=',$product->itemref)->get();
          $image_array = [];
          foreach (explode(",",$product->images) as $value) {
              $image_array[] = $value;
          }
          sort($image_array);
          $first_image = $image_array[0];
        ?>
        <tr>
          <td><img src="{{asset('storage/product_images/'.$first_image)}}" alt="<?php echo $first_image;?>" style="height: 100px"></td>
          <td><?php echo $product->po; ?></td>
          <td><?php echo $product->itemref; ?></td>
          <td><?php echo $product->category; ?></td>
          <td><?php echo $product->type; ?></td>
          <td><?php echo $product->addedby; ?></td>
          <td><?php echo $product->updatedby; ?></td>
          <td>
            <a href="{{route('product_detail2',$product->id)}}" class="btn btn-light">
              <i class="fas fa-eye"></i> View
            </a>
            @if ($userrole=='admin1' || $userrole=='admin2')
            <a href="{{route('editproduct',$product->id)}}" class="btn btn-light"><i class="fa fa-edit"></i> Edit</a>
            @endif
            @if ($userrole=='admin1')
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#myModal2<?php echo $product->id; ?>">
              <i class="fas fa-trash"></i> Delete
            </button>  
            @endif
          </td>
        </tr>
  
        <!-- Modal -->
        <div class="modal fade" id="myModal2<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h4 class="modal-title" id="myModalLabel"><i class="fas fa-exclamation-triangle"></i> Warning!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h5> Are you sure to delete this product?</h5>
                <form action="{{route('trashproducts')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{$product->id}}">
                  <input type="hidden" name="company" value="{{$product->company}}">
                  <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>  Delete</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
          
          
          </tbody>
          <tfoot>
          <tr>
            <th>Image</th>
            <th>Purchase Order</th>
            <th>Reference Name</th>
            <th>Category</th>
            <th>Type</th>
            <th>Added By</th>
            <th>Updated By</th>
            <th>Action</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>

@endsection
@section('scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('/plugins/datatables/jquery.dataTables.min2.js')}}"></script>
<script src="{{asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      
    $('#my-filter').on('change',function(){
      var filterValue = $(this).val();
      $("#example1").column(0).search(filterValue).draw();
    });
    });
</script>
<script>
function changeSearchTerm(term) {
  var table = $('#example1_filter').DataTable();
  table.search(term).draw();
}

changeSearchTerm('New Search Term');


</script>

@endsection
