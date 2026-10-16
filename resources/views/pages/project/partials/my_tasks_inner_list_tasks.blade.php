@foreach ($myTasks as $myTask)
    @php
        $disTypeClass = str_replace('_', '-', $myTask->discussion_type);

        $priorityRaw = $myTask->priority ?? null;
        $priorityLabel = '';
        $priorityClass = '';

        if (is_numeric($priorityRaw)) {
            $priorityVal = intval($priorityRaw);

            if ($priorityVal == 1) {
                $priorityLabel = 'LOW';
                $priorityClass = 'low';
            } elseif ($priorityVal == 2) {
                $priorityLabel = 'MEDIUM';
                $priorityClass = 'medium';
            } elseif ($priorityVal == 3) {
                $priorityLabel = 'HIGH';
                $priorityClass = 'high';
            } elseif ($priorityVal == 4) {
                $priorityLabel = 'CRITICAL';
                $priorityClass = 'critical';
            }
        } elseif (is_string($priorityRaw)) {
            $p = strtolower($priorityRaw);

            if (strpos($p, 'low') !== false) {
                $priorityLabel = 'LOW';
                $priorityClass = 'low';
            } elseif (strpos($p, 'medium') !== false) {
                $priorityLabel = 'MEDIUM';
                $priorityClass = 'medium';
            } elseif (strpos($p, 'high') !== false) {
                $priorityLabel = 'HIGH';
                $priorityClass = 'high';
            } elseif (strpos($p, 'critical') !== false) {
                $priorityLabel = 'CRITICAL';
                $priorityClass = 'critical';
            }
        }
    @endphp

    <tr id="{{ $myTask->discussion_type . '_' . $myTask->id }}">
        <td class="align-content-center border_left_unset open-chatbox"
            data-discussion-type="{{ $myTask->discussion_type }}"
            data-value="{{ $myTask->id }}"
            data-section="{{ $myTask->section_id }}"
            data-order-id="{{ $myTask->project_id }}">

            <div class="d-flex align-items-start gap-2">
                <input type="checkbox"
                       class="main-check-list margin_right circle_checkbox {{ $disTypeClass }}-check {{ $disTypeClass }}-check-id-{{ $myTask->id }}"
                       data-discussion-type="{{ $myTask->discussion_type }}"
                       value="{{ $myTask->id }}"
                       @if($myTask->is_completed == 1) checked @endif>

                <div class="task-name-group d-flex align-items-center gap-2">
                    <div class="input-wrapper my-task">
                        <input type="text"
                               disabled
                               class="border-0 my-task-title {{ $disTypeClass }}-name {{ $disTypeClass }}-name-id-{{ $myTask->id }}"
                               data-discussion-type="{{ $myTask->discussion_type }}"
                               data-id="{{ $myTask->section_id }}"
                               data-order="{{ $myTask->project_id }}"
                               data-discussion="{{ $myTask->id }}"
                               value="{{ $myTask->discussion_name }}">

                        <!-- <div class="task-input-overlay"></div> -->
                        <div class="task-input-overlay">{{ $myTask->discussion_name }}</div>
                    </div>

                   
                </div>
            </div>
        </td>
        <td class="align-content-center">
            @if($priorityLabel)
                <span class="priority-indicator {{ $priorityClass }}"
                    data-priority="{{ $priorityRaw }}"
                    title="{{ $priorityLabel }}">
                    <span class="priority-dot"></span>
                </span>
            @endif
        </td>

        <td class="align-content-center">
            <input type="date"
                   class="border-0 {{ $disTypeClass }}-due-date {{ $disTypeClass }}-due-date-id-{{ $myTask->id }} datepicker"
                   style="width: 6rem;"
                   data-id="{{ $myTask->section_id }}"
                   data-order="{{ $myTask->project_id }}"
                   data-discussion="{{ $myTask->id }}"
                   value="{{ $myTask->due_date }}">
        </td>

        <td class="align-content-center">
            @php
                $project = isset($projectsById) ? ($projectsById[$myTask->project_id] ?? null) : null;
            @endphp

            @if ($project)
                <a href="{{ route('projects.view', $myTask->project_id) }}" style="text-decoration: none;">
                    <div class="d-flex align-items-center">
                        <span class="project-index-projecticon me-2"
                              style="background-color: {{ $project->project_color ?? '#b5b5b5' }}">

                            @if (!empty($project->project_icon_url))
                                <img src="{{ $project->project_icon_url }}"
                                     alt="Project Icon"
                                     style="width: 100%; height: 100%; object-fit: contain;">
                            @else
                                <i class="fa fa-server" style="color:#fff; font-size: smaller;"></i>
                            @endif
                        </span>

                        <div>
                            <div style="font-weight: 600;">
                                {{ $project->display_name ?? $project->project_name }}
                            </div>
                        </div>
                    </div>
                </a>
            @else
                <span class="text-muted"><i>N/A</i></span>
            @endif
        </td>

        <td class="align-content-center open-chatbox"
            data-discussion-type="{{ $myTask->discussion_type }}"
            data-value="{{ $myTask->id }}">

            @php
                $assignedUser = null;

                if (
                    isset($authUserId)
                    && !empty($myTask->assigned_by)
                    && intval($myTask->assigned_by) === intval($authUserId)
                ) {
                    $assignedUser = new \stdClass();
                    $assignedUser->profile_pic = auth()->user()->profile_pic;
                    $assignedUser->name = 'You';
                } elseif (isset($assignedByUsers) && !empty($myTask->assigned_by)) {
                    $assignedUser = $assignedByUsers[$myTask->assigned_by] ?? null;
                }
            @endphp

            @if ($assignedUser)
                <div class="d-flex align-items-center">
                    <img src="{{ asset($assignedUser->profile_pic) }}"
                         class="user-avatar"
                         style="">

                    <span class="text-gray" style="padding-left: 15px;">
                        {{ $assignedUser->name }}
                    </span>
                </div>
            @endif
        </td>

        <td class="align-content-center">
            @can("delete discussion")
                <button type="button"
                        class="btn btn-sm delete-{{ $disTypeClass }}"
                        style="background: none;"
                        data-id="{{ $myTask->section_id }}"
                        data-order="{{ $myTask->project_id }}"
                        data-discussion="{{ $myTask->id }}"
                        data-discussionName="{{ $myTask->discussion_name }}"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Delete this discussion">

                    <i class="fa fas fa-trash trash_btn"></i>

                </button>
            @endcan
        </td>
    </tr>
@endforeach
