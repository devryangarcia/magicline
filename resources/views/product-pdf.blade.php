<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body{
        background: url('{{asset('images/border.jpg')}}');
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
    html{
        height: 100%;
    }
    .template{
        margin-top: 1.5%;
        margin-left: 1.8%;
    }
    .row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -7.5px;
    margin-left: -7.5px;
    }
    .row-cols-1 > * {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    }

    .row-cols-2 > * {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
    }

    .row-cols-3 > * {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
    }

    .row-cols-4 > * {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;
    }

    .row-cols-5 > * {
    -ms-flex: 0 0 20%;
    flex: 0 0 20%;
    max-width: 20%;
    }

    .row-cols-6 > * {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667%;
    }
    .col {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 100%;
    }
    .col-1 {
    -ms-flex: 0 0 8.333333%;
    flex: 0 0 8.333333%;
    max-width: 8.333333%;
    }

    .col-2 {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667%;
    }

    .col-3 {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;
    }

    .col-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
    }

    .col-5 {
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%;
    }

    .col-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
    }

    .col-7 {
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%;
    }

    .col-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
    }

    .col-9 {
    -ms-flex: 0 0 75%;
    flex: 0 0 75%;
    max-width: 75%;
    }

    .col-10 {
    -ms-flex: 0 0 83.333333%;
    flex: 0 0 83.333333%;
    max-width: 83.333333%;
    }

    .col-11 {
    -ms-flex: 0 0 91.666667%;
    flex: 0 0 91.666667%;
    max-width: 91.666667%;
    }

    .col-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
    }
    .text-left {
    text-align: left !important;
    }

    .text-right {
    text-align: right !important;
    }

    .text-center {
    text-align: center !important;
    }
    .d-flex {
    display: -ms-flexbox !important;
    display: flex !important;
    }
    .justify-content-center {
    -ms-flex-pack: center !important;
    justify-content: center !important;
    }
    .col1{
    -ms-flex: 0 0 91.666667%;
    flex: 0 0 51.988667%;
    max-width: 51.988667%;
    }
    .col2{
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 29.333333%;
    max-width: 29.333333%;
    }
    .col3 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 16.633333%;
    max-width:16.633333%;
    }
</style>
<body>
    <div class="template">
        <div class="row">
            <div class="col1">
                <div class="row" style="margin-left: 3%; margin-top: 0.5%;">
                    <?php
                        $images_arr = [];
                        foreach (explode(',',$product->images) as $img) {
                            $images_arr[] = $img;
                        }
                        $comps = DB::select('select * from partners where company = ?', [$product->company]);
                        foreach ($comps as $comp) {
                            $logo = $comp->logo;
                        }
                    ?>
                    <div class="col-6">
                        <img src="{{asset('storage/product_images/'.$images_arr[0])}}" alt="" style="width: 75%; height: 90%">
                    </div>
                    <div class="col-6">
                        <div class="row">
                        <img src="{{asset('storage/product_images/'.$images_arr[1])}}" alt="" style="width: 34%; margin-right: 2%;">
                        <img src="{{asset('storage/product_images/'.$images_arr[2])}}" alt="" style="width: 34%; margin-right: 2%;">
                        <img src="{{asset('storage/product_images/'.$images_arr[3])}}" alt="" style="width: 34%; margin-top: 1%;">
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <h1><u>{{$product->po}}</u></h1>
                    </div>
                </div>
            </div>
            <div class="col2" >
                <div class="col-12">
                    <div class="row" style="padding-left: 4.5%; padding-right: 3%;">
                    
                    <div class="col-12">
                    <h2 style="text-decoration: underline;">Description</h2>
                    <?php echo $product->description; ?>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col3">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <img src="{{asset('images/'.$logo)}}" alt="" style="width: 86%;">
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <h2 style=" padding-left: 5%; padding-right: 5%;">SIEGEL & STOCKMAN
                        140 58th Street
                        Building B, Unit 6C
                        Brooklyn NY 11220</h2>
                    </div>
                    <div class="col-12 d-flex justify-content-center" style=" transform: rotate(90deg);height: 25rem;">
                        <p style="font-size: 25pt; margin-top: 60%">WOMEN’S 3/4 FORM</p>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="row-cols-1" style="padding-top: 10%;">
                        <span style="font-size: 16pt;">Ref: <u>{{$product->itemref}}</u></span>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center" style=" padding-top: 10.9%;">
                        <img src="{{asset('images/MAGICLINE-2.png')}}" alt="" style="width: 76%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>