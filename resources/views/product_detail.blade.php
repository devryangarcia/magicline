@extends('dash-layout')
@section('title')
  <?php echo $products->company.' PRODUCT'; ?>
@endsection
@section('links')
    <link rel="stylesheet" href="{{asset('exzoom/jquery.exzoom.css')}}">
@endsection
@section('page-back')
<li class="breadcrumb-item"><a href="{{url('admin/partnerproduct/'.$products->company)}}">{{$products->company}}</a></li>
@endsection
@section('page-active')
  {{$products->itemref}}
@endsection
@section('main-content')
<div class="row">
    
  <?php
  $showprice = false;
  $CurrentUser = session()->get('LoggedUser');
  $checkrole = DB::select('select * from users where id = ?', [session()->get('LoggedUser')]);
  
  foreach ($checkrole as $role) {
    $userrole = $role->role;
  }
    $productimages = $products->images;
    $imageNames = [];
    foreach (explode(",",$productimages) as $value) {
      $imageNames[] = $value;
    }
    // Sort the array of image names
    sort($imageNames);
    $priceaccesslists = DB::select('select * from prices where itemref = ?', [$products->itemref]);
    // Loop through the sorted array and output the image names
    ?>
    <div class="col-md-6">
      <div class="row d-flex justify-content-center">
        <div class="exzoom w-75" id="exzoom">
          <div class="exzoom_img_box">
            <ul class='exzoom_img_ul'>
              @foreach ($imageNames as $i => $image)
              <li><img src="{{asset('storage/product_images/'.$image)}}" alt="" class=""></li>
              @endforeach
            </ul>
        </div>
        <div class="exzoom_nav mt-5"></div>
        <p class="exzoom_btn">
            <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
            <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
        </p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <p><strong>PO:</strong> <?php echo $products->po; ?></p>
      <p><strong>Item Reference:</strong> <?php echo $products->itemref; ?></p>
      <p><strong>Company:</strong> <?php echo $products->company; ?></p>
      @foreach ($priceaccesslists as $priceaccesslist)
        @foreach (explode(',',$priceaccesslist->user_id) as $priceaccess)
          @if ($priceaccess==$CurrentUser)
            <p><strong>Price:</strong> <?php echo $products->price; ?></p>
          @endif 
        @endforeach
      @endforeach
      @if ($userrole=='admin1' || $userrole=='owner')
      <p><strong>Price:</strong> <?php echo $products->price; ?></p>
      @endif
      <p><strong>Description:</strong> <?php echo $products->description; ?></p>
      <!-- Add additional product information here -->
      @if (!empty($products->file))
      <a href="{{asset('storage/product_files/'.$products->file)}}" class="btn btn-outline-dark" download="{{$products->file}}"><i class="fa fa-download"></i> Download Costing</a> 
      @endif
      @if (!empty($products->pdf))
      <a href="{{asset('storage/product_pdfs/'.$products->pdf)}}" class="btn btn-outline-dark"><i class="fa fa-download"></i> View PDF</a> 
      <a href="{{asset('storage/product_pdfs/'.$products->pdf)}}" class="btn btn-outline-dark" download="{{$products->pdf}}"><i class="fa fa-download"></i> Download PDF</a> 
      @endif
      <!--<form action="{{route('genproductpdf')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$products->id}}">
        <button type="submit" class="btn btn-light">View PDF</button>
      </form>-->
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{asset('exzoom/jquery.exzoom.js')}}"></script>
  <script>
  $(function(){
    $("#exzoom").exzoom({
      // thumbnail nav options
      "navWidth": 60,
      "navHeight": 60,
      "navItemNum": 5,
      "navItemMargin": 7,
      "navBorder": 1,
    
      // autoplay
      "autoPlay":true,
    
      // autoplay interval in milliseconds
      "autoPlayTimeout": 2000
    });
  });


  </script>
@endsection