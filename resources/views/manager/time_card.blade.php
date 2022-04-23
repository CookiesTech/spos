@include('manager/layouts.links')
@include('manager/layouts.header') 
<style>
 .table > tbody > tr > td{
	 border:1px solid;
 }
</style>
<title>TimeCards</title>

<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Employee  Attendance Master</h2>
</div>
<!-- END PAGE TITLE -->                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">             			
                <div class="panel-body">
				<form  method="post" id="search" action="{{ url('manager/search_attendence')}}">
				    <div class="col-md-3">
				    <select id="emp_id"  class="form-control" name="emp_id" required>
				      <option value="">Select Type</option> 
				      <option value="all">ALL</option>
				      @foreach($emp_list as $e)
				      <option value="{{$e->id}}">{{$e->fname}}({{$e->id}})</option>
				      @endforeach
				    </select>
				</div>
				<div class="col-md-3"> {{ csrf_field() }}<input type="date" id="from" name="from" class="form-control" required ></div>
				<div class="col-md-3"><input type="date" id="to"  class="form-control" name="to" required>
				</div>
				<div class="col-md-3"> 
				<input type="submit" class="btn" value="search"></div></form><a href="{{url('manager/attendence_list')}}" class="btn btn-primary" style="float:right">back</a><br>
                    <br>
					<table id="customers2" class="table datatable">
                        <thead>
                            <tr>
                                <th>
                                    S.No
                                </th>
                                <th>
                                    Emp Id
                                </th><th>
                                   Name
                                </th>
                                <th>
                                    Clock in Date
                                </th>
                                <th>
                                    Clock Out Date
                                </th>
                                <th>
                                    Total Time
                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                        </thead>
                         <tbody id="table_data">
                            <?php $i = 1;?>
                            @foreach($datas as $data)
                            <tr>
                               <td>
                                    {{ $i }}
                                </td>
                                 <td>
                                    {{ $data->emp_id }}
                                </td>
                                 <td>
                                    {{ $data->fname }}{{ $data->lname }}
                                </td>
                                <td>
                                    {{ $data->clock_in_date }}
                                </td>
                                <td>
                                    {{ $data->clock_out_date }}
                                </td>
                                <td>
                                    {{ $data->total_time }}
                                </td>
                                <td>
                                    <span class="label label-success">{{ $data->status }}</span>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>                                    

                </div>
            </div>


        </div>
    </div>

</div>                              
</div>            
<!-- END PAGE CONTENT -->
</div>
</div>
</div>
@include('manager/layouts.footer')
