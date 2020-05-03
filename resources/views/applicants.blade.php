@extends('layout')
@section('content')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <!-- <h1 class="h2">আবেদনকারী</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Import</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
          </div> -->

    <!-- <form method="post" enctype="multipart/form-data" action="{{ url('/import_data') }}">
    {{ csrf_field() }}
    <div class="form-group">
        <input type="file" name="select_file" required />

        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
    </div>
   </form> -->

  </div>


        <h2 class="float-left">মোট আবেদনকারী</h2>

        <form method="get" action="{{route('sort_help_date')}}">
        {{ csrf_field() }}
        <div class="float-right" style="margin-bottom: 20px;">
          <h6>সহায়তা প্রদানের তারিখ : </h6>
          <input type="date" name="help_date" required>
          <input type="submit">
          </div>
        </form>
        <!-- <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav> -->
        <form method="post" action="{{route('checkall')}}">
        {{ csrf_field() }}
        <input type="hidden" name="page" value="{{$document->currentPage()}}">
        <div class="table-responsive all-applicants-list">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                  <th>ক্র.নং</th>
                <th>ইউজার আইডি</th>
                <th>আবেদনের তারিখ</th>
                <th>সহায়তা প্রদানের তারিখ</th>
                <th>ডাক্তার</th>
                <th>নাম</th>
                <th>পিতার নাম</th>
                <th>বয়স</th>
                <th>মোবাইল নং</th>
                <th>ওজন</th>
                <th>ঠিকানা</th>
                <th>রোগের বর্ণনা</th>
                <th>ডাক্তারের ধরন</th>
                <th>লিঙ্গ</th>
                <th><div class="status">স্টাটাস</div> <div class="up_down"><a href="{{route('order-by-asc',[$document->currentPage()])}}"><img src="img/icon-up.png" alt=""></a><br><a href="{{route('order-by-desc',[$document->currentPage()])}}"><img src="img/icon-down.png" alt=""></a></div></th>
                <th>অ্যাকশন</th>
                <th>ডাক্তার নিযুক্ত</th>
                <th class=""><input type="checkbox" name="checkAll" onclick="checkallbox(this);">
                  <select name="selected" id="">
                    <option value="approved">Approve</option>
                    <option value="delete">Delete</option>
                    <option value="delivered">Delivered</option>
                  </select>
                  <input class="btn-primary" type="submit" name='action' value="OK">
                </th>
              </tr>
            </thead>
            <tbody>
                @php
                $i = $document->perPage() * ($document->currentPage() - 1);
                @endphp
            @foreach ($document as $doc)

              <tr>
                  <td>{{++$i}}</td>
                <td>{{$doc->user_id}}</td>
                <td>{{$doc->created_at}}</td>
                <td>{{$doc->serve_date}}</td>
                <td>{{$doc->doctor}}</td>
                <td>{{$doc->name}}</td>
                <td>{{$doc->father}}</td>
                <td>{{$doc->age}}</td>
                <td>{{$doc->mobile}}</td>
                <td>{{$doc->weight}}</td>
                <td>{{$doc->address}}</td>
                <td>{{$doc->roger_bornona}}</td>
                <td>{{$doc->doctor_type}}</td>
                <td>{{$doc->gender}}</td>
                @if($doc->status ==0)
                <td>Pending</td>
                @elseif($doc->status ==1)
                <td>Delivered</td>
                @elseif($doc->status ==2)
                <td>Approved</td>
                @endif

                <td class="paid_btn-139">

                  <a href='{{route("approve",[$doc->user_id,$document->currentPage()])}}' onclick="return confirm('Are you sure you want to approve this item?');" id="approved" class="btn btn-primary btn-sm">Approve</a>
                  <a href='{{route("delete",[$doc->user_id,$document->currentPage()])}}' onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm">Delete</a>
                </td>
                <td>
                <select name="selected_doctor" id="selected_doctor_id{{$doc->user_id}}">
                @foreach ($doctors as $doctor)
                    <option  value="{{$doctor->name}}">{{$doctor->name}}</option>
                @endforeach
                </select>
                  <a href='#' id="selected_btn" class="btn btn-primary btn-sm selected_btn" onClick="GetSelectedItem('selected_doctor_id{{$doc->user_id}}','{{$doc->user_id}}', '{{$document->currentPage()}}');">OK</a>
                </td>
                <td><input style="margin-top: 7px;" type="checkbox" name="chkbox[]" value='{{$doc->user_id}}'></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </form>
        <div class="footer-nav">
           {{ $document->appends(request()->except('page'))->links() }}
        </div>

        <footer class="navbar fixed-bottom navbar-expand-sm">
          <p>Developed by <a href="http://futureitpark.com/">Future IT Park</a> Contact us for any emergency support - 01750-106455</p>
        </footer>

      </main>

      <script type="text/javascript">

         function GetSelectedItem(el,id,current_page)
        {
            var e = document.getElementById(el);
            var strSel = e.options[e.selectedIndex].value ;
            let url = '{{route("assign_doctor",["name" => ":name", "id" => ":id", "page" => ":page"])}}'
            url = url.replace(':name', strSel);
            url = url.replace(':id', id);
            url = url.replace(':page', current_page);
            alert('Do You Want to assign '+strSel +' ???');
            document.location.href=url;
        }

      </script>
@endsection

