<li>
    <span class="folder-toggle" style="cursor:pointer; user-select:none;">
        <span class="toggle-sign">[+]</span> 📁 {{ $node['path'] ?: 'root' }}
    </span>
    <ul class="nested" style="display:none; margin-left:20px;">
        @foreach ($node['directories'] as $child)
            @include('pages.settings.folder_structure.partials.folder_node', ['node' => $child])
        @endforeach

        @foreach ($node['files'] as $file)
            <li>
                📄
                @php
                    $filePath = trim($node['path'], '/') !== ''
                        ? trim($node['path'], '/') . '/' . $file
                        : $file;
                @endphp
                <a href="{{ route('configuration.openStorageFile', ['path' => $filePath]) }}" target="_blank" style="text-decoration:none;">
                    {{ $file }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
