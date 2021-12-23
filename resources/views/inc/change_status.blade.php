<ul class="dropdown-menu {{isset($isWide) ? 'addonDropdownCenteringWide' : ''}}" role="menu">
    {!! Form::open(['action' => ['App\Http\Controllers\IssueController@changeStatus', $project->id, $post->issue_number]]) !!}
    {{Form::hidden('_method', 'PUT')}}
    @if ($post->status != 'wip')
    <li><button class='statusDot wip' type="submit" name="action" value="option-wip"></button></li>
    @endif
    @if ($post->status != 'onHold')
        @if($post->status != 'wip')
        <li class="divider"></li>
        @endif
    <li><button class='statusDot onHold' type="submit" name="action" value="option-onHold"></button></li>
    @endif
    @if ($post->status != 'unassigned')
    <li class="divider"></li>
    <li><button class='statusDot unassigned' type="submit" name="action" value="option-unassigned"></button></li>
    @endif
    @if ($post->status != 'closed')
    <li class="divider"></li>
    <li><button class='statusDot closed' type="submit" name="action" value="option-closed"></button></li>
    @endif
    {!! Form::close() !!}
</ul>