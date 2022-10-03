<div class="modal fade text-left" id="userEdit{{ $users->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin_edit_user', $users->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6 col-md-12 col-12 mb-1">
                            <fieldset class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $users->first_name }}" placeholder="First Name">
                            </fieldset>
                        </div>
                        <div class="col-xl-6 col-md-12 col-12 mb-1">
                            <fieldset class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $users->last_name }}" placeholder="Last Name">
                            </fieldset>
                        </div>
                        <div class="col-xl-12 col-md-12 col-12 mb-1">
                            <fieldset class="form-group">
                                <label>Enter Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $users->email }}" placeholder="Enter Email">
                            </fieldset>
                        </div>
                        <div class="col-xl-6 col-md-12 col-12 mb-1">
                            <fieldset class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                            </fieldset>
                        </div>
                        <div class="col-xl-6 col-md-12 col-12 mb-1">
                            <fieldset class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button></button>
                </div>
            </form>
        </div>
    </div>
</div>