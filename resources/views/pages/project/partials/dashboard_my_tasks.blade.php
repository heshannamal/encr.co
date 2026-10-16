@if (count($tasks) > 0)
    <ul class="list-group list-group-flush custom-task-list">
        {{-- <li class="list-group-item d-flex align-items-center">
            <span class="me-3 pr-1">+</span>
            <span>Create Task</span>
        </li> --}}
        @foreach ($tasks as $task)
            <li class="list-group-item d-flex align-items-center">
                <label class="custom-checkbox me-3 mr-2">
                    <input type="checkbox"
                        id="my_task_check_{{ $task->id }}"
                        value="{{ $task->id }}"
                        class="my-task-check"
                        data-discussion-type="{{ $task->discussion_type }}"
                        @if($task->is_completed == 1) checked @endif>
                    <span class="checkmark pointer"></span>
                </label>
                <label class="pointer open-chatbox" data-discussion-type="{{ $task->discussion_type }}" data-value="{{ $task->id }}" style="margin-bottom: 0;">{{ $task->discussion_name }}</label>
            </li>
        @endforeach
    </ul>
@else
<div class="col-md-12 text-center text-muted">
    <i>No Tasks</i>
</div>
@endif
