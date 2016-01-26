@extends('layouts/default')

@section('content')

@if($error)
<div class="alert alert-danger">{{$item['data']}}</div>
@else
@if(!empty($data->data))
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
        <form class="sidebar-form" method="get" action="#">
        <div class="input-group">
          <input type="text" placeholder="Search..." class="form-control" name="q">
              <span class="input-group-btn">
                <button class="btn btn-flat" id="search-btn" name="search" type="submit"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
        <p> <span class="badge bg-green">Total Users: <?php echo $data->total;?></span></p>
        <table  class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Display Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->data as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->display_name }}</td>
                    <td>{{ $user->email }}</td>
                    <?php
                    if (!empty($user->roles)):
                        $roles = [];
                        foreach ($user->roles as $role):
                            $roles[] = $role->label;
                        endforeach;
                    endif;
                    ?>
                    <td><?php echo!empty($user->roles) ? implode(" , ", $roles) : ""; ?></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        
      <?php echo $paginator;?>
        
    </div>
    @else
    <div class="alert alert-danger">No Users Found</div>
    @endif
    @endif

</div>
@section('footer_scripts')          

@endsection

@endsection
