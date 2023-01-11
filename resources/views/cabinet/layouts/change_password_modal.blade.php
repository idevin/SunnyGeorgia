<div class="modal fade" id="user_password_change" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Password change
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">
												&times;
											</span>
                </button>
            </div>
            <form action="{{route('cabinet:profile.change_password')}}" method="post">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="form-group m-form__group row">
                        <label for="input_current_password" class="col-3 col-form-label">
                            Current password
                        </label>
                        <div class="col-9">
                            <input class="form-control m-input" id="input_current_password" type="password" name="current_password" required>

                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="input_password" class="col-3 col-form-label">
                            Password
                        </label>
                        <div class="col-9">
                            <input class="form-control m-input" id="input_password" type="password" name="password" required>

                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="input_password_confirm" class="col-3 col-form-label">
                            Password confirm
                        </label>
                        <div class="col-9">
                            <input class="form-control m-input" id="input_password_confirm" type="password" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Change
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>