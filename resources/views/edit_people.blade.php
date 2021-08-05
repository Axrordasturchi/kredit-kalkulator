@extends('layouts.menyu')

@section('content')

   <!-- Main content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Natijani o'zgartirish</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Asosiy</a></li>
              <li class="breadcrumb-item active">Tekshiruv</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Malumotlarni to'g'irlang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/natija_edit_save/{{$peoples->id}}" role="form" id="quickForm" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label>Natija</label>
                    <select class="form-control select2" name="result" style="width: 100%;">
                        <option>...tanlang...</option>
                        <option value="1">Taminlandi</option>
                        <option value="0">Taminlanmadi</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">O'zgartirish</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->
  </div>
  @endsection