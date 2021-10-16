<div class="modal" id="addTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="overlay hide"></div>
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title">Add New Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="task-name">Task Name </label>
                    <input type="text" name="task-name" id="task-name" class=" form-control">
                </div>
                <div class="form-group">
                    <label for="visibility">Visibility</label>
                    <select name="visibility" id="visibility" class=" form-control" onchange="visibilityChange('addTaskModal', this.value)">
                        <option value="1">
                            <i class="fas fa-group"></i>
                            Public
                        </option>
                        <option value="2">
                            <i class="fas fa-lock"></i>
                            Only Me
                        </option>
                        <option value="3">
                            <i class="fas fa-gear"></i>
                            Custom
                        </option>
                    </select>
                </div>
                <div class="form-group custom-users-selector hide">
                    <label for="custom-users">Custom Users</label>
                    <select name="custom-users[]" id="custom-users" class="form-control" multiple="multiple">
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="createTask()">Create</button>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="editTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="overlay hide"></div>
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title">Edit Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="taskid" value="">
                <div class="form-group">
                    <label for="task-name">Task Name </label>
                    <input type="text" name="task-name" id="task-name" class=" form-control">
                </div>
                <div class="form-group">
                    <label for="visibility">Visibility</label>
                    <select name="visibility" id="visibility" class="form-control"  onchange="visibilityChange('editTaskModal', this.value)">
                        <option value="1">
                            <i class="fas fa-group"></i>
                            Public
                        </option>
                        <option value="2">
                            <i class="fas fa-lock"></i>
                            Only Me
                        </option>
                        <option value="3">
                            <i class="fas fa-gear"></i>
                            Custom
                        </option>
                    </select>
                </div>
                <div class="form-group custom-users-selector hide">
                    <label for="custom-users">Custom Users</label>
                    <select name="custom-users[]" id="custom-users" class="form-control" multiple="multiple">
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="updateTask()">Update</button>
      </div>
    </div>
  </div>
</div>
