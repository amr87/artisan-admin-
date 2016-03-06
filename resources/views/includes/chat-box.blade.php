<!-- Chat -->
<div class="col-md-3 chat-area"  data-name="{{Session::get('user_data')['name']}}" data-avatar="{{Session::get('user_data')['avatar']}}">
    <!-- DIRECT CHAT SUCCESS -->
    <div class="box box-success direct-chat direct-chat-success">
        <div class="box-header with-border">
            <h3 class="box-title">Chat With <span class="chat-with"></span></h3>

            <div class="box-tools pull-right">

                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool btn-close-chat"  type="button">
                        <i class="fa fa-times"></i>
                    </button>
                


            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">

            </div>
            <!--/.direct-chat-messages-->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="input-group">
                <input id="message" name="message" placeholder="Type Message ..." class="form-control" type="text">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success btn-flat send-message">Send</button>
                </span>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>
    <!--/.direct-chat -->
</div>
<!-- Chat -->

<input type="hidden" id="myId"  value="{{ Session::get('user_id')}}"/>